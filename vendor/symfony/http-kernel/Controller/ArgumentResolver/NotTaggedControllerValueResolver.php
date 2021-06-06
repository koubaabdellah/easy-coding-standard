<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210606\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use ECSPrefix20210606\Psr\Container\ContainerInterface;
use ECSPrefix20210606\Symfony\Component\DependencyInjection\Exception\RuntimeException;
use ECSPrefix20210606\Symfony\Component\HttpFoundation\Request;
use ECSPrefix20210606\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use ECSPrefix20210606\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Provides an intuitive error message when controller fails because it is not registered as a service.
 *
 * @author Simeon Kolev <simeon.kolev9@gmail.com>
 */
final class NotTaggedControllerValueResolver implements \ECSPrefix20210606\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    private $container;
    public function __construct(\ECSPrefix20210606\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function supports(\ECSPrefix20210606\Symfony\Component\HttpFoundation\Request $request, \ECSPrefix20210606\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        $controller = $request->attributes->get('_controller');
        if (\is_array($controller) && \is_callable($controller, \true) && \is_string($controller[0])) {
            $controller = $controller[0] . '::' . $controller[1];
        } elseif (!\is_string($controller) || '' === $controller) {
            return \false;
        }
        if ('\\' === $controller[0]) {
            $controller = \ltrim($controller, '\\');
        }
        if (!$this->container->has($controller) && \false !== ($i = \strrpos($controller, ':'))) {
            $controller = \substr($controller, 0, $i) . \strtolower(\substr($controller, $i));
        }
        return \false === $this->container->has($controller);
    }
    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function resolve(\ECSPrefix20210606\Symfony\Component\HttpFoundation\Request $request, \ECSPrefix20210606\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument)
    {
        if (\is_array($controller = $request->attributes->get('_controller'))) {
            $controller = $controller[0] . '::' . $controller[1];
        }
        if ('\\' === $controller[0]) {
            $controller = \ltrim($controller, '\\');
        }
        if (!$this->container->has($controller)) {
            $i = \strrpos($controller, ':');
            $controller = \substr($controller, 0, $i) . \strtolower(\substr($controller, $i));
        }
        $what = \sprintf('argument $%s of "%s()"', $argument->getName(), $controller);
        $message = \sprintf('Could not resolve %s, maybe you forgot to register the controller as a service or missed tagging it with the "controller.service_arguments"?', $what);
        throw new \ECSPrefix20210606\Symfony\Component\DependencyInjection\Exception\RuntimeException($message);
    }
}