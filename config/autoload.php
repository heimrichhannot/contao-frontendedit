<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
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
	'HeimrichHannot\FrontendEdit\ModuleNews'                => 'system/modules/frontendedit/modules/ModuleNews.php',
	'HeimrichHannot\FrontendEdit\ModuleFormValidator'       => 'system/modules/frontendedit/modules/ModuleFormValidator.php',
	'HeimrichHannot\FrontendEdit\ModuleList'                => 'system/modules/frontendedit/modules/ModuleList.php',
	'HeimrichHannot\FrontendEdit\ModuleNewsList'            => 'system/modules/frontendedit/modules/ModuleNewsList.php',

	// Classes
	'HeimrichHannot\FrontendEdit\FrontendEdit'              => 'system/modules/frontendedit/classes/FrontendEdit.php',
	'HeimrichHannot\FrontendEdit\ValidatorForm'             => 'system/modules/frontendedit/classes/ValidatorForm.php',
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
	'frontendedit_item_default'            => 'system/modules/frontendedit/templates',
	'mod_frontendedit_list'                => 'system/modules/frontendedit/templates',
	'frontendedit_list_item_table_default' => 'system/modules/frontendedit/templates',
	'mod_frontendedit_list_table'          => 'system/modules/frontendedit/templates',
));
