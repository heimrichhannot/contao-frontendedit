<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) Heimrich & Hannot GmbH
 * @package frontendedit
 * @author Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

use HeimrichHannot\Ajax\Ajax;
use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\FormHybrid\Form;
use HeimrichHannot\FormHybrid\FormHelper;
use HeimrichHannot\FormHybrid\FormSession;
use HeimrichHannot\FormHybridList\FormHybridList;
use HeimrichHannot\Haste\Dca\General;
use HeimrichHannot\Haste\Util\Arrays;
use HeimrichHannot\Haste\Util\Url;
use HeimrichHannot\NotificationCenterPlus\MessageModel;
use HeimrichHannot\StatusMessages\StatusMessage;
use HeimrichHannot\Submissions\SubmissionModel;
use NotificationCenter\Model\Message;

class ModuleReader extends \Module
{
	protected $strTemplate = 'mod_frontendedit_reader';
	protected $arrSubmitCallbacks = array();
	protected $strFormClass = 'HeimrichHannot\\FrontendEdit\\ReaderForm';
	// avoid any messages -> handled sub class
	protected $blnSilentMode = false;
	protected $strWrapperId = 'frontendedit-reader_';
	protected $strWrapperClass = 'frontendedit-reader';

	/**
	 * @var \Form
	 */
	protected $objForm;

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### FRONTENDEDIT READER ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		\DataContainer::loadDataContainer($this->formHybridDataContainer);
		\System::loadLanguageFile($this->formHybridDataContainer);

		$this->strWrapperId .= $this->id;

