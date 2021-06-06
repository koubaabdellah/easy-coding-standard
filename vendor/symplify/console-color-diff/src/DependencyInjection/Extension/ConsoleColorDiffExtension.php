<?php

declare (strict_types=1);
namespace ECSPrefix20210606\Symplify\ConsoleColorDiff\DependencyInjection\Extension;

use ECSPrefix20210606\Symfony\Component\Config\FileLocator;
use ECSPrefix20210606\Symfony\Component\DependencyInjection\ContainerBuilder;
use ECSPrefix20210606\Symfony\Component\DependencyInjection\Extension\Extension;
use ECSPrefix20210606\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ConsoleColorDiffExtension extends \ECSPrefix20210606\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     * @return void
     */
    public function load(array $configs, \ECSPrefix20210606\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder)
    {
        $phpFileLoader = new \ECSPrefix20210606\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ECSPrefix20210606\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}