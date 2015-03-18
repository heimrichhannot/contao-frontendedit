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

		sort($arrOptions);

		return $arrOptions;
	}

	public static function setFormHybridDataContainer(\DataContainer &$objDataContainer)
	{
		if (($objModule = \ModuleModel::findByPk($objDataContainer->activeRecord->id)) !== null)
		{
			switch ($objModule->type) {
				case MODULE_FRONTENDEDIT_EVENT_CREATE_UPDATE:
				case MODULE_FRONTENDEDIT_EVENT_LIST:
					\Database::getInstance()->prepare('UPDATE tl_module SET formHybridDataContainer = ? WHERE id = ?')->execute('tl_calendar_events', $objDataContainer->activeRecord->id);
					break;
			}
		}
	}

}