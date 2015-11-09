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

use HeimrichHannot\StatusMessages\StatusMessage;

class ValidatorForm extends DetailsForm
{
	protected function modifyDC()
	{
		foreach ($this->arrEditable as $strField)
		{
			$this->dca['fields'][$strField]['inputType'] = 'hidden';
		}
	}

	protected function onSubmitCallback(\DataContainer $objDc) {
		parent::onSubmitCallback($objDc);
		$strPublishedField = $this->objModule->publishedField;

		if ($this->objModule->publishedField)
		{
			$strModelClass = \Model::getClassFromTable($this->objModule->formHybridDataContainer);

			$objInstance = $strModelClass::findByPk($objDc->activeRecord->id);

			$objInstance->{$strPublishedField} = $this->objModule->invertPublishedField ? '' : 1;

			$objInstance->save();
		}
	}

	protected function generateSubmitField()
	{
		$this->arrFields[FRONTENDEDIT_BUTTON_SUBMIT] = $this->generateField(FRONTENDEDIT_BUTTON_SUBMIT, array(
			'inputType' => 'submit',
			'label'		=> &$GLOBALS['TL_LANG']['frontendedit']['submit']
		));
	}

	public function runOnValidationError($arrInvalidFields)
	{
		StatusMessage::addError(
			sprintf($GLOBALS['TL_LANG']['frontendedit']['validationFailed'], implode(', ', array_map(function($val) {
				return $GLOBALS['TL_DCA'][$this->formHybridDataContainer]['fields'][$val]['label'][0] ?: $val;
			}, $arrInvalidFields))),
			$this->objModule->id
		);
		\Controller::reload();
	}
}