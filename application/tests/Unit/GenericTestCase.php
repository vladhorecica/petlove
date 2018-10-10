<?php

namespace Tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GenericTestCase
 * @package Tests\Unit
 */
class GenericTestCase extends KernelTestCase
{
    private function getContainer(): ContainerInterface
    {
        self::bootKernel();
        return self::$kernel->getContainer();
    }

    /**
     * Just to surrpress a warning.
     */
    public function testInit()
    {
        $this->assertTrue(true);
    }
}
