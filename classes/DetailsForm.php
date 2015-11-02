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

class DetailsForm extends \HeimrichHannot\FormHybrid\Form
{
	public function __construct($objModule, array $submitCallbacks = array(), $intId = 0)
	{
		$this->strMethod = FORMHYBRID_METHOD_POST;
		$objModule->formHybridTemplate = $objModule->formHybridTemplate ?: 'formhybrid_default';
		$objModule->initiallySaveModel = true;
		$objModule->strFormClass = 'jquery-validation';
		$this->arrSubmitCallbacks = $submitCallbacks;

		parent::__construct($objModule, $intId);
	}

	public function generate()
	{
		$strResult = parent::generate();
		if ($this->intId && $this->setPageTitle)
		{
			global $objPage;
			$objPage->pageTitle = $this->objModel->{$this->pageTitleField};
		}
		return $strResult;
	}
	
	protected function onSubmitCallback(\DataContainer $dc) {
		$this->submission = $dc;

		if (is_array($this->arrSubmitCallbacks) && !empty($this->arrSubmitCallbacks))
		{
			foreach ($this->arrSubmitCallbacks as $arrCallback)
			{
				if (is_array($arrCallback) && !empty($arrCallback))
				{
					$arrCallback[0]::$arrCallback[1]($dc);
				}
			}
		}
	}
	
	protected function compile() {}
	
	protected function generateSubmitField()
	{
		$this->arrFields[FRONTENDEDIT_BUTTON_SAVE] = $this->generateField(FRONTENDEDIT_BUTTON_SAVE, array(
			'inputType' => 'submit',
			'label'		=> &$GLOBALS['TL_LANG']['frontendedit'][FRONTENDEDIT_BUTTON_SAVE]
		));

//		$this->arrFields[FRONTENDEDIT_BUTTON_SAVE_RETURN] = $this->generateField(FRONTENDEDIT_BUTTON_SAVE_RETURN, array(
//			'inputType' => 'submit',
//			'label'		=> &$GLOBALS['TL_LANG']['frontendedit'][FRONTENDEDIT_BUTTON_SAVE_RETURN],
//			'eval'		=> array('class' => 'btn btn-gray')
//		));
	}
}