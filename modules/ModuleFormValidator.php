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

use HeimrichHannot\HastePlus\Environment;

class ModuleFormValidator extends \Module
{
	protected $strTemplate = 'mod_frontendedit_form_validator';
	protected $arrSubmitCallbacks = array();

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

		$this->addDefaultArchive();

		if (\Input::get('act') == FRONTENDEDIT_ACT_CREATE || !\Input::get('act'))
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
							'id' => $this->redirectId
						)
					));
					break;
			}

			$objForm = new DetailsForm($this->objModel, $this->arrSubmitCallbacks);
		}
		else
		{
			$this->intId = $this->intId ?: \Input::get('id');

			if (!$this->intId)
			{
				$this->Template->error = true;
				$this->Template->errorMessage = $GLOBALS['TL_LANG']['frontendedit']['noIdFound'];
				return;
			}
			else
			{
				if (!$this->checkEntityExists($this->intId))
				{
					$this->Template->error = true;
					$this->Template->errorMessage = $GLOBALS['TL_LANG']['frontendedit']['notExisting'];
					return;
				}

				if ($this->checkPermission($this->intId))
				{
					$objForm = new DetailsForm($this->objModel, $this->arrSubmitCallbacks, $this->intId);
				}
				else
				{
					$this->Template->error = true;
					$this->Template->errorMessage = $GLOBALS['TL_LANG']['frontendedit']['noPermission'];
					return;
				}
			}
		}

		$this->Template->form = $objForm->generate();
	}

	public function checkEntityExists($intId)
	{
		if ($strItemClass = \Model::getClassFromTable($this->formHybridDataContainer))
			return $strItemClass::findByPk($intId) !== null;
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
}
