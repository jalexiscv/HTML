<?php

declare(strict_types=1);

namespace App\Libraries\Html\Tag;

interface TagFactoryInterface
{
    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array<mixed> $attributes
     *   The tag attributes
     * @param mixed $content
     *   The tag content
     *
     * @return \App\Libraries\Html\Tag\TagInterface
     *   The tag
     */
    public static function build(string $name, array $attributes = [], $content = null): TagInterface;

    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array<mixed> $attributes
     *   The tag attributes
     * @param mixed $content
     *   The tag content
     *
     * @return \App\Libraries\Html\Tag\TagInterface
     *   The tag
     */
    public function getInstance(string $name, array $attributes = [], $content = null): TagInterface;
}
