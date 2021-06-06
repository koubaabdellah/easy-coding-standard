<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210606\Symfony\Component\HttpKernel\EventListener;

use ECSPrefix20210606\Psr\Container\ContainerInterface;
use ECSPrefix20210606\Symfony\Component\HttpFoundation\Session\SessionInterface;
use ECSPrefix20210606\Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use ECSPrefix20210606\Symfony\Component\HttpKernel\Event\RequestEvent;
/**
 * Sets the session in the request.
 *
 * When the passed container contains a "session_storage" entry which
 * holds a NativeSessionStorage instance, the "cookie_secure" option
 * will be set to true whenever the current main request is secure.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class SessionListener extends \ECSPrefix20210606\Symfony\Component\HttpKernel\EventListener\AbstractSessionListener
{
    public function __construct(\ECSPrefix20210606\Psr\Container\ContainerInterface $container, bool $debug = \false)
    {
        parent::__construct($container, $debug);
    }
    public function onKernelRequest(\ECSPrefix20210606\Symfony\Component\HttpKernel\Event\RequestEvent $event)
    {
        parent::onKernelRequest($event);
        if (!$event->isMainRequest() || !$this->container->has('session')) {
            return;
        }
        if ($this->container->has('session_storage') && ($storage = $this->container->get('session_storage')) instanceof \ECSPrefix20210606\Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage && ($mainRequest = $this->container->get('request_stack')->getMainRequest()) && $mainRequest->isSecure()) {
            $storage->setOptions(['cookie_secure' => \true]);
        }
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Session\SessionInterface|null
     */
    protected function getSession()
    {
        if (!$this->container->has('session')) {
            return null;
        }
        return $this->container->get('session');
    }
}