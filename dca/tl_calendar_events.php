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

$dca['palettes']['default'] = str_replace('author', 'useMemberAuthors,author', $dca['palettes']['default']);

/**
 * Callbacks
 */
$dca['config']['onload_callback'][] = array('tl_calendar_events_frontendedit', 'modifyPalette');

/**
 * Fields
 */
$dca['fields']['useMemberAuthors'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['frontendedit']['useMemberAuthors'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange' => true, 'doNotCopy' => true, 'tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

class tl_calendar_events_frontendedit extends \Backend {

	public static function modifyPalette(){
		$dca = &$GLOBALS['TL_DCA']['tl_calendar_events'];

		if (($objEvent = \CalendarEventsModel::findByPk(\Input::get('id'))) !== null && $objEvent->useMemberAuthors)
		{
			unset($dca['fields']['author']['foreignKey']);
			$dca['fields']['author']['options'] = \HeimrichHannot\FrontendEdit\FrontendEdit::getMembersAsOptions();
		}
	}

}