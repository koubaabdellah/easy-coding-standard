<?php

declare (strict_types=1);
namespace ECSPrefix20210722\Symplify\PackageBuilder\Reflection;

use ReflectionProperty;
use ECSPrefix20210722\Symplify\PHPStanRules\Exception\ShouldNotHappenException;
/**
 * @see \Symplify\PackageBuilder\Tests\Reflection\PrivatesAccessorTest
 */
final class PrivatesAccessor
{
    /**
     * @return mixed
     * @param object $object
     */
    public function getPrivateProperty($object, string $propertyName)
    {
        $propertyReflection = $this->resolvePropertyReflection($object, $propertyName);
        $propertyReflection->setAccessible(\true);
        return $propertyReflection->getValue($object);
    }
    /**
     * @param object $object
     * @return void
     */
    public function setPrivateProperty($object, string $propertyName, $value)
    {
        $propertyReflection = $this->resolvePropertyReflection($object, $propertyName);
        $propertyReflection->setAccessible(\true);
        $propertyReflection->setValue($object, $value);
    }
    /**
     * @param object $object
     */
    private function resolvePropertyReflection($object, string $propertyName) : \ReflectionProperty
    {
        if (\property_exists($object, $propertyName)) {
            return new \ReflectionProperty($object, $propertyName);
        }
        $parentClass = \get_parent_class($object);
        if ($parentClass === \false) {
            throw new \ECSPrefix20210722\Symplify\PHPStanRules\Exception\ShouldNotHappenException();
        }
        return new \ReflectionProperty($parentClass, $propertyName);
    }
}
