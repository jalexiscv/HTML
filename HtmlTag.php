<?php

declare(strict_types=1);

namespace App\Libraries\Html;

use App\Libraries\Html\Attribute\AttributeFactory;
use App\Libraries\Html\Attribute\AttributeInterface;
use App\Libraries\Html\Attributes\AttributesFactory;
use App\Libraries\Html\Attributes\AttributesInterface;
use App\Libraries\Html\Tag\TagFactory;
use App\Libraries\Html\Tag\TagInterface;

/**
 * Class HtmlTag.
 */
final class HtmlTag implements HtmlTagInterface
{
    public static function attribute(string $name, $value): AttributeInterface
    {
        return AttributeFactory::build($name, $value);
    }

    public static function attributes(array $attributes = []): AttributesInterface
    {
        return AttributesFactory::build($attributes);
    }

    public static function tag(string $name, array $attributes = [], $content = null): TagInterface
    {
        return TagFactory::build($name, $attributes, $content);
    }
}
