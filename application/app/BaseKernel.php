<?php

namespace Base;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

abstract class BaseKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * Override this to avoid Reflection in the parent method
     * @return string
     */
    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    abstract public function getKernelName();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getKernelName();
    }

    /**
     * @inheritdoc
     */
    public function getCacheDir()
    {
        return sprintf(
            "%s/../var/cache/%s/%s",
            $this->rootDir,
            $this->getName(),
            $this->environment
        );
    }

    /**
     * @inheritdoc
     */
    public function getLogDir()
    {
        return sprintf(
            "%s/../var/logs/%s/%s",
            $this->rootDir,
            $this->getName(),
            $this->environment
        );
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new MonologBundle(),
            new TwigBundle()
        ];
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param LoaderInterface $loader
     * @throws \Exception
     */
    protected function configureContainer(ContainerBuilder $containerBuilder, LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/parameters.yml');
        $loader->load($this->getRootDir() . '/config/infrastructure.yml');
        $loader->load($this->getRootDir() . '/config/domain.yml');

        $containerBuilder
            ->loadFromExtension("framework", ["validation" => true,])
            ->loadFromExtension("twig")
            ->loadFromExtension("monolog");

        if ($this->environment === "test") {
            if (file_exists($this->getRootDir() . '/config/parameters_test.yml')) {
                $loader->load($this->getRootDir() . '/config/parameters_test.yml');
            }
        }
    }
}
