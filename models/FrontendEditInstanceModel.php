<?php

namespace HeimrichHannot\FrontendEdit;


class FrontendEditInstanceModel extends \Model
{

	protected static $strTable = '';

	public static function setTable($strTable)
	{
		static::$strTable = $strTable;
	}

	public static function getTable()
	{
		return static::$strTable;
	}

}
