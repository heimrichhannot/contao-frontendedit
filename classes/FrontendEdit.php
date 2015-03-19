<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package futureSAX
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
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

	public static function checkPermission($strTable, $intId)
	{
		$strInstanceClass = \Model::getClassFromTable($strTable);

		if (($objInstance = $strInstanceClass::findByPk($intId)) !== null)
		{
			return ($objInstance->useMemberAuthor && $objInstance->memberAuthor == \FrontendUser::getInstance()->id);
		}

		return false;
	}

}