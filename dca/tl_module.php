<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Palettes
 */
// reader
$arrDca['palettes'][MODULE_FRONTENDEDIT_READER] = '{title_legend},name,headline,type;{entity_legend},formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridAddEditableRequired;{action_legend},defaultAction,createBehavior;{security_legend},addUpdateDeleteConditions;{email_legend},formHybridSendSubmissionViaEmail;{redirect_legend},formHybridAddFieldDependentRedirect;{misc_legend},formHybridSuccessMessage,formHybridAddDefaultValues,defaultArchive,setPageTitle;{template_legend},formHybridTemplate,itemTemplate,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// list
$arrDca['palettes'][MODULE_FRONTENDEDIT_LIST] = str_replace(
	array('addDetailsCol', 'formHybridAddDefaultValues'),
	array('addDetailsCol,addEditCol,addDeleteCol,addPublishCol,addCreateButton,', 'addUpdateDeleteConditions,formHybridAddDefaultValues'),
	$arrDca['palettes'][MODULE_FORMHYBRID_LIST]
);
$arrDca['palettes'][MODULE_FRONTENDEDIT_FRONTENDUSER_READER] = $arrDca['palettes'][MODULE_FRONTENDEDIT_READER];
$arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST] = $arrDca['palettes'][MODULE_FRONTENDEDIT_LIST];
$arrDca['palettes'][MODULE_FRONTENDEDIT_NEWS_LIST] = $arrDca['palettes'][MODULE_FRONTENDEDIT_LIST];

$arrDca['palettes'][MODULE_FRONTENDEDIT_FORM_VALIDATOR] = '{title_legend},name,headline,type;{entity_legend},formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridAddEditableRequired;{security_legend},addUpdateDeleteConditions;{email_legend},formHybridSendSubmissionViaEmail,formHybridSendConfirmationViaEmail;{redirect_legend},formHybridAddFieldDependentRedirect;{misc_legend},formHybridSuccessMessage;{template_legend},formHybridTemplate,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Subpalettes
 */
$arrDca['palettes']['__selector__'][]                = 'addUpdateDeleteConditions';
$arrDca['palettes']['__selector__'][]                = 'addCustomFilterFields';
$arrDca['palettes']['__selector__'][]                = 'addCreateButton';
$arrDca['palettes']['__selector__'][]                = 'addEditCol';
$arrDca['subpalettes']['addUpdateDeleteConditions'] = 'updateDeleteConditions';
$arrDca['subpalettes']['addCustomFilterFields'] = 'customFilterFields';
$arrDca['subpalettes']['addCreateButton'] = 'jumpToCreate,createButtonLabel,createMemberGroups';
$arrDca['subpalettes']['addEditCol'] = 'jumpToEdit';

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = array('tl_module_frontendedit', 'modifyPalette');
// adjust labels for suiting a list module
$arrDca['config']['onload_callback'][] = array('tl_module_frontendedit', 'adjustPalettesForLists');

/**
 * Fields
 */
$arrFields = array(
	'addEditCol' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addEditCol'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class' => 'w50', 'submitOnChange' => true),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'jumpToEdit' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['jumpToEdit'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'foreignKey'              => 'tl_page.title',
		'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'w50 clr'),
		'sql'                     => "int(10) unsigned NOT NULL default '0'",
		'relation'                => array('type'=>'hasOne', 'load'=>'eager')
	),
	'addDeleteCol' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addDeleteCol'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class' => 'w50 clr'),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'addPublishCol' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addPublishCol'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class' => 'w50'),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'createBehavior' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['createBehavior'],
		'exclude'                 => true,
		'inputType'               => 'select',
		'default'                 => 'create',
		'options'                 => array('create', 'create_until', 'redirect'),
		'reference'               => &$GLOBALS['TL_LANG']['tl_module']['createBehavior'],
		'eval'                    => array('maxlength'=>255, 'tl_class' => 'w50', 'submitOnChange' => true),
		'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'redirectId' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['redirectId'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
		'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'addCreateButton' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addCreateButton'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class' => 'w50', 'submitOnChange' => true),
		'sql'                     => "char(1) NOT NULL default ''"
	),
	'createButtonLabel' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['createButtonLabel'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('tl_class' => 'w50'),
		'sql'                     => "varchar(255) NOT NULL default ''"
	),
	'createMemberGroups' => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_module']['createMemberGroups'],
		'inputType' => 'select',
		'exclude'   => true,
		'foreignKey' => 'tl_member_group.name',
		'eval'      => array(
			'tl_class'           => 'w50',
			'includeBlankOption' => true,
			'chosen'             => true,
			'multiple'           => true
		),
		'sql'       => "blob NULL"
	),
	'jumpToCreate' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['jumpToCreate'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'foreignKey'              => 'tl_page.title',
		'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'w50'),
		'sql'                     => "int(10) unsigned NOT NULL default '0'",
		'relation'                => array('type'=>'hasOne', 'load'=>'eager')
	),
	'defaultArchive' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['defaultArchive'],
		'inputType'               => 'select',
		'options_callback'        => array('tl_module_formhybrid_list', 'getArchives'),
		'eval'                    => array('chosen' => true, 'tl_class' => 'w50', 'includeBlankOption' => true),
		'sql'                     => "int(10) unsigned NOT NULL default '0'"
	),
	'defaultAction' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['defaultAction'],
		'inputType'               => 'select',
		'options'                 => array(FRONTENDEDIT_ACT_CREATE, FRONTENDEDIT_ACT_EDIT,
										   FRONTENDEDIT_ACT_DELETE),
		'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true),
		'sql'                     => "varchar(255) NOT NULL default ''"
	)
);

