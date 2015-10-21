<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package Frontendedit
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'HeimrichHannot\FrontendEdit\ModuleMemberList'          => 'system/modules/frontendedit/modules/ModuleMemberList.php',
	'HeimrichHannot\FrontendEdit\ModuleDetails'             => 'system/modules/frontendedit/modules/ModuleDetails.php',
	'HeimrichHannot\FrontendEdit\ModuleFrontendUserDetails' => 'system/modules/frontendedit/modules/ModuleFrontendUserDetails.php',
	'HeimrichHannot\FrontendEdit\ModuleMemberDetails'       => 'system/modules/frontendedit/modules/ModuleMemberDetails.php',
	'HeimrichHannot\FrontendEdit\ModuleList'                => 'system/modules/frontendedit/modules/ModuleList.php',

	// Classes
	'HeimrichHannot\FrontendEdit\FrontendEdit'              => 'system/modules/frontendedit/classes/FrontendEdit.php',
	'HeimrichHannot\FrontendEdit\DetailsForm'               => 'system/modules/frontendedit/classes/DetailsForm.php',

	// Models
	'HeimrichHannot\FrontendEdit\FrontendEditQueryBuilder'  => 'system/modules/frontendedit/models/FrontendEditQueryBuilder.php',
	'HeimrichHannot\FrontendEdit\FrontendEditModel'         => 'system/modules/frontendedit/models/FrontendEditModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_frontendedit_details'             => 'system/modules/frontendedit/templates',
	'mod_frontendedit_list'                => 'system/modules/frontendedit/templates',
	'mod_frontendedit_list_table_old'      => 'system/modules/frontendedit/templates',
	'frontendedit_list_item_table_default' => 'system/modules/frontendedit/templates',
	'mod_frontendedit_list_table'          => 'system/modules/frontendedit/templates',
));
