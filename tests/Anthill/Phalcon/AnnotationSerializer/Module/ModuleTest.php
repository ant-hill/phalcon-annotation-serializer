<?php

namespace Tests\Anthill\Phalcon\AnnotationSerializer\Module;

use Anthill\Phalcon\AnnotationSerializer\SerializeManager;
use Tests\Anthill\Phalcon\AnnotationSerializer\Module\Fixtures\AppKernelFixture;

class ModuleTest extends \PHPUnit_Framework_TestCase
{

    public function testModuleBuildSuccesfulyAndAvailableFromDI()
    {
        $kernel = new AppKernelFixture('xxx');
        $kernel->boot();
        $di = $kernel->getDI();
        $serializeManager = $di->get('anthill.serialize_manager');
        $this->assertInstanceOf(SerializeManager::class, $serializeManager);
    }
}