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
	'HeimrichHannot\FrontendEdit\ModuleCreateUpdate'        => 'system/modules/frontendedit/modules/ModuleCreateUpdate.php',
	'HeimrichHannot\FrontendEdit\ModuleEventCreateUpdate'   => 'system/modules/frontendedit/modules/ModuleEventCreateUpdate.php',
	'HeimrichHannot\FrontendEdit\ModuleList'                => 'system/modules/frontendedit/modules/ModuleList.php',

	// Classes
	'HeimrichHannot\FrontendEdit\CreateUpdateForm'          => 'system/modules/frontendedit/classes/CreateUpdateForm.php',
	'HeimrichHannot\FrontendEdit\FrontendEdit'              => 'system/modules/frontendedit/classes/FrontendEdit.php',

	// Models
	'HeimrichHannot\FrontendEdit\FrontendEditInstanceModel' => 'system/modules/frontendedit/models/FrontendEditInstanceModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_frontendedit_create_update' => 'system/modules/frontendedit/templates',
	'mod_frontendedit_list'          => 'system/modules/frontendedit/templates',
	'formhybrid_frontendedit'        => 'system/modules/frontendedit/templates',
));
