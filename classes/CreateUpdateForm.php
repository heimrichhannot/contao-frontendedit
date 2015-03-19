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

class CreateUpdateForm extends \HeimrichHannot\FormHybrid\Form
{
	public function __construct($objModule, $instanceId = 0)
	{
		$this->strMethod = FORMHYBRID_METHOD_POST;
		$objModule->formHybridTemplate = 'formhybrid_frontendedit';

		parent::__construct($objModule, $instanceId);
	}
	
	protected function onSubmitCallback(\DataContainer $dc) {
		$this->submission = $dc;
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
}