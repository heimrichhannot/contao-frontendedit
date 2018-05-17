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

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Palettes
 */
// reader
$arrDca['palettes'][MODULE_FRONTENDEDIT_READER] = '{title_legend},name,headline,type;'
                                                  . '{entity_legend},formHybridDataContainer,formHybridEditable,formHybridForcePaletteRelation,formHybridAddEditableRequired,formHybridAddReadOnly,formHybridAddPermanentFields,formHybridViewMode;'
                                                  . '{action_legend},formHybridAllowIdAsGetParameter,noIdBehavior,disableSessionCheck,disableAuthorCheck,addUpdateConditions,allowDelete,formHybridAsync,formHybridResetAfterSubmission,formHybridAddPrivacyProtocolEntry,deactivateTokens;'
                                                  . '{email_legend},formHybridSubmissionNotification,formHybridConfirmationNotification,deleteNotification;'
                                                  . '{optin_legend:hide},formHybridAddOptIn;'
                                                  . '{redirect_legend},formHybridAddFieldDependentRedirect,jumpTo,formHybridJumpToPreserveParams,formHybridAddHashToAction;'
                                                  . '{misc_legend},formHybridSuccessMessage,formHybridSkipScrollingToSuccessMessage,formHybridCustomSubmit,defaultArchive,formHybridAddDefaultValues,formHybridExportAfterSubmission,setPageTitle,addClientsideValidation;'
                                                  . '{template_legend},formHybridTemplate,customTpl;'
                                                  . '{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// list
$arrDca['palettes'][MODULE_FRONTENDEDIT_LIST] = str_replace(
    'addDetailsCol', 'addDetailsCol,addEditCol,addDeleteCol,addPublishCol,addCreateButton,',
    $arrDca['palettes'][MODULE_FORMHYBRID_LIST]
);

$arrDca['nestedPalettes']['filterMode_standard'] = str_replace('formHybridAddDefaultValues', 'addUpdateConditions,addDeleteConditions,formHybridAddDefaultValues', $arrDca['nestedPalettes']['filterMode_standard']);

$arrDca['palettes'][MODULE_FRONTENDEDIT_FRONTENDUSER_READER] = $arrDca['palettes'][MODULE_FRONTENDEDIT_READER];
$arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST]         = $arrDca['palettes'][MODULE_FRONTENDEDIT_LIST];
$arrDca['palettes'][MODULE_FRONTENDEDIT_NEWS_LIST]           = $arrDca['palettes'][MODULE_FRONTENDEDIT_LIST];

$arrDca['palettes'][MODULE_FRONTENDEDIT_FORM_VALIDATOR] =
    '{title_legend},name,headline,type;' . '{entity_legend},formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridAddEditableRequired;'
    . '{action_legend},formHybridAllowIdAsGetParameter,existanceConditions,disableSessionCheck,disableAuthorCheck,addUpdateConditions,deactivateTokens;'
    . '{email_legend},formHybridSubmissionNotification,formHybridConfirmationNotification,deleteNotification;'
    . '{redirect_legend},formHybridAddFieldDependentRedirect,jumpTo,formHybridJumpToPreserveParams,formHybridAddHashToAction;'
    . '{misc_legend},publishOnValid,formHybridSuccessMessage,formHybridSkipScrollingToSuccessMessage,formHybridCustomSubmit,formHybridAddDefaultValues,formHybridExportAfterSubmission;{template_legend},customTpl;'
    . '{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Subpalettes
 */
$arrDca['palettes']['__selector__'][] = 'addCustomFilterFields';
$arrDca['palettes']['__selector__'][] = 'addCreateButton';
$arrDca['palettes']['__selector__'][] = 'addEditCol';
$arrDca['palettes']['__selector__'][] = 'noIdBehavior';
$arrDca['palettes']['__selector__'][] = 'addUpdateConditions';
$arrDca['palettes']['__selector__'][] = 'allowDelete';
$arrDca['palettes']['__selector__'][] = 'addDeleteConditions';
$arrDca['palettes']['__selector__'][] = 'publishOnValid';

