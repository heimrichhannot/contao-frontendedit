<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

class ModuleFrontendUserDetails extends ModuleDetails
{
	public function generate()
	{
		$this->intId = \FrontendUser::getInstance()->id;
		return parent::generate();
	}
}
