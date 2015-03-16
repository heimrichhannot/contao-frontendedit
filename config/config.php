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

/**
 * Frontend modules
 */
array_insert(
	$GLOBALS['FE_MOD'], count($GLOBALS['FE_MOD']) - 1, array(
		'Frontend-Bearbeitung' => array(
			'frontendedit_create_update' => 'HeimrichHannot\FrontendEdit\ModuleCreateUpdate',
			'frontendedit_event_create_update' => 'HeimrichHannot\FrontendEdit\ModuleEventCreateUpdate',
			'frontendedit_list'          => 'HeimrichHannot\FrontendEdit\ModuleList',
		)
	)
);