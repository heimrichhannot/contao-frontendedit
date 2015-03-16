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

class ModuleEventCreateUpdate extends ModuleCreateUpdate
{
	protected $arrDefaultValues;

	public function __construct($objModule, $strColumn='main')
	{
		$this->arrDefaultValues = array(
			'pid' => $objModule->pidEvent,
			'source' => 'default'
		);
		parent::__construct($objModule, $strColumn);
	}
}
