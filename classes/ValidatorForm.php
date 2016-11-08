<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

use HeimrichHannot\Ajax\Ajax;
use HeimrichHannot\FormHybrid\Form;
use HeimrichHannot\StatusMessages\StatusMessage;

class ValidatorForm extends ReaderForm
{
	public function modifyDC(&$arrDca = null)
	{
		foreach ($this->arrEditable as $strField)
		{
			if (in_array('bootstrapper', \ModuleLoader::getActive()))
			{
				$arrDca['fields'][$strField]['eval']['invisible'] = true;
			}
			else
			{
				$arrDca['fields'][$strField]['inputType'] = 'hidden';
			}
		}
	}

	protected function onSubmitCallback(\DataContainer $objDc) {
		parent::onSubmitCallback($objDc);

		if ($this->publishOnValid)
		{
			$strPublishedField = $this->publishedField;

			if ($this->publishedField)
			{
				$strModelClass = \Model::getClassFromTable($this->strTable);

				$objInstance = $strModelClass::findByPk($objDc->objActiveRecord->id);

				$objInstance->{$strPublishedField} = $this->invertPublishedField ? '' : 1;

				$objInstance->save();
			}
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
		$arrDca = $GLOBALS['TL_DCA'][$this->strTable];
		\System::loadLanguageFile($this->strTable);

		StatusMessage::addError(
			sprintf($GLOBALS['TL_LANG']['frontendedit']['validationFailed'],
				'<ul>' . implode('', array_map(function($val) use ($arrDca) {
					return '<li>' . ($arrDca['fields'][$val]['label'][0] ?: $val) . '</li>';
				}, $arrInvalidFields))) . '</ul>',
			$this->objModule->id,
			'validation-failed'
		);

		if (!Ajax::isRelated(Form::FORMHYBRID_NAME))
		{
			\Controller::reload();
		}
		else
		{
			$this->Template->message = StatusMessage::generate($this->objModule->id);
		}
	}
}