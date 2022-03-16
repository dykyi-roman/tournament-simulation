<?php

namespace TS;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

use function dirname;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/' . $this->environment . '/*.yaml');

        if (is_file(dirname(__DIR__) . '/config/services.yaml')) {
            $container->import('../config/services.yaml');
            $container->import('../config/{services}_' . $this->environment . '.yaml');
        } else {
            $container->import('../config/{services}.php');
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('../config/{routes}/*.yaml');

        $modules = $this->modules();
        foreach ($modules as $module) {
            $path = sprintf('%s/src/Components/%s/config/routes.yaml', dirname(__DIR__), $module);
            is_file($path) && $routes->import($path);
        }

        if (is_file(dirname(__DIR__) . '/config/routes.yaml')) {
            $routes->import('../config/routes.yaml');
        } else {
            $routes->import('../config/{routes}.php');
        }
    }

    private function modules(): array
    {
        $result = [];
        $path = sprintf('%s/src/Components', dirname(__DIR__));
        $folders = (array) scandir($path);
        foreach ($folders as $folder) {
            if ('.' === $folder || '..' === $folder) {
                continue;
            }

            if (is_dir(sprintf('%s/%s', $path, $folder))) {
                $result[] = $folder;
            }
        }

        return $result;
    }
}
