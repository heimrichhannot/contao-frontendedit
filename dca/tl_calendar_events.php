<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrDca = &$GLOBALS['TL_DCA']['tl_calendar_events'];

$arrDca['palettes']['default'] = str_replace('author,', 'useMemberAuthor,author,memberAuthor,', $arrDca['palettes']['default']);

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = array('tl_calendar_events_frontendedit', 'modifyPalette');

/**
 * Fields
 */
$arrDca['fields']['useMemberAuthor'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['frontendedit']['useMemberAuthor'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange' => true, 'doNotCopy' => true, 'tl_class' => 'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$arrDca['fields']['memberAuthor'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['frontendedit']['memberAuthor'],
	'exclude'                 => true,
	'filter'                  => true,
	'sorting'                 => true,
	'flag'                    => 1,
	'inputType'               => 'select',
	'options_callback'        => array('\HeimrichHannot\FrontendEdit\FrontendEdit', 'getMembersAsOptions'),
	'eval'                    => array('doNotCopy'=>true, 'chosen'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

class tl_calendar_events_frontendedit extends \Backend {

	public static function modifyPalette(){
		$arrDca = &$GLOBALS['TL_DCA']['tl_calendar_events'];

		if (($objEvent = \CalendarEventsModel::findByPk(\Input::get('id'))) !== null && $objEvent->useMemberAuthor)
		{
			$arrDca['palettes']['default'] = str_replace('author,', ',', $arrDca['palettes']['default']);
		}
		else
			$arrDca['palettes']['default'] = str_replace('memberAuthor,', ',', $arrDca['palettes']['default']);
	}

}