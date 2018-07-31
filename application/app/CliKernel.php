<?php
namespace Base;

use Petlove\CliBundle\PetloveCliBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Debug\Debug;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\Routing\RouteCollectionBuilder;

class CliKernel extends BaseKernel
{
    /**
     * @return string
     */
    public function getKernelName()
    {
        return "cli";
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        parent::boot();

        if ($this->debug) {
            Debug::enable();
        }
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [
            new PetloveCliBundle()
        ]);
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param LoaderInterface $loader
     * @throws \Exception
     */
    protected function configureContainer(ContainerBuilder $containerBuilder, LoaderInterface $loader)
    {
        parent::configureContainer($containerBuilder, $loader);
        $loader->load($this->getRootDir() . '/config/config_cli.yml');
    }


    /**
     * @param RouteCollectionBuilder $routes
     * @throws \Symfony\Component\Config\Exception\FileLoaderLoadException
     */
    public function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import("@PetloveApiBundle/Resources/config/routes_backend.yml", "/api/v1");

    }
}
