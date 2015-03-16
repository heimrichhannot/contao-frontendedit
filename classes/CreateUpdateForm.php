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

use HeimrichHannot\XCommonEnvironment;

class CreateUpdateForm extends \HeimrichHannot\FormHybrid\Form
{
	protected $strTemplate = 'formhybrid_frontendedit';

	public function __construct($objModule)
	{
		$this->strMethod = FORMHYBRID_METHOD_POST;

		parent::__construct($objModule);
	}
	
	protected function onSubmitCallback(\DataContainer $dc) {
		$this->submission = $dc;
		$this->createUpdateInstance($dc);
	}
	
	protected function compile() {}
	
	protected function generateSubmitField()
	{
		$this->arrFields[FRONTENDEDIT_NAME_SAVE] = $this->generateField(FRONTENDEDIT_NAME_SAVE, array(
			'inputType' => 'submit',
			'label'		=> &$GLOBALS['TL_LANG']['frontendedit']['save'],
			'eval'		=> array('class' => 'btn btn-green')
		));
	}

	protected function createUpdateInstance($dc)
	{
		$strModel = $GLOBALS['TL_MODELS'][$this->strTable];

		if (!$this->instanceId)
		{
			$objModel = new $strModel();
		}
		else
		{
			$objModel = call_user_func_array(array($strModel, 'findByPk'), array($this->instanceId));

			if ($objModel === null)
				return;
		}

		// set new values (validation has already been done by the formhybrid form
		foreach ($dc->activeRecord as $strField => $varValue)
		{
			$objModel->{$strField} = $varValue;
		}

		// set timestamp
		$objModel->tstamp = time();

		$objModel->save();

		// set id for onsubmit_callbacks
		$dc->id = $objModel->id;
		$this->submission->id = $objModel->id;
	}

	public function getInstanceId()
	{
		return $this->submission->id;
	}
}