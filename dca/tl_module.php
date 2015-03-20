<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dca = &$GLOBALS['TL_DCA']['tl_module'];

$dc['palettes']['__selector__'][]                = 'addUpdateDeleteConditions';
$dc['subpalettes']['addUpdateDeleteConditions'] = 'updateDeleteConditions';

$dca['palettes'][MODULE_FRONTENDEDIT_CREATE_UPDATE] = '{title_legend},name,headline,type;{config_legend},restrictAccess,formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridEditableSkip,formHybridSubPalettes,formHybridAddDefaultValues,formHybridSendSubmissionViaEmail;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$dca['palettes'][MODULE_FRONTENDEDIT_LIST] = '{title_legend},name,headline,type;{config_legend},numberOfItems,perPage,skipFirst,skipInstances,jumpToDetails,addUpdateDeleteConditions,instanceSorting,filterArchives,formHybridAddDefaultValues,hideFilter,showItemCount,addDetailsCol,addDeleteCol,addPublishCol,formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridEditableSkip,formHybridSubPalettes;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// members
$dca['palettes'][MODULE_FRONTENDEDIT_MEMBER_CREATE_UPDATE] = str_replace('formHybridDataContainer,formHybridPalette', '',
	$dca['palettes']['frontendedit_create_update']);
$dca['palettes'][MODULE_FRONTENDEDIT_MEMBER_LIST] = str_replace('formHybridDataContainer,formHybridPalette', '',
	$dca['palettes']['frontendedit_list']);

$dca['palettes'][MODULE_FRONTENDEDIT_FRONTENDUSER_CREATE_UPDATE] = str_replace('formHybridDataContainer,formHybridPalette', '',
	$dca['palettes']['frontendedit_create_update']);

/**
 * Callbacks
 */
// set the data container for concrete frontend edit modules (event, news, ...)
//$dca['config']['onsubmit_callback'][] = array('tl_module_frontendedit', 'setFormHybridDataContainer');
// adjust labels for suiting a list module
$dca['config']['onload_callback'][] = array('tl_module_frontendedit', 'adjustLabelsForLists');

/**
 * Fields
 */
$dca['fields']['jumpToDetails'] = $dca['fields']['jumpTo'];
$dca['fields']['jumpToDetails']['eval']['tl_class'] = 'w50';

$dca['fields']['instanceSorting'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['instanceSorting'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_frontendedit', 'getSortingOptions'),
	'eval'                    => array('tl_class'=>'w50', 'includeBlankOption' => true, 'chosen' => true),
	'sql'                     => "varchar(16) NOT NULL default ''"
);

$dca['fields']['hideFilter'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hideFilter'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$dca['fields']['showItemCount'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['showItemCount'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$dca['fields']['addDetailsCol'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addDetailsCol'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$dca['fields']['addDeleteCol'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addDeleteCol'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$dca['fields']['addPublishCol'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addPublishCol'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$dca['fields']['addUpdateDeleteConditions'] = $dca['fields']['formHybridAddDefaultValues'];
$dca['fields']['addUpdateDeleteConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['addUpdateDeleteConditions'];

$dca['fields']['updateDeleteConditions'] = $dca['fields']['formHybridDefaultValues'];
$dca['fields']['updateDeleteConditions']['label'] = &$GLOBALS['TL_LANG']['tl_module']['updateDeleteConditions'];

$dca['fields']['filterArchives']    = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filterArchives'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_frontendedit', 'getArchives'),
	'eval'                    => array('multiple' => true, 'chosen' => true, 'tl_class' => 'w50'),
	'sql'                     => "blob NULL"
);

class tl_module_frontendedit {
	public static function adjustLabelsForLists(\DataContainer $objDc)
	{
		if (($objModule = \ModuleModel::findByPk($objDc->id)) !== null)
		{
			switch ($objModule->type) {
				case MODULE_FRONTENDEDIT_LIST:
				case MODULE_FRONTENDEDIT_EVENT_LIST:
				case MODULE_FRONTENDEDIT_MEMBER_LIST:
					\Controller::loadDataContainer('tl_module');
					\System::loadLanguageFile('tl_module');

					// override labels for suiting a list module
					$dca = &$GLOBALS['TL_DCA']['tl_module'];
					$dca['fields']['formHybridAddDefaultValues']['label'] = &$GLOBALS['TL_LANG']['tl_module']['formHybridAddDefaultFilterValues'];
					$dca['fields']['formHybridDefaultValues']['label'] = &$GLOBALS['TL_LANG']['tl_module']['formHybridDefaultFilterValues'];
					break;
			}
		}
	}

	public static function setFormHybridDataContainer(\DataContainer $objDc)
	{
		if (($objModule = \ModuleModel::findByPk($objDc->activeRecord->id)) !== null)
		{
			switch ($objModule->type) {
				case MODULE_FRONTENDEDIT_EVENT_CREATE_UPDATE:
				case MODULE_FRONTENDEDIT_EVENT_LIST:
					\Database::getInstance()->prepare('UPDATE tl_module SET formHybridDataContainer = ? WHERE id = ?')
						->execute('tl_calendar_events', $objDc->activeRecord->id);
					break;
				case MODULE_FRONTENDEDIT_MEMBER_CREATE_UPDATE:
				case MODULE_FRONTENDEDIT_MEMBER_LIST:
				case MODULE_FRONTENDEDIT_FRONTENDUSER_CREATE_UPDATE:
					\Database::getInstance()->prepare('UPDATE tl_module SET formHybridDataContainer = ? WHERE id = ?')
						->execute('tl_member', $objDc->activeRecord->id);
					break;
			}
		}
	}

	public function getSortingOptions(\DataContainer $objDc) {
		if ($strDc = $objDc->activeRecord->formHybridDataContainer)
		{
			\Controller::loadDataContainer($strDc);
			\System::loadLanguageFile($strDc);

			$arrOptions = array();

			foreach($GLOBALS['TL_DCA'][$strDc]['fields'] as $strField => $arrData) {
				$strLabel = $GLOBALS['TL_LANG'][$strDc][$strField][0] ?: $strField;
				$arrOptions[$strField . '_asc']  = $strLabel . $GLOBALS['TL_LANG']['tl_module']['instanceSorting']['asc'];
				$arrOptions[$strField . '_desc'] = $strLabel . $GLOBALS['TL_LANG']['tl_module']['instanceSorting']['desc'];
			}

			asort($arrOptions);

			return array('random' => $GLOBALS['TL_LANG']['tl_module']['instanceSorting']['random']) + $arrOptions;
		}
	}

	public function getArchives(\DataContainer $objDc) {
		if ($strDc = $objDc->activeRecord->formHybridDataContainer)
		{
			\Controller::loadDataContainer($strDc);
			\System::loadLanguageFile($strDc);

			$arrDca = $GLOBALS['TL_DCA'][$strDc];

			if ($strParentTable = $arrDca['config']['ptable'])
			{
				if ($strInstanceClass = \Model::getClassFromTable($strParentTable))
				{
					$arrOptions = array();
					if (($objInstances = $strInstanceClass::findAll()) !== null)
					{
						$arrTitleSynonyms = array('name', 'title');

						while($objInstances->next())
						{
							$strLabel = '';
							foreach ($arrTitleSynonyms as $strTitleSynonym)
							{
								if ($objInstances->{$strTitleSynonym})
								{
									$strLabel = $objInstances->{$strTitleSynonym};
									break;
								}
							}
							$arrOptions[$objInstances->id] = $strLabel ?: 'Archiv ' . $objInstances->id;
						}
					}

					asort($arrOptions);

					return $arrOptions;
				}
			}
		}
	}
}