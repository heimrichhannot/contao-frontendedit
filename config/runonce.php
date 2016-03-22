<?php

class FrontendEditListRunOnce extends \Controller
{

	public function run()
	{
		$this->updateTo200();
	}


	/**
	 * Update to version 2.0.0
	 */
	private function updateTo200()
	{
		$objDatabase = \Database::getInstance();

		if ($objDatabase->fieldExists('tableFields', 'tl_module')) {
			return;
		}

		$objDatabase->execute('UPDATE tl_module SET tableFields = formHybridEditable, isTableList = 1, hasHeader = 1 WHERE type = "frontendedit_list"');
	}
}


/**
 * Instantiate controller
 */
$objFrontendEditRunOnce = new FrontendEditListRunOnce();
$objFrontendEditRunOnce->run();