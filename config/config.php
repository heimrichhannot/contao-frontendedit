<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Heimrich & Hannot GmbH
 *
 * @package frontendedit
 * @author  Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

/**
 * Constants
 */
define('FRONTENDEDIT_BUTTON_SAVE', 'save');
define('FRONTENDEDIT_BUTTON_SAVE_RETURN', 'save_return');
define('FRONTENDEDIT_ACT_DELETE', 'delete');
define('FRONTENDEDIT_ACT_PUBLISH', 'publish');
define('FRONTENDEDIT_BUTTON_SUBMIT', 'submit');

// module names
define('MODULE_FRONTENDEDIT_READER', 'frontendedit_reader');
define('MODULE_FRONTENDEDIT_LIST', 'frontendedit_list');
define('MODULE_FRONTENDEDIT_FRONTENDUSER_READER', 'frontendedit_frontenduser_reader');
define('MODULE_FRONTENDEDIT_MEMBER_LIST', 'frontendedit_member_list');
define('MODULE_FRONTENDEDIT_NEWS_LIST', 'frontendedit_news_list');
define('MODULE_FRONTENDEDIT_FORM_VALIDATOR', 'frontendedit_form_validator');

/**
 * Frontend modules
 */
array_insert(
	$GLOBALS['FE_MOD'], count($GLOBALS['FE_MOD']) - 1, [
		'frontendedit' => [
			MODULE_FRONTENDEDIT_READER => 'HeimrichHannot\FrontendEdit\ModuleReader',
			MODULE_FRONTENDEDIT_LIST          => 'HeimrichHannot\FrontendEdit\ModuleList',
			MODULE_FRONTENDEDIT_FRONTENDUSER_READER => 'HeimrichHannot\FrontendEdit\ModuleFrontendUserReader',
			MODULE_FRONTENDEDIT_MEMBER_LIST => 'HeimrichHannot\FrontendEdit\ModuleMemberList',
			MODULE_FRONTENDEDIT_NEWS_LIST => 'HeimrichHannot\FrontendEdit\ModuleNewsList',
			MODULE_FRONTENDEDIT_FORM_VALIDATOR => 'HeimrichHannot\FrontendEdit\ModuleFormValidator'
        ]
                      ]
);

/**
 * Assets
 */
if (TL_MODE == 'FE')
{
	// css
	$GLOBALS['TL_CSS']['frontendedit'] = 'system/modules/frontendedit/assets/css/style.css|static';

	// js
	$GLOBALS['TL_JAVASCRIPT']['frontendedit'] = 'system/modules/frontendedit/assets/js/jquery.frontendedit.js|static';
}