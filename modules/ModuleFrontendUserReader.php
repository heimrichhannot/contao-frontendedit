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

class ModuleFrontendUserReader extends ModuleReader
{
	public function generate()
	{
		$this->intId = \FrontendUser::getInstance()->id;
		return parent::generate();
	}
}
