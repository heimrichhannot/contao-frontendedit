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

class FrontendEdit extends \Controller {

	public static function getMembersAsOptions()
	{
		$arrOptions = array();

		if (($objMembers = \MemberModel::findAll()) !== null)
		{
			while ($objMembers->next())
			{
				$arrOptions[$objMembers->id] = $objMembers->firstname . ' ' . $objMembers->lastname . ' (' .
					($objMembers->email ? $objMembers->email . ', ' : '') . 'ID: ' . $objMembers->id . ')';
			}
		}

		asort($arrOptions);

		return $arrOptions;
	}

}