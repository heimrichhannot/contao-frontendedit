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
define('FRONTENDEDIT_NAME_SAVE_RETURN', 'save_return');
define('FRONTENDEDIT_ACT_DELETE', 'delete');
define('FRONTENDEDIT_ACT_PUBLISH', 'publish');
define('FRONTENDEDIT_NAME_FILTER', 'filter');

// module names
define('MODULE_FRONTENDEDIT_DETAILS', 'frontendedit_details');
define('MODULE_FRONTENDEDIT_LIST', 'frontendedit_list');
define('MODULE_FRONTENDEDIT_FRONTENDUSER_DETAILS', 'frontendedit_frontenduser_details');
define('MODULE_FRONTENDEDIT_MEMBER_LIST', 'frontendedit_member_list');

/**
 * Frontend modules
 */
array_insert(
	$GLOBALS['FE_MOD'], count($GLOBALS['FE_MOD']) - 1, array(
		'frontendedit' => array(
			MODULE_FRONTENDEDIT_DETAILS => 'HeimrichHannot\FrontendEdit\ModuleDetails',
			MODULE_FRONTENDEDIT_LIST          => 'HeimrichHannot\FrontendEdit\ModuleList',
			MODULE_FRONTENDEDIT_FRONTENDUSER_DETAILS => 'HeimrichHannot\FrontendEdit\ModuleFrontendUserDetails',
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