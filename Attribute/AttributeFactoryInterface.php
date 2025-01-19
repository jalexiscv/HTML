<?php

declare(strict_types=1);

namespace App\Libraries\Html\Attribute;

interface AttributeFactoryInterface
{
    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name
     * @param mixed[]|string|null $value
     *   The attribute value
     *
     * @return \App\Libraries\Html\Attribute\AttributeInterface
     *   The attribute
     */
    public static function build(string $name, $value = null): AttributeInterface;

    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name
     * @param mixed[]|string|null $value
     *   The attribute value
     *
     * @return \App\Libraries\Html\Attribute\AttributeInterface
     *   The attribute
     */
    public function getInstance(string $name, $value = null): AttributeInterface;
}