		return parent::generate();
	}

	protected function compile()
	{
		$this->Template->headline = $this->headline;
		$this->Template->hl = $this->hl;
		$this->Template->wrapperClass = $this->strWrapperClass;
		$this->Template->wrapperId = $this->strWrapperId;
		$this->strFormId = $this->formHybridDataContainer . '_' . $this->id;
		$strAction = $this->defaultAction ?: \Input::get('act');
		$this->arrEditable = deserialize($this->formHybridEditable, true);
		$this->strToken = $this->strToken ?: \Input::get('token');

		// Do not change this order (see #6191)
		$this->Template->style = !empty($this->arrStyle) ? implode(' ', $this->arrStyle) : '';
		$this->Template->class = trim('mod_' . $this->type . ' ' . $this->cssID[1]);
		$this->Template->cssID = ($this->cssID[0] != '') ? ' id="' . $this->cssID[0] . '"' : '';

		$this->Template->inColumn = $this->strColumn;

		if ($this->Template->headline == '')
		{
			$this->Template->headline = $this->headline;
		}

		if ($this->Template->hl == '')
		{
			$this->Template->hl = $this->hl;
		}

		if (!empty($this->objModel->classes) && is_array($this->objModel->classes))
		{
			$this->Template->class .= ' ' . implode(' ', $this->objModel->classes);
		}

		$this->addDefaultArchive();

		// at first check for the correct request token to be set
		if (!$this->deactivateTokens && !\RequestToken::validate($this->strToken))
		{
			if (!$this->blnSilentMode)
			{
				StatusMessage::addError(sprintf($GLOBALS['TL_LANG']['frontendedit']['requestTokenExpired'],
					Url::replaceParameterInUri(Url::getUrl(), 'token', \RequestToken::get())),
					$this->id, 'requestTokenExpired');
			}

			return;
		}
		
		// do nothing, if request is ajax request but not related to formhybrid
		// otherwise a new form entity might be generated and will be validated against wrong submission
		if(Ajax::isRelated(Form::FORMHYBRID_NAME) === false)
		{
			return;
		}

		if($this->allowIdAsGetParameter)
		{
			$this->intId = $this->intId ?: \Input::get('id');
		}
		
		$strFormId = FormHelper::getFormId($this->formHybridDataContainer, $this->id, $this->intId);
		
		// get id from FormSession
		if (!$this->intId && $_POST)
		{
			if ($intId = FormSession::getSubmissionId($strFormId))
			{
				$this->intId = $intId;
			}
		}

		$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);

		// get id from share
		if ($strShare = \Input::get('share'))
		{
			if (($objItem = $strItemClass::findByShareToken($strShare)) !== null && !FormHybridList::shareTokenExpiredOrEmpty($objItem, time()))
			{
				$this->intId = $objItem->id;
			}
		}

		if (!$this->intId)
		{
			if (isset($GLOBALS['TL_HOOKS']['frontendEditAddNoIdBehavior']) && is_array($GLOBALS['TL_HOOKS']['frontendEditAddNoIdBehavior']))
			{
				foreach ($GLOBALS['TL_HOOKS']['frontendEditAddNoIdBehavior'] as $arrCallback)
				{
					$this->import($arrCallback[0]);
					if ($this->$arrCallback[0]->$arrCallback[1]($this) === false)
						return;
				}
			}

			if ($this->noIdBehavior == 'error')
			{
				if (!$this->blnSilentMode)
					StatusMessage::addError($GLOBALS['TL_LANG']['frontendedit']['noIdFound'], $this->id, 'noidfound');

				return;
			}
			elseif ($this->noIdBehavior == 'redirect' || $this->noIdBehavior == 'create_until')
			{
				$arrConditions = deserialize($this->existanceConditions, true);

				if ($this->existanceConditions && !empty($arrConditions))
				{
					$arrColumns = array();
					$arrValues = array();

					foreach ($arrConditions as $arrCondition)
					{
						$arrColumns[] = $arrCondition['field'] . '=?';
						$arrValues[] = $this->replaceInsertTags($arrCondition['value']);
					}

					if (($objItem = $strItemClass::findOneBy($arrColumns, $arrValues)) !== null)
					{
						$this->intId = $objItem->id;
					}
				}
			}

			if (!$this->intId)
			{
				if ($this->noIdBehavior == 'redirect')
				{
					if (!$this->blnSilentMode)
						StatusMessage::addError($GLOBALS['TL_LANG']['frontendedit']['noIdFound'], $this->id, 'noidfound');

					return;
				}
				else
				{
					// if no id is given a new instance is initiated
					$this->objForm = new $this->strFormClass($this->objModel, $this->arrSubmitCallbacks, $this->intId ?: 0, $this);
					
					if($intId = $this->objForm->getId())
					{
						$this->intId = $intId;
					}
				}
			}
		}

		// intId is set at this point!
		if (!$this->checkEntityExists($this->intId))
		{
			if (!$this->blnSilentMode)
			{
				StatusMessage::addError($GLOBALS['TL_LANG']['formhybrid_list']['notExisting'], $this->id, 'noentity');
			}

			return;
		}

		// page title
		if ($this->setPageTitle)
		{
			global $objPage;
			if (($objItem = General::getModelInstance($this->formHybridDataContainer, $this->intId)) !== null)
			{
				$objPage->pageTitle = $objItem->{$this->pageTitleField};
			}
		}

		if ($strAction == FRONTENDEDIT_ACT_DELETE)
		{
			if ($this->checkDeletePermission($this->intId))
			{
				$blnResult = $this->deleteItem($this->intId);

				if(\Environment::get('isAjaxRequest'))
				{
					die($blnResult);
				}

				// return to the list
				\Controller::redirect(Url::removeQueryString(array('act', 'id', 'token'), Url::getUrl()));
			}
			else
			{
				if (!$this->blnSilentMode)
					StatusMessage::addError($GLOBALS['TL_LANG']['formhybrid_list']['noPermission'], $this->id, 'nopermission');
				return;
			}
		}
		else
		{
			if ($this->checkUpdatePermission($this->intId))
			{
				// create a new lock if necessary
				if (in_array('entity_lock', \ModuleLoader::getActive()) && $this->addEntityLock)
				{
					if (\HeimrichHannot\EntityLock\EntityLockModel::isLocked($this->formHybridDataContainer, $this->intId, $this))
					{
						if (!$this->blnSilentMode)
						{
							StatusMessage::addError(EntityLock::generateErrorMessage($this->formHybridDataContainer, $this->intId, $this),
								$this->id, 'locked');
						}

						return;
					}
					else
					{
						\HeimrichHannot\EntityLock\EntityLockModel::create($this->formHybridDataContainer, $this->intId, $this);
					}
				}
				
				$this->objForm = new $this->strFormClass($this->objModel, $this->arrSubmitCallbacks, $this->intId, $this);
				$this->Template->form = $this->objForm->generate();
				
				if (\Environment::get('isAjaxRequest') && \Input::get('scope') == 'modal')
				{
					$objItem         = General::getModelInstance($this->formHybridDataContainer, $this->intId);
					$objModalWrapper = new \FrontendTemplate($this->modalTpl ?: 'formhybrid_reader_modal_bootstrap');
					
					if($objItem !== null)
					{
						$objModalWrapper->setData($objItem->row());
					}
					
					$objModalWrapper->module = Arrays::arrayToObject($this->arrData);
					$objModalWrapper->item = $this->replaceInsertTags($this->Template->parse());
					die($objModalWrapper->parse());
				}
			}
			else
			{
				if (!$this->blnSilentMode)
					StatusMessage::addError($GLOBALS['TL_LANG']['formhybrid_list']['noPermission'], $this->id, 'nopermission');
				return;
			}
		}
	}

	public function checkEntityExists($intId)
	{
		return General::getModelInstance($this->formHybridDataContainer, $intId) !== null;
	}

	protected function deleteItem($intId)
	{
		if (($objItem = General::getModelInstance($this->formHybridDataContainer, $intId)) !== null)
		{
			$objDc = new DC_Hybrid($this->formHybridDataContainer, $objItem, $objItem->id);

			$this->runBeforeDelete($objItem, $objDc);

			// remove previously created locks
			if (in_array('entity_lock', \ModuleLoader::getActive()) && $this->addEntityLock)
			{
				\HeimrichHannot\EntityLock\EntityLockModel::deleteLocks($this->formHybridDataContainer, $intId);
			}

			// call ondelete callbacks
			if (is_array($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback']))
			{
				foreach ($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback'] as $callback)
				{
					$this->import($callback[0]);
					$this->$callback[0]->$callback[1]($objDc);
				}
			}

			$blnDeleted = $objItem->delete() > 0;

			if ($blnDeleted && $this->deleteNotification)
			{
				if (($objMessage = MessageModel::findPublishedById($this->formHybridSubmissionNotification)) !== null)
				{
					$arrSubmissionData = SubmissionModel::prepareData($objItem, $this->formHybridDataContainer,
						$GLOBALS['TL_DCA'][$this->formHybridDataContainer], $objDc, $this->formHybridEditable);

					$arrTokens = SubmissionModel::tokenizeData($arrSubmissionData);

					if ($this->sendDeleteNotification($objMessage, $objItem, $arrSubmissionData, $arrTokens))
					{
						$objMessage->send($arrTokens, $GLOBALS['TL_LANGUAGE']);
					}
				}
			}

			$this->runAfterDelete($blnDeleted, $objItem, $objDc);

			if ($this->jumpToAfterDelete && $strUrl = Url::getJumpToPageUrl($this->jumpToAfterDelete))
			{
				\Controller::redirect($strUrl);
			}

			return $blnDeleted;
		}

		return false;
	}

	public function runBeforeDelete($objItem, \DataContainer $objDc) {}

	public function runAfterDelete($blnDeleted, $objItem, \DataContainer $objDc) {}

	public function sendDeleteNotification(Message $objMessage, $objItem, array $arrSubmissionData, array $arrTokens)
	{
		return true;
	}

	public function checkUpdatePermission($intId)
	{
		if ($this->addUpdateConditions && ($objItem = General::getModelInstance($this->formHybridDataContainer, $intId)) !== null)
		{
			$arrConditions = deserialize($this->updateConditions, true);

			if (!empty($arrConditions))
				foreach ($arrConditions as $arrCondition)
				{
					if ($objItem->{$arrCondition['field']} != $this->replaceInsertTags($arrCondition['value']))
						return false;
				}
		}

		return true;
	}

	public function checkDeletePermission($intId)
	{
		if ($this->allowDelete && $this->addDeleteConditions &&
			($objItem = General::getModelInstance($this->formHybridDataContainer, $intId)) !== null)
		{
			$arrConditions = deserialize($this->deleteConditions, true);

			if (!empty($arrConditions))
				foreach ($arrConditions as $arrCondition)
				{
					if ($objItem->{$arrCondition['field']} != $this->replaceInsertTags($arrCondition['value']))
						return false;
				}
		}

		return $this->allowDelete;
	}

	public function setSubmitCallbacks(array $callbacks)
	{
		$this->arrSubmitCallbacks = $callbacks;
	}

	protected function addDefaultArchive()
	{
		if ($this->objModel->defaultArchive)
		{
			$this->objModel->formHybridAddDefaultValues = true;
			$this->objModel->formHybridDefaultValues = deserialize($this->objModel->formHybridDefaultValues, true);

			$this->objModel->formHybridDefaultValues = array_merge(array(array(
				'field' => 'pid',
				'value' => $this->objModel->defaultArchive
			)), $this->objModel->formHybridDefaultValues);

			$this->objModel->formHybridDefaultValues = serialize($this->objModel->formHybridDefaultValues);
		}
	}

	protected function generateFields($objItem)
	{
		$arrItem = array();

		// always add id
		$arrItem['fields']['id'] = $objItem->id;

		foreach ($this->arrEditable as $strName)
		{
			$varValue = $objItem->{$strName};
			// Convert timestamps
			if ($varValue != '' && ($this->dca['fields'][$strName]['eval']['rgxp'] == 'date' || $this->dca['fields'][$strName]['eval']['rgxp'] == 'time' || $this->dca['fields'][$strName]['eval']['rgxp'] == 'datim'))
			{
				$objDate = new \Date($varValue);
				$varValue = $objDate->{$this->dca['fields'][$strName]['eval']['rgxp']};
			}

			$arrItem['fields'][$strName] = $varValue;
		}

		// add raw values
		foreach ($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['fields'] as $strField => $arrData)
		{
			$arrItem['raw'][$strField] = $objItem->{$strName};
		}

		if ($this->publishedField)
		{
			$arrItem['isPublished'] = ($this->invertPublishedField ?
				!$objItem->{$this->publishedField} : $objItem->{$this->publishedField});
		}

		return $arrItem;
	}

	public function modifyDC(&$arrDca = null) {}
}
