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
	'HeimrichHannot\FrontendEdit\ModuleNewsList'           => 'system/modules/frontendedit/modules/ModuleNewsList.php',
	'HeimrichHannot\FrontendEdit\ModuleMemberList'         => 'system/modules/frontendedit/modules/ModuleMemberList.php',
	'HeimrichHannot\FrontendEdit\ModuleList'               => 'system/modules/frontendedit/modules/ModuleList.php',
	'HeimrichHannot\FrontendEdit\ModuleFormValidator'      => 'system/modules/frontendedit/modules/ModuleFormValidator.php',
	'HeimrichHannot\FrontendEdit\ModuleReader'             => 'system/modules/frontendedit/modules/ModuleReader.php',
	'HeimrichHannot\FrontendEdit\ModuleFrontendUserReader' => 'system/modules/frontendedit/modules/ModuleFrontendUserReader.php',
	'HeimrichHannot\FrontendEdit\ModuleNews'               => 'system/modules/frontendedit/modules/ModuleNews.php',

	// Models
	'HeimrichHannot\FrontendEdit\FrontendEditModel'        => 'system/modules/frontendedit/models/FrontendEditModel.php',
	'HeimrichHannot\FrontendEdit\FrontendEditQueryBuilder' => 'system/modules/frontendedit/models/FrontendEditQueryBuilder.php',

	// Classes
	'HeimrichHannot\FrontendEdit\ValidatorForm'            => 'system/modules/frontendedit/classes/ValidatorForm.php',
	'HeimrichHannot\FrontendEdit\ReaderForm'               => 'system/modules/frontendedit/classes/ReaderForm.php',
	'HeimrichHannot\FrontendEdit\FrontendEdit'             => 'system/modules/frontendedit/classes/FrontendEdit.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_frontendedit_list'                => 'system/modules/frontendedit/templates',
	'mod_frontendedit_reader'              => 'system/modules/frontendedit/templates',
	'mod_frontendedit_list_table'          => 'system/modules/frontendedit/templates',
	'frontendedit_list_item_default'       => 'system/modules/frontendedit/templates',
	'frontendedit_list_item_table_default' => 'system/modules/frontendedit/templates',
));