$arrDca['fields'] += $arrFields;

$arrDca['fields']['addUpdateDeleteConditions']			= $arrDca['fields']['formHybridAddDefaultValues'];
$arrDca['fields']['addUpdateDeleteConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['addUpdateDeleteConditions'];
$arrDca['fields']['updateDeleteConditions']				= $arrDca['fields']['formHybridDefaultValues'];
$arrDca['fields']['updateDeleteConditions']['label']	= &$GLOBALS['TL_LANG']['tl_module']['updateDeleteConditions'];

unset($arrDca['fields']['updateDeleteConditions']['eval']['columnFields']['label']);
unset($arrDca['fields']['updateDeleteConditions']['eval']['columnFields']['hidden']);

$arrDca['fields']['existingConditions']					= $arrDca['fields']['formHybridDefaultValues'];
$arrDca['fields']['existingConditions']['label']		= &$GLOBALS['TL_LANG']['tl_module']['existingConditions'];


class tl_module_frontendedit {

	public static function modifyPalette(\DataContainer $objDc)
	{
		\Controller::loadDataContainer('tl_module');
		\System::loadLanguageFile('tl_module');

		if (($objModule = \ModuleModel::findByPk($objDc->id)) !== null)
		{
			$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

			if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
				$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleReader'))
			{
				if ($objModule->createBehavior == 'create_until')
					$arrDca['palettes'][$objModule->type] = str_replace('createBehavior', 'createBehavior,existingConditions', $arrDca['palettes'][$objModule->type]);

				if ($objModule->createBehavior == 'redirect')
					$arrDca['palettes'][$objModule->type] = str_replace('createBehavior', 'createBehavior,redirectId', $arrDca['palettes'][$objModule->type]);
			}

			if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
				$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleList'))
			{
				unset($arrDca['fields']['itemTemplate']['options_callback']);
				$arrDca['fields']['itemTemplate']['options'] = \Controller::getTemplateGroup('frontendedit_list_item_');
			}

			if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
					$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleReader'))
			{
				unset($arrDca['fields']['itemTemplate']['options_callback']);
				$arrDca['fields']['itemTemplate']['options'] = \Controller::getTemplateGroup('frontendedit_item');
			}
		}
	}

	public static function adjustPalettesForLists(\DataContainer $objDc)
	{
		\Controller::loadDataContainer('tl_module');
		\System::loadLanguageFile('tl_module');

		if (($objModule = \ModuleModel::findByPk($objDc->id)) !== null)
		{
			$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

			if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
				$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleList'))
			{
				$arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST] = str_replace('filterArchives', 'filterGroups', $arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST]);

				// override labels for suiting a list module
				$arrDca['fields']['formHybridAddDefaultValues']['label'] = &$GLOBALS['TL_LANG']['tl_module']['formHybridAddDefaultFilterValues'];
				$arrDca['fields']['formHybridDefaultValues']['label'] = &$GLOBALS['TL_LANG']['tl_module']['formHybridDefaultFilterValues'];
			}
		}
	}
}