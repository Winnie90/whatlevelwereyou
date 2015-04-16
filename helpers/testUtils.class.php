<?php

class testUtils {
    public static function getMethod($className, $name) {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public static function getProperty($obj, $name) {
        $class = new ReflectionObject($obj);
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }
} 