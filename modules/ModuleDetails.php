<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\FormHybrid\FormHelper;
use HeimrichHannot\HastePlus\Environment;
use HeimrichHannot\StatusMessages\StatusMessage;

class ModuleDetails extends \Module
{
	protected $strTemplate = 'mod_frontendedit_details';
	protected $arrSubmitCallbacks = array();
	protected $strFormClass = 'HeimrichHannot\\FrontendEdit\\DetailsForm';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### FRONTENDEDIT DETAILS ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		\DataContainer::loadDataContainer($this->formHybridDataContainer);
		\System::loadLanguageFile($this->formHybridDataContainer);

		return parent::generate();
	}
	
	protected function compile()
	{
		$this->Template->headline = $this->headline;
		$this->Template->hl = $this->hl;
		$this->strFormId = $this->formHybridDataContainer . '_' . $this->id;
		$strAction = $this->defaultAction ?: \Input::get('act');
		$objForm = null;
		$this->arrEditable = deserialize($this->formHybridEditable, true);

		$this->addDefaultArchive();

		if ($strAction == FRONTENDEDIT_ACT_CREATE)
		{
			if (isset($GLOBALS['TL_HOOKS']['frontendEditAddCreateBehavior']) && is_array($GLOBALS['TL_HOOKS']['frontendEditAddCreateBehavior']))
			{
				foreach ($GLOBALS['TL_HOOKS']['frontendEditAddCreateBehavior'] as $arrCallback)
				{
					$this->import($arrCallback[0]);
					if ($this->$arrCallback[0]->$arrCallback[1]($this) === false)
						return;
				}
			}

			switch ($this->createBehavior)
			{
				case 'create_until':
					$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);
					$arrConditions = deserialize($this->existingConditions, true);

					if ($this->existingConditions && !empty($arrConditions))
					{
						$arrColumns = array();
						$arrValues = array();

						foreach ($arrConditions as $arrCondition)
						{
							$arrColumns[] = $arrCondition['field'] . '=?';
							$arrValues[] = $this->replaceInsertTags($arrCondition['value']);
						}

						if (($objItem = $strItemClass::findOneBy($arrColumns, $arrValues)) !== null)
						{
							\Controller::redirect(Environment::addParametersToUri(Environment::getUrl(),
								array(
									'act' => FRONTENDEDIT_ACT_EDIT,
									'id' => $objItem->id
								)
							));
						}
					}
					break;
				case 'redirect':
					\Controller::redirect(Environment::addParametersToUri(Environment::getUrl(),
						array(
							'act' => FRONTENDEDIT_ACT_EDIT,
							'id' => $this->replaceInsertTags($this->redirectId)
						)
					));
					break;
			}

			$objForm = new $this->strFormClass($this->objModel, $this->arrSubmitCallbacks);
			$this->Template->form = $objForm->generate();
		}
		else
		{
			$this->intId = $this->intId ?: \Input::get('id');

			if (!$this->intId)
			{
				StatusMessage::addError($GLOBALS['TL_LANG']['frontendedit']['noIdFound'], $this->id);
				return;
			}
			else
			{
				if (!$this->checkEntityExists($this->intId))
				{
					StatusMessage::addError($GLOBALS['TL_LANG']['frontendedit']['notExisting'], $this->id);
					return;
				}

				if ($this->checkPermission($this->intId))
				{
					switch ($strAction)
					{
						case FRONTENDEDIT_ACT_EDIT:
							$objForm = new $this->strFormClass($this->objModel, $this->arrSubmitCallbacks, $this->intId);
							$this->Template->form = $objForm->generate();
							break;
						case FRONTENDEDIT_ACT_DELETE:
							$this->deleteItem($this->intId);
							// return to the list
							\Controller::redirect(Environment::removeParametersFromUri(Environment::getUrl(),
								array('act', 'id')
							));
							break;
						default:
							// no param -> show details only
							$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);

							if (($objItem = $strItemClass::findByPk($this->intId)) !== null)
							{
								// redirect on specific field value
								DC_Hybrid::doFieldDependentRedirect($this, $objItem);

								$arrItem = $this->generateFields($objItem);

								$this->Template->item = $this->parseItem($arrItem);
							}
						break;
					}
				}
				else
				{
					StatusMessage::addError($GLOBALS['TL_LANG']['frontendedit']['noPermission'], $this->id);
					return;
				}
			}
		}
	}

	protected function parseItem($arrItem, $strClass='', $intCount=0)
	{
		$objTemplate = new \FrontendTemplate($this->itemTemplate);

		$objTemplate->setData($arrItem);
		$objTemplate->class = $strClass;
		$objTemplate->formHybridDataContainer = $this->formHybridDataContainer;
		$objTemplate->addDetailsCol = $this->addDetailsCol;

		// HOOK: add custom logic
		if (isset($GLOBALS['TL_HOOKS']['parseItems']) && is_array($GLOBALS['TL_HOOKS']['parseItems']))
		{
			foreach ($GLOBALS['TL_HOOKS']['parseItems'] as $callback)
			{
				$this->import($callback[0]);
				$this->$callback[0]->$callback[1]($objTemplate, $arrItem, $this);
			}
		}

		return $objTemplate->parse();
	}

	public function checkEntityExists($intId)
	{
		if ($strItemClass = \Model::getClassFromTable($this->formHybridDataContainer))
			return $strItemClass::findByPk($intId) !== null;
	}

	protected function deleteItem($intId)
	{
		$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);
		if (($objItem = $strItemClass::findByPk($intId)) !== null)
		{
			$dc = new DC_Hybrid($this->formHybridDataContainer, $objItem, $objItem->id);

			// call ondelete callbacks
			if (is_array($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback']))
			{
				foreach ($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback'] as $callback)
				{
					$this->import($callback[0]);
					$this->$callback[0]->$callback[1]($dc);
				}
			}

			$objItem->delete();
		}
	}

	public function checkPermission($intId)
	{
		$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);

		if ($this->addUpdateConditions && ($objItem = $strItemClass::findByPk($intId)) !== null)
		{
			$arrConditions = deserialize($this->updateConditions, true);

			if (!empty($arrConditions))
				foreach ($arrConditions as $arrCondition)
				{
					if ($objItem->{$arrCondition['field']} != $this->replaceInsertTags($arrCondition['value']))
						return false;
				}
		}

		return true;
	}

	public function setSubmitCallbacks(array $callbacks)
	{
		$this->arrSubmitCallbacks = $callbacks;
	}

	protected function addDefaultArchive()
	{
		if ($this->objModel->defaultArchive)
		{
			$this->objModel->formHybridAddDefaultValues = true;
			$this->objModel->formHybridDefaultValues = deserialize($this->objModel->formHybridDefaultValues, true);

			$this->objModel->formHybridDefaultValues = array_merge(array(array(
				'field' => 'pid',
				'value' => $this->objModel->defaultArchive
			)), $this->objModel->formHybridDefaultValues);

			$this->objModel->formHybridDefaultValues = serialize($this->objModel->formHybridDefaultValues);
		}
	}

	protected function generateFields($objItem)
	{
		$arrItem = array();

		// always add id
		$arrItem['fields']['id'] = $objItem->id;

		foreach ($this->arrEditable as $strName)
		{
			$varValue = $objItem->{$strName};
			// Convert timestamps
			if ($varValue != '' && ($this->dca['fields'][$strName]['eval']['rgxp'] == 'date' || $this->dca['fields'][$strName]['eval']['rgxp'] == 'time' || $this->dca['fields'][$strName]['eval']['rgxp'] == 'datim'))
			{
				$objDate = new \Date($varValue);
				$varValue = $objDate->{$this->dca['fields'][$strName]['eval']['rgxp']};
			}

			$arrItem['fields'][$strName] = $varValue;
		}

		// add raw values
		foreach ($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['fields'] as $strField => $arrData)
		{
			$arrItem['raw'][$strField] = $objItem->{$strName};
		}

		if ($this->publishedField)
		{
			$arrItem['isPublished'] = ($this->invertPublishedField ?
				!$objItem->{$this->publishedField} : $objItem->{$this->publishedField});
		}

		return $arrItem;
	}
}
