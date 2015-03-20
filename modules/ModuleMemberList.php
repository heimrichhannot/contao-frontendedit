<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer <d.patzer@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

class ModuleMemberList extends ModuleList
{
	public function generate()
	{
		$arrDefaultValues = array(
			array(
				'field' => 'pid',
				'value' => $this->pidEvent
			),
			// only show events owned by the member
			array(
				'field' => 'memberAuthor',
				'value' => \FrontendUser::getInstance()->id
			)
		);

		if ($this->formHybridAddDefaultValues)
		{
			$this->formHybridDefaultValues = array_merge(
				deserialize($this->formHybridDefaultValues, true),
				$arrDefaultValues
			);
		}
		else
			$this->formHybridDefaultValues = $arrDefaultValues;

		$this->formHybridAddDefaultValues = true;

		return parent::generate();
	}
}
