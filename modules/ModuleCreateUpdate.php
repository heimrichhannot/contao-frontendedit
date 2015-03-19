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

use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\FormHybrid\Submission;
use HeimrichHannot\XCommonEnvironment;

class ModuleCreateUpdate extends \Module
{
	protected $strTemplate = 'mod_frontendedit_create_update';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### FRONTENDEDIT CREATE/UPDATE ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		\DataContainer::loadDataContainer($this->formHybridDataContainer);
		\System::loadLanguageFile($this->formHybridDataContainer);
		
		return parent::generate();
	}
	
	protected function compile()
	{
		$this->Template->headline = $this->headline;
		$this->Template->hl = $this->hl;
		$this->instanceId = \Input::get('id');

		if ($this->instanceId)
		{
			if (FrontendEdit::checkPermission($this->formHybridDataContainer, $this->instanceId))
				$objForm = new CreateUpdateForm($this->objModel, $this->instanceId);
			else
			{
				$this->Template->noPermission = true;
				$this->Template->errorMessage = $GLOBALS['TL_LANG']['frontendedit']['noPermission'];
				return;
			}
		}
		else
			$objForm = new CreateUpdateForm($this->objModel);
		
		$this->Template->form = $objForm->generate();

		// if created, redirect to the corresponding url
		if ($objForm->isSubmitted() && !$objForm->doNotSubmit() && !$this->instanceId)
			\Controller::redirect(XCommonEnvironment::addParameterToUri(XCommonEnvironment::getCurrentUrl(), 'id', $objForm->getSubmission()->id));
	}
}
