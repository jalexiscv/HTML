<?php

declare(strict_types=1);

namespace App\Libraries\Html;

use App\Libraries\Html\Attribute\AttributeInterface;
use App\Libraries\Html\Attributes\AttributesInterface;
use App\Libraries\Html\Tag\TagInterface;

/**
 * Interface HtmlTagInterface.
 */
interface HtmlTagInterface
{
    /**
     * Create a new attribute.
     * @param string $name The attribute name
     * @param array<mixed>|string $value The attribute value
     * @return \App\Libraries\Html\Attribute\AttributeInterface The attribute
     */
    public static function attribute(string $name, $value): AttributeInterface;

    /**
     * Create a new attributes.
     *
     * @param array<mixed> $attributes
     *   The attributes
     *
     * @return \App\Libraries\Html\Attributes\AttributesInterface
     *   The attributes
     */
    public static function attributes(array $attributes = []): AttributesInterface;

    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array<mixed> $attributes
     *   The attributes
     * @param mixed $content
     *   The content
     *
     * @return \App\Libraries\Html\Tag\TagInterface
     *   The tag
     */
    public static function tag(string $name, array $attributes = [], $content = null): TagInterface;
}
