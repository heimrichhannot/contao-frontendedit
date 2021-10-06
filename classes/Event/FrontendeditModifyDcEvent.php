<?php

namespace HeimrichHannot\FrontendEdit\Event;

use HeimrichHannot\FrontendEdit\ModuleReader;

class FrontendeditModifyDcEvent
{
    const NAME = 'frontendeditModifyDc';

    /**
     * @var ModuleReader
     */
    protected $moduleModel;

    /**
     * @var array
     */
    private $dca;

    /**
     * FormhybridBeforeRenderFormEvent constructor.
     */
    public function __construct(ModuleReader $module, array $dca = [])
    {
        $this->moduleModel   = $module;
        $this->dca = $dca;
    }

    /**
     * @return ModuleReader
     */
    public function getModuleModel(): ModuleReader
    {
        return $this->moduleModel;
    }

    /**
     * @param ModuleReader $moduleModel
     */
    public function setModuleModel(ModuleReader $moduleModel): void
    {
        $this->moduleModel = $moduleModel;
    }

    /**
     * @return array
     */
    public function getDca(): array
    {
        return $this->dca;
    }

    /**
     * @param array $dca
     */
    public function setDca(array $dca): void
    {
        $this->dca = $dca;
    }
}