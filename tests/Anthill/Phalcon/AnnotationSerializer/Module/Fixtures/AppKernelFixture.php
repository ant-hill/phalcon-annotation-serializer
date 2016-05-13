<?php
namespace Tests\Anthill\Phalcon\AnnotationSerializer\Module\Fixtures;

use Anthill\Phalcon\AnnotationSerializer\Module;
use Anthill\Phalcon\KernelModule\Kernel;
use Phalcon\Config;

class AppKernelFixture extends Kernel
{
    /**
     * @param \Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface $loader
     * @return \Phalcon\Config
     * @throws \Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException
     */
    public function registerConfiguration(\Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface $loader)
    {
        return new Config([]);
    }

    /**
     * @return \Phalcon\Mvc\ModuleDefinitionInterface[]
     */
    public function registerModules()
    {
        return array(
            new Module($this)
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ololo';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '0.0.0';
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return __DIR__;
    }
}