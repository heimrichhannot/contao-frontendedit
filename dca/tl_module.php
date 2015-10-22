<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Palettes
 */
$arrDca['palettes'][MODULE_FRONTENDEDIT_DETAILS] = '{title_legend},name,headline,type;{config_legend},noIdBehavior,formHybridSuccessMessage,formHybridSkipScrollingToSuccessMessage,formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridAddEditableRequired,formHybridSubPalettes,formHybridAddDefaultValues,setPageTitle,formHybridSendSubmissionViaEmail;{template_legend},formHybridTemplate,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$arrDca['palettes'][MODULE_FRONTENDEDIT_LIST] = str_replace(
	array('addDetailsCol', 'formHybridSubPalettes'),
	array('addDetailsCol,addDeleteCol,addPublishCol,', 'formHybridSubPalettes,addUpdateDeleteConditions'),
	$arrDca['palettes'][MODULE_FORMHYBRID_LIST]
);

// members
$arrDca['palettes'][MODULE_FRONTENDEDIT_FRONTENDUSER_DETAILS] = $arrDca['palettes'][MODULE_FRONTENDEDIT_DETAILS];
$arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST] = $arrDca['palettes'][MODULE_FRONTENDEDIT_LIST];

/**
 * Subpalettes
 */
$arrDca['palettes']['__selector__'][]                = 'addUpdateDeleteConditions';
$arrDca['palettes']['__selector__'][]                = 'addUpdateConditions';
$arrDca['palettes']['__selector__'][]                = 'addCustomFilterFields';
$arrDca['palettes']['__selector__'][]                = 'setPageTitle';
$arrDca['subpalettes']['addUpdateDeleteConditions'] = 'updateDeleteConditions';
$arrDca['subpalettes']['addUpdateConditions'] = 'updateConditions';
$arrDca['subpalettes']['addCustomFilterFields'] = 'customFilterFields';
$arrDca['subpalettes']['setPageTitle'] = 'pageTitleField';

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = array('tl_module_frontendedit', 'modifyPalette');
// adjust labels for suiting a list module
$arrDca['config']['onload_callback'][] = array('tl_module_frontendedit', 'adjustPalettesForLists');

/**
 * Fields
 */
$arrDca['fields']['addDeleteCol'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addDeleteCol'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$arrDca['fields']['addPublishCol'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addPublishCol'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$arrDca['fields']['addUpdateDeleteConditions'] = $arrDca['fields']['formHybridAddDefaultValues'];
$arrDca['fields']['addUpdateDeleteConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['addUpdateDeleteConditions'];
$arrDca['fields']['updateDeleteConditions'] = $arrDca['fields']['formHybridDefaultValues'];
$arrDca['fields']['updateDeleteConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['updateDeleteConditions'];

$arrDca['fields']['addUpdateConditions'] = $arrDca['fields']['formHybridAddDefaultValues'];
$arrDca['fields']['addUpdateConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['addUpdateConditions'];
$arrDca['fields']['updateConditions'] = $arrDca['fields']['formHybridDefaultValues'];
$arrDca['fields']['updateConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['updateConditions'];

$arrDca['fields']['setPageTitle'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['setPageTitle'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50', 'submitOnChange' => true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$arrDca['fields']['pageTitleField'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pageTitleField'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_frontendedit', 'getTitleFields'),
	'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$arrDca['fields']['noIdBehavior'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['noIdBehavior'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'default'                 => 'create',
	'options'                 => array('create', 'create_until', 'redirect'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['noIdBehavior'],
	'eval'                    => array('maxlength'=>255, 'tl_class' => 'w50', 'submitOnChange' => true),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

$arrDca['fields']['existingConditions'] = $arrDca['fields']['formHybridDefaultValues'];
$arrDca['fields']['existingConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['existingConditions'];

$arrDca['fields']['redirectId'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['redirectId'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

class tl_module_frontendedit {

	public static function modifyPalette(\DataContainer $objDc)
	{
		\Controller::loadDataContainer('tl_module');
		\System::loadLanguageFile('tl_module');

		if (($objModule = \ModuleModel::findByPk($objDc->id)) !== null)
		{
			$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

			if (\HeimrichHannot\HastePlus\Utilities::isSubModuleOf(
				$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleDetails'))
			{
				$arrDca['palettes'][$objModule->type] = str_replace('formHybridAddDefaultValues',
					'addUpdateConditions,formHybridAddDefaultValues', $arrDca['palettes'][$objModule->type]);

				if ($objModule->noIdBehavior == 'create_until')
					$arrDca['palettes'][$objModule->type] = str_replace('noIdBehavior', 'noIdBehavior,existingConditions', $arrDca['palettes'][$objModule->type]);

				if ($objModule->noIdBehavior == 'redirect')
					$arrDca['palettes'][$objModule->type] = str_replace('noIdBehavior', 'noIdBehavior,redirectId', $arrDca['palettes'][$objModule->type]);
			}

			if (\HeimrichHannot\HastePlus\Utilities::isSubModuleOf(
				$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleList'))
			{
				unset($arrDca['fields']['itemTemplate']['options_callback']);
				$arrDca['fields']['itemTemplate']['options'] = \Controller::getTemplateGroup('frontendedit_list_item_');
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

			if (\HeimrichHannot\HastePlus\Utilities::isSubModuleOf(
				$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleMemberList'))
			{
				$arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST] = str_replace('filterArchives', 'filterGroups', $arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST]);
			}

			if (\HeimrichHannot\HastePlus\Utilities::isSubModuleOf(
				$objModule->type, 'frontendedit', 'HeimrichHannot\FrontendEdit\ModuleMemberList'))
			{
				// override labels for suiting a list module
				$arrDca['fields']['formHybridAddDefaultValues']['label'] = &$GLOBALS['TL_LANG']['tl_module']['formHybridAddDefaultFilterValues'];
				$arrDca['fields']['formHybridDefaultValues']['label'] = &$GLOBALS['TL_LANG']['tl_module']['formHybridDefaultFilterValues'];
			}
		}
	}

	public function getTitleFields(\DataContainer $objDc) {
		if ($strDc = $objDc->activeRecord->formHybridDataContainer)
		{
			\Controller::loadDataContainer($strDc);
			\System::loadLanguageFile($strDc);

			$arrOptions = array();

			foreach($GLOBALS['TL_DCA'][$strDc]['fields'] as $strField => $arrData) {
				if ($arrData['inputType'] != 'text')
					continue;

				$arrOptions[$strField] = $GLOBALS['TL_LANG'][$strDc][$strField][0] ?: $strField;
			}

			asort($arrOptions);

			return $arrOptions;
		}
	}
}