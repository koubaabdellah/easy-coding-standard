<?php

declare (strict_types=1);
namespace ECSPrefix20210919\Symplify\ComposerJsonManipulator\Bundle;

use ECSPrefix20210919\Symfony\Component\HttpKernel\Bundle\Bundle;
use ECSPrefix20210919\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ECSPrefix20210919\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ECSPrefix20210919\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ECSPrefix20210919\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
