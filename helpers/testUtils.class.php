<?php

class testUtils {
    public static function getMethod($name) {
        $class = new ReflectionClass('Milestone');
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