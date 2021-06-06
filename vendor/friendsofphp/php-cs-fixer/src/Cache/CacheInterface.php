<?php

declare (strict_types=1);
/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Cache;

/**
 * @author Andreas Möller <am@localheinz.com>
 *
 * @internal
 */
interface CacheInterface
{
    public function getSignature() : \PhpCsFixer\Cache\SignatureInterface;
    public function has(string $file) : bool;
    /**
     * @return int|null
     */
    public function get(string $file);
    /**
     * @return void
     */
    public function set(string $file, int $hash);
    /**
     * @return void
     */
    public function clear(string $file);
    public function toJson() : string;
}