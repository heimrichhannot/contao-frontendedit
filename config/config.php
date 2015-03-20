<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 *
 * @package frontendedit
 * @author  Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

/**
 * Constants
 */
define('FRONTENDEDIT_NAME_SAVE', 'save');
define('FRONTENDEDIT_ACT_DELETE', 'delete');
define('FRONTENDEDIT_ACT_PUBLISH', 'publish');

// module names
define('MODULE_FRONTENDEDIT_CREATE_UPDATE', 'frontendedit_create_update');
define('MODULE_FRONTENDEDIT_LIST', 'frontendedit_list');
define('MODULE_FRONTENDEDIT_EVENT_CREATE_UPDATE', 'frontendedit_event_create_update');
define('MODULE_FRONTENDEDIT_EVENT_LIST', 'frontendedit_event_list');
define('MODULE_FRONTENDEDIT_MEMBER_CREATE_UPDATE', 'frontendedit_member_create_update');
define('MODULE_FRONTENDEDIT_FRONTENDUSER_CREATE_UPDATE', 'frontendedit_frontenduser_create_update');
define('MODULE_FRONTENDEDIT_MEMBER_LIST', 'frontendedit_member_list');

/**
 * Frontend modules
 */
array_insert(
	$GLOBALS['FE_MOD'], count($GLOBALS['FE_MOD']) - 1, array(
		'Frontend-Bearbeitung' => array(
			MODULE_FRONTENDEDIT_CREATE_UPDATE => 'HeimrichHannot\FrontendEdit\ModuleCreateUpdate',
			MODULE_FRONTENDEDIT_LIST          => 'HeimrichHannot\FrontendEdit\ModuleList',
			MODULE_FRONTENDEDIT_EVENT_CREATE_UPDATE => 'HeimrichHannot\FrontendEdit\ModuleEventCreateUpdate',
			MODULE_FRONTENDEDIT_EVENT_LIST => 'HeimrichHannot\FrontendEdit\ModuleEventList',
			MODULE_FRONTENDEDIT_MEMBER_CREATE_UPDATE => 'HeimrichHannot\FrontendEdit\ModuleMemberCreateUpdate',
			MODULE_FRONTENDEDIT_FRONTENDUSER_CREATE_UPDATE => 'HeimrichHannot\FrontendEdit\ModuleFrontendUserCreateUpdate',
			MODULE_FRONTENDEDIT_MEMBER_LIST => 'HeimrichHannot\FrontendEdit\ModuleMemberList'
		)
	)
);

/**
 * Assets
 */
if (TL_MODE == 'FE')
{
	// js
	$GLOBALS['TL_CSS']['frontendedit'] = 'system/modules/frontendedit/assets/css/style.css';

	// css
	$GLOBALS['TL_JAVASCRIPT']['frontendedit'] = 'system/modules/frontendedit/assets/js/jquery.frontendedit.js|static';
}