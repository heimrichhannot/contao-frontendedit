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

class ModuleDetails extends \Module
{
	protected $strTemplate = 'mod_frontendedit_details';
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

		$this->intId = $this->intId ?: \Input::get('id');

		switch ($this->noIdBehavior && !$this->intId)
		{
			case 'create_until':
				$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);

				if ($this->existingConditions && !empty($arrConditions = deserialize($this->existingConditions, true)))
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
						\Controller::redirect(Environment::addParameterToUri(Environment::getUrl(), 'id', $objItem->id));
					}
				}
				break;
			case 'redirect':
				$this->intId = $this->redirectId;
				break;
		}

		if ($this->intId)
		{
			if ($this->checkPermission($this->intId))
				$objForm = new DetailsForm($this->objModel, $this->arrSubmitCallbacks, $this->intId);
			else
			{
				$this->Template->noPermission = true;
				$this->Template->errorMessage = $GLOBALS['TL_LANG']['frontendedit']['noPermission'];
				return;
			}
		}
		else
			$objForm = new DetailsForm($this->objModel, $this->arrSubmitCallbacks);
		
		$this->Template->form = $objForm->generate();
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
}
