<?php

declare(strict_types=1);

namespace App\Libraries\Html\Attributes;

use App\Libraries\Html\Attribute\AttributeFactory;
use ReflectionClass;

class AttributesFactory implements AttributesFactoryInterface
{
    /**
     * The classes registry.
     *
     * @var array
     */
    public static $registry = [
        'attribute_factory' => AttributeFactory::class,
        '*' => Attributes::class,
    ];

    public static function build(
        array $attributes = []
    )
    {
        return (new static())->getInstance($attributes);
    }

    public function getInstance(
        array $attributes = []
    )
    {
        $attribute_factory_classname = static::$registry['attribute_factory'];

        /** @var \App\Libraries\Html\Attribute\AttributeFactoryInterface $attribute_factory_classname */
        $attribute_factory_classname = (new ReflectionClass($attribute_factory_classname))->newInstance();

        $attributes_classname = static::$registry['*'];

        /** @var \App\Libraries\Html\Attributes\AttributesInterface $attributes */
        $attributes = (new ReflectionClass($attributes_classname))
            ->newInstanceArgs([
                $attribute_factory_classname,
                $attributes,
            ]);

        return $attributes;
    }
}
