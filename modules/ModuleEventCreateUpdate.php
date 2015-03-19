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
	public function __construct($objModule, $strColumn='main')
	{
		$objModule->formHybridAddDefaultValues = true;
		$objModule->formHybridDefaultValues = array_merge(
			deserialize($this->formHybridDefaultValues, true),
			array(
				array(
					'field' => 'pid',
					'value' => $objModule->pidEvent
				),
				array(
					'field' => 'useMemberAuthor',
					'value' => true
				),
				array(
					'field' => 'memberAuthor',
					'value' => \FrontendUser::getInstance()->id
				),
				array(
					'field' => 'source',
					'value' => 'default'
				)
			)
		);
		parent::__construct($objModule, $strColumn);
	}
}
