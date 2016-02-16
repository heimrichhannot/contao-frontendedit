<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrDca = &$GLOBALS['TL_DCA']['tl_news'];

$arrDca['palettes']['default'] = str_replace('author', 'useMemberAuthor,author,memberAuthor', $arrDca['palettes']['default']);

/**
 * Callbacks
 */
$arrDca['config']['onload_callback'][] = array('tl_news_frontendedit', 'modifyPalette');

/**
 * Fields
 */
\Controller::loadDataContainer('tl_calendar_events');

$arrDca['fields']['useMemberAuthor'] = $GLOBALS['TL_DCA']['tl_calendar_events']['fields']['useMemberAuthor'];
$arrDca['fields']['memberAuthor'] = $GLOBALS['TL_DCA']['tl_calendar_events']['fields']['memberAuthor'];

class tl_news_frontendedit extends \Backend {

	public static function modifyPalette(){
		$arrDca = &$GLOBALS['TL_DCA']['tl_news'];

		if (($objNews = \NewsModel::findByPk(\Input::get('id'))) !== null && $objNews->useMemberAuthor)
		{
			$arrDca['palettes']['default'] = str_replace('author', '', $arrDca['palettes']['default']);
		}
		else
			$arrDca['palettes']['default'] = str_replace('memberAuthor', '', $arrDca['palettes']['default']);
	}

}