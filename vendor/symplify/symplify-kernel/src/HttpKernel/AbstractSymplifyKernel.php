<?php

declare (strict_types=1);
namespace ECSPrefix20210606\Symplify\SymplifyKernel\HttpKernel;

use ECSPrefix20210606\Symfony\Component\Config\Loader\LoaderInterface;
use ECSPrefix20210606\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ECSPrefix20210606\Symfony\Component\HttpKernel\Kernel;
use ECSPrefix20210606\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ECSPrefix20210606\Symplify\SmartFileSystem\SmartFileInfo;
use ECSPrefix20210606\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ECSPrefix20210606\Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \ECSPrefix20210606\Symfony\Component\HttpKernel\Kernel implements \ECSPrefix20210606\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    public function getCacheDir() : string
    {
        return \sys_get_temp_dir() . '/' . $this->getUniqueKernelHash();
    }
    public function getLogDir() : string
    {
        return \sys_get_temp_dir() . '/' . $this->getUniqueKernelHash() . '_log';
    }
    /**
     * @return mixed[]
     */
    public function registerBundles()
    {
        return [new \ECSPrefix20210606\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     * @return void
     */
    public function setConfigs(array $configs)
    {
        foreach ($configs as $config) {
            if ($config instanceof \ECSPrefix20210606\Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    /**
     * @return void
     */
    public function registerContainerConfiguration(\ECSPrefix20210606\Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \ECSPrefix20210606\Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}