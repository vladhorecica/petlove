<?php

use Base\BaseKernel;
use Petlove\ApiBundle\PetloveApiBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\RouteCollectionBuilder;

class AppKernel extends BaseKernel
{
    /**
     * @return string
     */
    public function getKernelName()
    {
        return 'api';
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [
            new PetloveApiBundle()
        ]);
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param LoaderInterface $loader
     * @throws Exception
     */
    protected function configureContainer(ContainerBuilder $containerBuilder, LoaderInterface $loader)
    {
        parent::configureContainer($containerBuilder, $loader);
        $loader->load($this->getRootDir() . '/config/api_backend.yml');
    }

    /**
     * @param RouteCollectionBuilder $routes
     * @throws \Symfony\Component\Config\Exception\FileLoaderLoadException
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import("@PetloveApiBundle/Resources/config/routes_backend.yml", "/api/v1");
    }
}
