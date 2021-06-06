<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210606\Symfony\Component\DependencyInjection\Attribute;

/**
 * An attribute to tell how a base type should be tagged.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class AutoconfigureTag extends \ECSPrefix20210606\Symfony\Component\DependencyInjection\Attribute\Autoconfigure
{
    public function __construct(string $name = null, array $attributes = [])
    {
        parent::__construct(tags: [[$name ?? 0 => $attributes]]);
    }
}