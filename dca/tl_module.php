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

$dca['palettes'][MODULE_FRONTENDEDIT_CREATE_UPDATE] = '{title_legend},name,headline,type;{config_legend},formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridEditableSkip,formHybridSubPalettes,formHybridAddDefaultValues;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$dca['palettes'][MODULE_FRONTENDEDIT_LIST] = '{title_legend},name,headline,type;{config_legend},numberOfItems,perPage,skipFirst,skipInstances,instanceSorting,jumpToDetails,hideFilter,showItemCount,addDetailsCol,addDeleteCol,addPublishCol,formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridEditableSkip,formHybridSubPalettes,formHybridAddDefaultValues;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// events
$dca['palettes'][MODULE_FRONTENDEDIT_EVENT_CREATE_UPDATE] = str_replace(
	array('formHybridDataContainer,formHybridPalette', 'formHybridSubPalettes'),
	array('', 'formHybridSubPalettes,pidEvent'),
	$dca['palettes']['frontendedit_create_update']
);
$dca['palettes'][MODULE_FRONTENDEDIT_EVENT_LIST] = str_replace(
	array('formHybridDataContainer,formHybridPalette', 'formHybridSubPalettes'),
	array('', 'formHybridSubPalettes,pidEvent'),
	$dca['palettes']['frontendedit_list']
);

/**
 * Callbacks
 */
// set the data container for concrete frontend edit modules (event, news, ...)
$dca['config']['onsubmit_callback'][] = array('tl_module_frontendedit', 'setFormHybridDataContainer');

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

// events
\Controller::loadDataContainer('tl_calendar_events');
$dcaEvents = &$GLOBALS['TL_DCA']['tl_calendar_events'];

$dca['fields']['pidEvent'] = $dcaEvents['fields']['pid'];
$dca['fields']['pidEvent']['label'] = &$GLOBALS['TL_LANG']['tl_module']['pidEvent'];
$dca['fields']['pidEvent']['inputType'] = 'select';
$dca['fields']['pidEvent']['eval']['chosen'] = true;
$dca['fields']['pidEvent']['eval']['tl_class'] = 'w50';

class tl_module_frontendedit {
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
}