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

use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\Haste\Util\Url;
use HeimrichHannot\HastePlus\Environment;
use HeimrichHannot\StatusMessages\StatusMessage;

class ModuleList extends \HeimrichHannot\FormHybridList\ModuleList
{
	protected $strTemplate = 'mod_frontendedit_list_table';
	protected $strWrapperId = 'frontendedit-list_';
	protected $strWrapperClass = 'frontendedit-list';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### FRONTENDEDIT LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	protected function compile()
	{
		$strAction = \Input::get('act');

		// at first check for the correct request token to be set
		if ($strAction && !\RequestToken::validate(\Input::get('token')))
		{
			StatusMessage::addError(
					sprintf($GLOBALS['TL_LANG']['frontendedit']['requestTokenExpired'], Environment::getUrl(true, true, false)),
					$this->id, 'requestTokenExpired');
			return;
		}

		if ($strAction == FRONTENDEDIT_ACT_DELETE && $intId = \Input::get('id'))
		{
			if ($this->checkPermission($intId))
			{
				$this->deleteItem($intId);
				// return to the list
				\Controller::redirect(Environment::removeParametersFromUri(Environment::getUrl(),
					array('act', 'id')
				));
			}
			else
			{
				StatusMessage::addError($GLOBALS['TL_LANG']['formhybrid_list']['noPermission'], $this->id);
				return;
			}
		}

		if ($strAction == FRONTENDEDIT_ACT_PUBLISH && $intId = \Input::get('id'))
		{
			if ($this->checkPermission($intId))
			{
				$this->publishItem($intId);
				// return to the list
				\Controller::redirect(Environment::removeParametersFromUri(Environment::getUrl(),
					array('act', 'id')
				));
			}
			else
			{
				StatusMessage::addError($GLOBALS['TL_LANG']['formhybrid_list']['noPermission'], $this->id);
				return;
			}
		}

		parent::compile();
		$this->strTemplate = $this->customTpl ?: $this->strTemplate;
	}

	protected function deleteItem($intId)
	{
		$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);
		if (($objItem = $strItemClass::findByPk($intId)) !== null)
		{
			$dc = new DC_Hybrid($this->formHybridDataContainer, $objItem, $objItem->id);

			// call ondelete callbacks
			if (is_array($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback']))
			{
				foreach ($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback'] as $callback)
				{
					$this->import($callback[0]);
					$this->$callback[0]->$callback[1]($dc);
				}
			}

			$objItem->delete();
		}
	}

	protected function publishItem($intId)
	{
		$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);
		if (($objItem = $strItemClass::findByPk($intId)) !== null)
		{
			$objItem->published = !$objItem->published;
			$objItem->save();
		}
	}

	public function addColumns()
	{
		parent::addColumns();

		global $objPage;

		// create
		if (($objPageJumpTo = \PageModel::findByPk($this->jumpToCreate)) !== null || $objPageJumpTo = $objPage)
		{
			$this->Template->createUrl = Environment::addParametersToUri(
				$this->generateFrontendUrl($objPageJumpTo->row()),
				array(
					'act' => FRONTENDEDIT_ACT_CREATE,
					'token' => \RequestToken::get()
				)
			);

			$arrGroups = deserialize($this->createMemberGroups, true);

			if (!empty($arrGroups) && (!FE_USER_LOGGED_IN || empty(array_intersect($arrGroups, deserialize(\FrontendUser::getInstance()->groups, true)))))
				$this->Template->addCreateButton = false;
		}
	}

	public function addItemColumns($objItem, &$arrItem)
	{
		parent::addItemColumns($objItem, $arrItem);

		global $objPage;

		// edit
		if (($objPageJumpTo = \PageModel::findByPk($this->jumpToEdit)) !== null || $objPageJumpTo = $objPage)
		{
			$arrItem['addEditCol'] = true;
			$arrItem['editUrl'] = Environment::addParametersToUri(
				$this->generateFrontendUrl($objPageJumpTo->row()),
				array(
					'act' => FRONTENDEDIT_ACT_EDIT,
					'id' => $objItem->id,
					'token' => \RequestToken::get()
				)
			);
		}

		// delete url
		if ($this->addDeleteCol)
		{
			$arrItem['addDeleteCol'] = true;
			$arrItem['deleteUrl'] = Url::addQueryString('act=' . FRONTENDEDIT_ACT_DELETE . '&id=' . $objItem->id .
				'&token=' . \RequestToken::get(), $this->addAjaxPagination ? Url::getCurrentUrlWithoutParameters() : Url::getUrl());
		}

		// publish url
		if ($this->addPublishCol)
		{
			$arrItem['addPublishCol'] = true;
			$arrItem['publishUrl'] = Url::addQueryString('act=' . FRONTENDEDIT_ACT_PUBLISH . '&id=' . $objItem->id .
				'&token=' . \RequestToken::get(), $this->addAjaxPagination ? Url::getCurrentUrlWithoutParameters() : Url::getUrl());
		}
	}

	public function checkPermission($intId)
	{
		$strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);

		if ($this->addUpdateDeleteConditions && ($objItem = $strItemClass::findByPk($intId)) !== null)
		{
			$arrConditions = deserialize($this->updateDeleteConditions, true);

			if (!empty($arrConditions))
				foreach ($arrConditions as $arrCondition)
				{
					if ($objItem->{$arrCondition['field']} != $this->replaceInsertTags($arrCondition['value']))
						return false;
				}
		}

		return true;
	}

}
