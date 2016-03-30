<?php

class FrontendEditRunOnce extends \Controller
{

	public function run()
	{
		$this->updateTo210();
	}


	/**
	 * Update to version 2.1.0
	 */
	private function updateTo210()
	{
		$objDatabase = \Database::getInstance();

		$objDatabase->execute('UPDATE tl_module m SET m.type = "frontendedit_reader" WHERE m.type = "frontendedit_details"');
		$objDatabase->execute('UPDATE tl_module m SET m.type = "frontendedit_frontenduser_reader" WHERE m.type = "frontendedit_frontenduser_details"');

		$objDatabase->execute('UPDATE tl_module SET addUpdateDeleteConditions = addUpdateConditions, updateDeleteConditions = updateConditions WHERE addUpdateConditions = 1');
	}
}


/**
 * Instantiate controller
 */
$objFrontendEditRunOnce = new FrontendEditRunOnce();
$objFrontendEditRunOnce->run();
