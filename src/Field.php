<?php declare(strict_types = 1);

namespace Dms\Common\Structure;

/**
 * The field builder class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Field
{
    /**
     * Creates a field with the supplied name and label.
     *
     * @param string $name
     * @param string $label
     *
     * @return FieldBuilder
     */
    public static function create(string $name, string $label) : FieldBuilder
    {
        return new FieldBuilder($name, $label);
    }

    /**
     * Creates a field for use as an element of another array field
     * with the supplied name and label.
     *
     * @return FieldBuilder
     */
    public static function element() : FieldBuilder
    {
        return self::create('__element', '__element');
    }

    /**
     * Creates a field for use as a field type placeholder.
     *
     * @return FieldBuilder
     */
    public static function forType() : FieldBuilder
    {
        return self::create('__type', '__type');
    }
}