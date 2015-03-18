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

$dca['palettes'][MODULE_FRONTENDEDIT_CREATE_UPDATE] = '{title_legend},name,headline,type;{config_legend},formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridEditableSkip,formHybridSubPalettes;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$dca['palettes'][MODULE_FRONTENDEDIT_LIST] = '{title_legend},name,headline,type;{config_legend},numberOfItems,perPage,skipFirst,skipInstances,instance_sorting,jumpToDetails,hideFilter,showItemCount,formHybridDataContainer,formHybridPalette,formHybridEditable,formHybridEditableSkip,formHybridSubPalettes,addDetailsCol,addDeleteCol,addPublishCol;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

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
$dca['config']['onsubmit_callback'][] = array('\HeimrichHannot\FrontendEdit\FrontendEdit', 'setFormHybridDataContainer');

/**
 * Fields
 */
$dca['fields']['jumpToDetails'] = $dca['fields']['jumpTo'];
$dca['fields']['jumpToDetails']['eval']['tl_class'] = 'w50';

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
	'eval'                    => array('tl_class' => 'w50'),
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