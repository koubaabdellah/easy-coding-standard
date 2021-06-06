<?php

declare (strict_types=1);
namespace ECSPrefix20210606\Symplify\Skipper\Bundle;

use ECSPrefix20210606\Symfony\Component\HttpKernel\Bundle\Bundle;
use ECSPrefix20210606\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \ECSPrefix20210606\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @return \Symfony\Component\DependencyInjection\Extension\ExtensionInterface|null
     */
    protected function createContainerExtension()
    {
        return new \ECSPrefix20210606\Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}