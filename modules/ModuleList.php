<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) Heimrich & Hannot GmbH
 *
 * @package frontendedit
 * @author  Dennis Patzer
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\FrontendEdit;

use HeimrichHannot\FormHybrid\DC_Hybrid;
use HeimrichHannot\FormHybridList\Dca\SessionField;
use HeimrichHannot\Haste\Dca\General;
use HeimrichHannot\Haste\Util\Url;
use HeimrichHannot\HastePlus\Environment;
use HeimrichHannot\Modal\ModalModel;
use HeimrichHannot\StatusMessages\StatusMessage;

class ModuleList extends \HeimrichHannot\FormHybridList\ModuleList
{
    protected $strWrapperId    = 'frontendedit-list_';
    protected $strWrapperClass = 'frontendedit-list';

    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### FRONTENDEDIT LIST ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->strTemplate  =
            $this->customTpl ?: ($this->strTemplate ?: ($this->isTableList ? 'mod_frontendedit_list_table' : 'mod_frontendedit_list'));
        $this->itemTemplate = $this->itemTemplate ?: ($this->isTableList ? 'frontendedit_list_item_table_default' : 'frontendedit_list_item_default');

        return parent::generate();
    }

    protected function compile()
    {
        $strAction = \Input::get('act');

        // at first check for the correct request token to be set
        if ($strAction && !\RequestToken::validate(\Input::get('token')) && !$this->deactivateTokens) {
            StatusMessage::addError(
                sprintf($GLOBALS['TL_LANG']['frontendedit']['requestTokenExpired'], Environment::getUrl(true, true, false)),
                $this->id,
                'requestTokenExpired'
            );

            return;
        }

        if ($strAction == FRONTENDEDIT_ACT_DELETE && $intId = \Input::get('id')) {
            if ($this->checkPermission($intId)) {
                $this->deleteItem($intId);
                // return to the list
                \Controller::redirect(Url::removeQueryString(['act', 'id', 'token'], Environment::getUrl()));
            } else {
                StatusMessage::addError($GLOBALS['TL_LANG']['formhybrid_list']['noPermission'], $this->id);

                return;
            }
        }

        if ($strAction == FRONTENDEDIT_ACT_PUBLISH && $intId = \Input::get('id')) {
            if ($this->checkPermission($intId)) {
                $this->publishItem($intId);
                // return to the list
                \Controller::redirect(Url::removeQueryString(['act', 'id'], Environment::getUrl()));

            } else {
                StatusMessage::addError($GLOBALS['TL_LANG']['formhybrid_list']['noPermission'], $this->id);

                return;
            }
        }

        global $objPage;

        $this->Template->useModalForCreate = $this->useModalForCreate;

        if ($this->useModalForCreate) {
            if (($objPageJumpTo = \PageModel::findByPk($this->jumpToCreate)) !== null || $objPageJumpTo = $objPage) {
                if (($objModal = ModalModel::findPublishedByTargetPage($objPageJumpTo)) !== null) {
                    $this->Template->modal = $objModal;
                }
            }
        }

        parent::compile();
    }

    protected function deleteItem($intId)
    {
        $strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);
        if (($objItem = $strItemClass::findByPk($intId)) !== null) {
            $dc = new DC_Hybrid($this->formHybridDataContainer, $objItem, $objItem->id);

            // call ondelete callbacks
            if (is_array($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback'])) {
                foreach ($GLOBALS['TL_DCA'][$this->formHybridDataContainer]['config']['ondelete_callback'] as $callback) {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc, 0);
                }
            }

            $objItem->delete();
        }
    }

    protected function publishItem($intId)
    {
        $strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);
        if (($objItem = $strItemClass::findByPk($intId)) !== null) {
            $objItem->published = !$objItem->published;
            $objItem->save();
        }
    }

    public function addColumns()
    {
        parent::addColumns();

        global $objPage;

        // create
        if (($objPageJumpTo = \PageModel::findByPk($this->jumpToCreate)) !== null || $objPageJumpTo = $objPage) {
            $this->Template->createUrl = $this->generateFrontendUrl($objPageJumpTo->row());

            if (!$this->deactivateTokens) {
                $this->Template->createUrl = Url::addQueryString('&token=' . \RequestToken::get(), $this->Template->createUrl);
            }

            $arrGroups       = deserialize($this->createMemberGroups, true);
            $objMember       = \FrontendUser::getInstance();
            $arrIntersection = array_intersect($arrGroups, deserialize($objMember->groups, true));

            if (!empty($arrGroups) && (!FE_USER_LOGGED_IN || empty($arrIntersection))) {
                $this->Template->addCreateButton = false;
            }
        }
    }

    protected function runBeforeTemplateParsing($objTemplate, $arrItem)
    {
        $objTemplate->jumpToEdit      = $this->jumpToEdit;
        $objTemplate->useModalForEdit = $this->useModalForEdit;

        if ($this->useModalForEdit) {
            global $objPage;

            if (($objPageJumpTo = \PageModel::findByPk($this->jumpToEdit)) !== null || $objPageJumpTo = $objPage) {
                if (($objModal = ModalModel::findPublishedByTargetPage($objPageJumpTo)) !== null) {
                    $objTemplate->modal = $objModal;
                }
            }
        }
    }


    public function addItemColumns($objItem, &$arrItem)
    {
        parent::addItemColumns($objItem, $arrItem);

        global $objPage;

        // edit
        if ($this->addEditCol) {
            $arrItem['addEditCol'] = true;

            $strUrl = $this->addAjaxPagination ? Url::getCurrentUrlWithoutParameters() : Url::getUrl();

            if (($objPageJumpTo = \PageModel::findByPk($this->jumpToEdit)) !== null && $this->jumpToEdit != $objPage->id) {
                $strUrl = \Controller::generateFrontendUrl($objPageJumpTo->row(), null, null, true);
            }

            $arrItem['editUrl'] = Url::addQueryString(
                $this->formHybridIdGetParameter . '=' . $objItem->id . (!$this->deactivateTokens ? '&token=' . \RequestToken::get() : ''),
                $strUrl
            );
        }

        // delete url
        if ($this->addDeleteCol) {
            $arrItem['addDeleteCol'] = true;

            $arrItem['deleteUrl'] = Url::addQueryString(
                $this->formHybridIdGetParameter . '=' . $objItem->id . '&act=delete' . (!$this->deactivateTokens ? '&token=' . \RequestToken::get() : ''),
                $this->addAjaxPagination ? Url::getCurrentUrlWithoutParameters() : Url::getUrl()
            );
        }

        // publish url
        if ($this->addPublishCol) {
            $arrItem['addPublishCol'] = true;
            $arrItem['publishUrl']    = Url::addQueryString(
                $this->formHybridIdGetParameter . '=' . $objItem->id . '&act=publish' . (!$this->deactivateTokens ? '&token=' . \RequestToken::get() : ''),
                $this->addAjaxPagination ? Url::getCurrentUrlWithoutParameters() : Url::getUrl()
            );
        }
    }

    public function checkPermission($intId)
    {
        if (!is_numeric($intId)) {
            return false;
        }

        $strItemClass = \Model::getClassFromTable($this->formHybridDataContainer);

        $arrConditions = [];

        // check session if not logged in...
        if (!FE_USER_LOGGED_IN)
        {
            if (!$this->disableSessionCheck)
            {
                if (!\Database::getInstance()->fieldExists(SessionField::FIELD_NAME, $this->formHybridDataContainer))
                {
                    throw new \Exception(
                        sprintf(
                            'No session field in %s available, either create field %s or set `disableSessionCheck` to true.',
                            $this->formHybridDataContainer,
                            SessionField::FIELD_NAME
                        )
                    );
                }

                $arrConditions[] = [
                    'field' => SessionField::FIELD_NAME,
                    'value' => session_id(),
                ];
            }
        } // ...and check member id if logged in
        else
        {
            if (!$this->disableAuthorCheck)
            {
                if (!\Database::getInstance()->fieldExists(General::PROPERTY_AUTHOR_TYPE, $this->formHybridDataContainer))
                {
                    throw new \Exception(
                        sprintf(
                            'No session field in %s available, either create field %s or set `disableAuthorCheck` to true.',
                            $this->formHybridDataContainer,
                            General::PROPERTY_AUTHOR_TYPE
                        )
                    );
                }

                $arrConditions[] = [
                    'field' => General::PROPERTY_AUTHOR_TYPE,
                    'value' => General::AUTHOR_TYPE_MEMBER,
                ];

                if (!\Database::getInstance()->fieldExists(General::PROPERTY_AUTHOR, $this->formHybridDataContainer))
                {
                    throw new \Exception(
                        sprintf(
                            'No session field in %s available, either create field %s or set `disableAuthorCheck` to true.',
                            $this->formHybridDataContainer,
                            General::PROPERTY_AUTHOR
                        )
                    );
                }

                $arrConditions[] = [
                    'field' => General::PROPERTY_AUTHOR,
                    'value' => \FrontendUser::getInstance()->id,
                ];
            }
        }

        if ($this->addUpdateConditions) {
            $arrConditions = array_merge(deserialize($this->updateConditions, true), $arrConditions);
        }

        if (($objItem = $strItemClass::findByPk($intId)) !== null)
        {
            if (!empty($arrConditions)) {
                foreach ($arrConditions as $arrCondition) {
                    if ($objItem->{$arrCondition['field']} != $this->replaceInsertTags($arrCondition['value'])) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

}