$arrDca['subpalettes']['addCustomFilterFields']     = 'customFilterFields';
$arrDca['subpalettes']['addCreateButton']           = 'useModalExplanation,useModalForCreate,jumpToCreate,createButtonLabel,createMemberGroups';
$arrDca['subpalettes']['addEditCol']                = 'useModalExplanation,useModalForEdit,jumpToEdit';
$arrDca['subpalettes']['noIdBehavior_redirect']     = 'existanceConditions';
$arrDca['subpalettes']['noIdBehavior_create_until'] = 'existanceConditions';
$arrDca['subpalettes']['addUpdateConditions']       = 'updateConditions';
$arrDca['subpalettes']['allowDelete']               = 'addDeleteConditions,jumpToAfterDelete';
$arrDca['subpalettes']['addDeleteConditions']       = 'deleteConditions';
$arrDca['subpalettes']['publishOnValid']            = 'publishedField,invertPublishedField';

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = ['tl_module_frontendedit', 'modifyPalette'];
// adjust labels for suiting a list module
$arrDca['config']['onload_callback'][] = ['tl_module_frontendedit', 'adjustPalettesForLists'];

/**
 * Fields
 */
$arrFields = [
    'addEditCol'              => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['addEditCol'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'jumpToEdit'              => [
        'label'      => &$GLOBALS['TL_LANG']['tl_module']['jumpToEdit'],
        'exclude'    => true,
        'inputType'  => 'pageTree',
        'foreignKey' => 'tl_page.title',
        'eval'       => ['fieldType' => 'radio', 'tl_class' => 'w50 clr autoheight'],
        'sql'        => "int(10) unsigned NOT NULL default '0'",
        'relation'   => ['type' => 'hasOne', 'load' => 'lazy'],
    ],
    'useModalForEdit' => $GLOBALS['TL_DCA']['tl_module']['fields']['useModal'],
    'addDeleteCol'            => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['addDeleteCol'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50 clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'addPublishCol'           => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['addPublishCol'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'useModalForCreate' => $GLOBALS['TL_DCA']['tl_module']['fields']['useModal'],
    'addCreateButton'         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['addCreateButton'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'createButtonLabel'       => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['createButtonLabel'],
        'exclude'   => true,
        'inputType' => 'text',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "varchar(64) NOT NULL default ''",
    ],
    'createMemberGroups'      => [
        'label'      => &$GLOBALS['TL_LANG']['tl_module']['createMemberGroups'],
        'inputType'  => 'select',
        'exclude'    => true,
        'foreignKey' => 'tl_member_group.name',
        'eval'       => [
            'tl_class'           => 'w50',
            'includeBlankOption' => true,
            'chosen'             => true,
            'multiple'           => true,
        ],
        'sql'        => "blob NULL",
    ],
    'jumpToCreate'            => [
        'label'      => &$GLOBALS['TL_LANG']['tl_module']['jumpToCreate'],
        'exclude'    => true,
        'inputType'  => 'pageTree',
        'foreignKey' => 'tl_page.title',
        'eval'       => ['fieldType' => 'radio', 'tl_class' => 'w50 autoheight'],
        'sql'        => "int(10) unsigned NOT NULL default '0'",
        'relation'   => ['type' => 'hasOne', 'load' => 'lazy'],
    ],
    'defaultArchive'          => [
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['defaultArchive'],
        'inputType'        => 'select',
        'options_callback' => ['HeimrichHannot\FormHybridList\Backend\Module', 'getArchives'],
        'eval'             => ['chosen' => true, 'tl_class' => 'w50', 'includeBlankOption' => true],
        'sql'              => "int(10) unsigned NOT NULL default '0'",
    ],
    'deleteNotification'      => [
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['deleteNotification'],
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => ['HeimrichHannot\NotificationCenterPlus\NotificationCenterPlus', 'getNotificationMessagesAsOptions'],
        'eval'             => ['chosen' => true, 'maxlength' => 64, 'tl_class' => 'w50 clr', 'includeBlankOption' => true],
        'sql'              => "varchar(64) NOT NULL default ''",
    ],
    'noIdBehavior'            => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['noIdBehavior'],
        'exclude'   => true,
        'inputType' => 'select',
        'default'   => 'create',
        'options'   => ['create', 'create_until', 'redirect', 'error'],
        'reference' => &$GLOBALS['TL_LANG']['tl_module']['noIdBehavior'],
        'eval'      => ['maxlength' => 64, 'tl_class' => 'w50 clr', 'submitOnChange' => true],
        'sql'       => "varchar(64) NOT NULL default ''",
    ],
    'addUpdateConditions'     => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['addUpdateConditions'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'updateConditions'        => $arrDca['fields']['formHybridDefaultValues'],
    'allowDelete'             => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['allowDelete'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'jumpToAfterDelete'       => $GLOBALS['TL_DCA']['tl_module']['fields']['jumpTo'],
    'addDeleteConditions'     => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['addDeleteConditions'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'deleteConditions'        => $arrDca['fields']['formHybridDefaultValues'],
    'addClientsideValidation' => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['addClientsideValidation'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50 clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'publishOnValid'          => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['publishOnValid'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
];

$arrDca['fields'] += $arrFields;

foreach (['updateConditions', 'deleteConditions'] as $strField)
{
    $arrDca['fields'][$strField]['label'] = &$GLOBALS['TL_LANG']['tl_module'][$strField];
    unset($arrDca['fields'][$strField]['eval']['columnFields']['label']);
    unset($arrDca['fields'][$strField]['eval']['columnFields']['hidden']);
}

$arrDca['fields']['jumpToAfterDelete']['label']            = &$GLOBALS['TL_LANG']['tl_module']['jumpToAfterDelete'];
$arrDca['fields']['jumpToAfterDelete']['eval']['tl_class'] = 'w50';
$arrDca['fields']['jumpToAfterDelete']['eval']['load'] = 'lazy';

class tl_module_frontendedit
{

    public static function modifyPalette(\DataContainer $objDc)
    {
        \Controller::loadDataContainer('tl_module');
        \System::loadLanguageFile('tl_module');

        if (($objModule = \ModuleModel::findByPk($objDc->id)) !== null)
        {
            $arrDca = &$GLOBALS['TL_DCA']['tl_module'];

            if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
                $objModule->type,
                'HeimrichHannot\FrontendEdit\ModuleList'
            )
            )
            {
                unset($arrDca['fields']['itemTemplate']['options_callback']);
                $arrDca['fields']['itemTemplate']['options']    = \Controller::getTemplateGroup('frontendedit_list_item_');
                $arrDca['fields']['jumpTo']['eval']['tl_class'] = 'clr w50';
            }

            if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
                $objModule->type,
                'HeimrichHannot\FrontendEdit\ModuleReader'
            )
            )
            {
                unset($arrDca['fields']['itemTemplate']['options_callback']);
                $arrDca['fields']['itemTemplate']['options']    = \Controller::getTemplateGroup('frontendedit_item');
                $arrDca['fields']['jumpTo']['eval']['tl_class'] = 'clr w50';
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
                $objModule->type,
                'HeimrichHannot\FrontendEdit\ModuleList'
            )
            )
            {
                $arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST] = str_replace('filterArchives', 'filterGroups', $arrDca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST]);

                // override labels for suiting a list module
                $arrDca['fields']['formHybridAddDefaultValues']['label'] = &$GLOBALS['TL_LANG']['tl_module']['formHybridAddDefaultFilterValues'];
                $arrDca['fields']['formHybridDefaultValues']['label']    = &$GLOBALS['TL_LANG']['tl_module']['formHybridDefaultFilterValues'];
            }
        }
    }
}
