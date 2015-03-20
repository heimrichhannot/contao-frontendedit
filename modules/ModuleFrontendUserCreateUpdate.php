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

class ModuleFrontendUserCreateUpdate extends ModuleMemberCreateUpdate
{
	public function generate()
	{
		$this->instanceId = \FrontendUser::getInstance()->id;
		return parent::generate();
	}
}
