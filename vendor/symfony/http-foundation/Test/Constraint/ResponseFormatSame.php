<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210712\Symfony\Component\HttpFoundation\Test\Constraint;

use ECSPrefix20210712\PHPUnit\Framework\Constraint\Constraint;
use ECSPrefix20210712\Symfony\Component\HttpFoundation\Request;
use ECSPrefix20210712\Symfony\Component\HttpFoundation\Response;
/**
 * Asserts that the response is in the given format.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
final class ResponseFormatSame extends \ECSPrefix20210712\PHPUnit\Framework\Constraint\Constraint
{
    private $request;
    private $format;
    /**
     * @param string|null $format
     */
    public function __construct(\ECSPrefix20210712\Symfony\Component\HttpFoundation\Request $request, $format)
    {
        $this->request = $request;
        $this->format = $format;
    }
    /**
     * {@inheritdoc}
     */
    public function toString() : string
    {
        return 'format is ' . ($this->format ?? 'null');
    }
    /**
     * @param Response $response
     *
     * {@inheritdoc}
     */
    protected function matches($response) : bool
    {
        return $this->format === $this->request->getFormat($response->headers->get('Content-Type'));
    }
    /**
     * @param Response $response
     *
     * {@inheritdoc}
     */
    protected function failureDescription($response) : string
    {
        return 'the Response ' . $this->toString();
    }
    /**
     * @param Response $response
     *
     * {@inheritdoc}
     */
    protected function additionalFailureDescription($response) : string
    {
        return (string) $response;
    }
}
