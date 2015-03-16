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
use HeimrichHannot\FormHybrid\Submission;
use HeimrichHannot\XCommonEnvironment;

class ModuleCreateUpdate extends \Module
{
	protected $strTemplate = 'mod_frontendedit_create_update';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$this->Templateemplate = new \BackendTemplate('be_wildcard');

			$this->Templateemplate->wildcard = '### FRONTENDEDIT CREATE/UPDATE ###';
			$this->Templateemplate->title = $this->headline;
			$this->Templateemplate->id = $this->id;
			$this->Templateemplate->link = $this->name;
			$this->Templateemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $this->Templateemplate->parse();
		}

		\DataContainer::loadDataContainer($this->formHybridDataContainer);
		\System::loadLanguageFile($this->formHybridDataContainer);
		
		return parent::generate();
	}
	
	protected function compile()
	{
		$this->Template->headline = $this->headline;
		$this->Template->hl = $this->hl;
		$this->intId = $this->objModel->instanceId = \Input::get('id');
		$this->objModel->arrDefaultValues = $this->arrDefaultValues;

		$this->loadInstance($this->intId);

		$objForm = new CreateUpdateForm($this->objModel);
		
		$this->Template->form = $objForm->generate();

		// if created, redirect to the corresponding url
		if ($objForm->isSubmitted() && !$objForm->doNotSubmit() && !$this->intId)
			\Controller::redirect(XCommonEnvironment::addParameterToUri(XCommonEnvironment::getCurrentUrl(), 'id', $objForm->getInstanceId()));
	}

	protected function loadInstance($intId)
	{
		if (!$intId)
			return;

		$strModel = $GLOBALS['TL_MODELS'][$this->formHybridDataContainer];
		if (($objModel = call_user_func_array(array($strModel, 'findByPk'), array($intId))) !== null)
		{
			$this->arrDefaultValues = deserialize($this->arrDefaultValues, true);

			// add instance properties as "default" values
			$arrInstanceValues = array();
			foreach (array_merge(array_keys($this->arrDefaultValues), deserialize($this->formHybridEditable, true)) as $strName)
			{
				if (isset($objModel->$strName))
					$arrInstanceValues[$strName] = $objModel->{$strName};
				else
					$arrInstanceValues[$strName] = $this->arrDefaultValues[$strName];
			}

			$this->objModel->arrDefaultValues = array_merge($this->arrDefaultValues, $arrInstanceValues);
		}
	}
}
