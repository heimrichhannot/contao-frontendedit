<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dca = &$GLOBALS['TL_DCA']['tl_calendar_events'];

$dca['palettes']['default'] = str_replace('author', 'useMemberAuthor,author', $dca['palettes']['default']);

/**
 * Callbacks
 */
$dca['config']['onload_callback'][] = array('tl_calendar_events_frontendedit', 'modifyPalette');

/**
 * Fields
 */
$dca['fields']['useMemberAuthor'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['frontendedit']['useMemberAuthor'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange' => true, 'doNotCopy' => true, 'tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$dca['fields']['memberAuthor'] = array
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
		$dca = &$GLOBALS['TL_DCA']['tl_calendar_events'];

		if (($objEvent = \CalendarEventsModel::findByPk(\Input::get('id'))) !== null && $objEvent->useMemberAuthor)
		{
			$dca['palettes']['default'] = str_replace('author', 'memberAuthor', $dca['palettes']['default']);
		}
	}

}