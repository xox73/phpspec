<?php

namespace PhpSpec\CodeAnalysis;

use ReflectionMethod;
use ReflectionProperty;

final class MagicAwareAccessInspector implements AccessInspectorInterface
{
    /**
     * @param object $object
     * @param string $property
     *
     * @return bool
     */
    public function isPropertyReadable($object, $property)
    {
        return is_object($object) && (method_exists($object, '__get') || $this->isExistingPublicProperty($object, $property));
    }

    /**
     * @param object $object
     * @param string $property
     *
     * @return bool
     */
    public function isPropertyWritable($object, $property)
    {
        return is_object($object) && (method_exists($object, '__set') || $this->isExistingPublicProperty($object, $property));
    }

    /**
     * @param object $object
     * @param string $method
     *
     * @return bool
     */
    public function isMethodCallable($object, $method)
    {
        return is_object($object) && (method_exists($object, '__call') || $this->isExistingPublicMethod($object, $method));
    }

    /**
     * @param object $object
     * @param string $property
     *
     * @return bool
     */
    private function isExistingPublicProperty($object, $property)
    {
        if (!property_exists($object, $property)) {
            return false;
        }

        $propertyReflection = new ReflectionProperty($object, $property);

        return $propertyReflection->isPublic();
    }

    /**
     * @param object $object
     * @param string $method
     *
     * @return bool
     */
    private function isExistingPublicMethod($object, $method)
    {
        if (!method_exists($object, $method)) {
            return false;
        }

        $methodReflection = new ReflectionMethod($object, $method);

        return $methodReflection->isPublic();
    }
}
