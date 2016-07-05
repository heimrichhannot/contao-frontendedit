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

use HeimrichHannot\Haste\Util\Url;
use HeimrichHannot\StatusMessages\StatusMessage;

class ReaderForm extends \HeimrichHannot\FormHybrid\Form
{
	protected $objReaderModule;

	public function __construct($objModule, array $submitCallbacks = array(), $intId = 0, $objReaderForm)
	{
		$this->strMethod = FORMHYBRID_METHOD_POST;

		// avoid recalling initialize of formhybrid in the async case
		if (\Environment::get('isAjaxRequest'))
		{
			$this->setReset(false);
		}

		$objModule->formHybridTemplate = $objModule->formHybridTemplate ?: 'formhybrid_default';
		$this->objReaderModule = $objReaderForm;
		$objModule->initiallySaveModel = true;

		if ($objModule->addClientsideValidation)
			$objModule->strFormClass = 'jquery-validation';
		
		$this->arrSubmitCallbacks = $submitCallbacks;

		parent::__construct($objModule, $intId);
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

	protected function afterSubmitCallback(\DataContainer $dc)
	{
		// remove previously created locks
		if (in_array('entity_lock', \ModuleLoader::getActive()) && $this->addEntityLock)
		{
			\HeimrichHannot\EntityLock\EntityLockModel::deleteLocks($this->formHybridDataContainer, $this->intId);
		}

		$this->redirectAfterSuccess();
	}

	protected function redirectAfterSuccess()
	{
		if ($this->objModule->jumpToSuccess)
		{
			$strJumpToSuccess = Url::getJumpToPageUrl($this->objModule->jumpToSuccess);

			if ($this->objModule->jumpToSuccessPreserveParams)
			{
				if ($strAct = \Input::get('act'))
					$strJumpToSuccess = Url::addQueryString('act=' . $strAct, $strJumpToSuccess);

				if ($intId = \Input::get('id'))
					$strJumpToSuccess = Url::addQueryString('id=' . $intId, $strJumpToSuccess);

				if (!$this->objModule->deactivateTokens)
				{
					$strJumpToSuccess = Url::addQueryString('token=' . \RequestToken::get(), $strJumpToSuccess);
				}
			}

			StatusMessage::resetAll();

			if (\Environment::get('isAjaxRequest'))
			{
				die(json_encode(array(
					'type' => 'redirect',
					'url' => $strJumpToSuccess
				)));
			}
			else
			{
				\Controller::redirect($strJumpToSuccess);
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

	public function setReaderModule($objModule)
	{
		$this->objReaderModule = $objModule;
	}

	public function modifyDC(&$arrDca = null)
	{
		$this->objReaderModule->modifyDC($arrDca);
	}
}