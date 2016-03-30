<?php

class FormHybridListRunOnce extends \Controller
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

		$objDatabase->execute('UPDATE tl_module m SET m.type = "frontendedit_reader" WHERE m.type = "frontendedit_details"');
		$objDatabase->execute('UPDATE tl_module m SET m.type = "frontendedit_frontenduser_reader" WHERE m.type = "frontendedit_frontenduser_details"');

		$objDatabase->execute('UPDATE tl_module SET addUpdateDeleteConditions = addUpdateConditions, updateDeleteConditions = updateConditions WHERE addUpdateConditions = 1');
	}
}


/**
 * Instantiate controller
 */
$objFormHybridListRunOnce = new FormHybridListRunOnce();
$objFormHybridListRunOnce->run();