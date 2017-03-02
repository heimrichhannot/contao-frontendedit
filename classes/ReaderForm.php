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

class ReaderForm extends \HeimrichHannot\FormHybrid\Form
{
    protected $objReaderModule;

    public function __construct($objConfig, array $submitCallbacks = [], $intId = 0, $objReaderForm)
    {
        $this->strMethod = FORMHYBRID_METHOD_POST;

        $objConfig->strTemplate = $objConfig->strTemplate ?: 'formhybrid_default';
        $this->objReaderModule  = $objReaderForm;

        if ($objConfig->addClientsideValidation)
        {
            $objConfig->strFormClass = 'jquery-validation';
        }

        $this->arrSubmitCallbacks = $submitCallbacks;

        parent::__construct($objConfig, $intId);
    }

    protected function onSubmitCallback(\DataContainer $dc)
    {
        $this->submission = $dc;

        if (is_array($this->arrSubmitCallbacks) && !empty($this->arrSubmitCallbacks))
        {
            foreach ($this->arrSubmitCallbacks as $arrCallback)
            {
                if (is_array($arrCallback) && !empty($arrCallback))
                {
                    $arrCallback[0]::$arrCallback[1]($dc);
                }
            }
        }
    }

    protected function afterSubmitCallback(\DataContainer $dc)
    {
        // remove previously created locks
        if (in_array('entity_lock', \ModuleLoader::getActive()) && $this->addEntityLock)
        {
            \HeimrichHannot\EntityLock\EntityLockModel::deleteLocks($this->formHybridDataContainer, $this->intId);
        }
    }

    protected function compile() { }

    public function setReaderModule($objModule)
    {
        $this->objReaderModule = $objModule;
    }

    public function modifyDC(&$arrDca = null)
    {
        $this->objReaderModule->modifyDC($arrDca);
    }
}
