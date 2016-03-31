<?php

namespace App\Components;


class Object
{
    /**
     * Returns the value of an object property.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$value = $object->property;`.
     * @param string $name the property name
     * @return mixed the property value
     * @throws UnknownPropertyException if the property is not defined
     * @throws InvalidCallException if the property is write-only
     * @see __set()
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
//            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
            exit('Getting write-only property: ' . get_class($this) . '::' . $name);
        } else {
//            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
            exit('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * Sets value of an object property.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$object->property = $value;`.
     * @param string $name the property name or the event name
     * @param mixed $value the property value
     * @throws UnknownPropertyException if the property is not defined
     * @throws InvalidCallException if the property is read-only
     * @see __get()
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
//            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
            exit('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
//            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
            exit('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }
}