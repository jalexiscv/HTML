<?php

declare(strict_types=1);

namespace App\Libraries\Html;

use App\Libraries\Html\Tag\TagFactory;
use App\Libraries\Html\Tag\TagInterface;

/**
 * Class HtmlBuilder.
 */
final class HtmlBuilder implements StringableInterface
{
    /**
     * The tag scope.
     *
     * @var \App\Libraries\Html\Tag\TagInterface|null
     */
    private $scope;

    /**
     * The storage.
     *
     * @var \App\Libraries\Html\Tag\TagInterface[]|string[]
     */
    private $storage;

    public function __call($name, array $arguments = [])
    {
        if ('c' === $name) {
            if (!isset($arguments[0])) {
                return $this;
            }

            return $this->update(
                HtmlTag::tag('!--', [], $arguments[0])
            );
        }

        if ('_' === $name) {
            $this->scope = null;

            return $this;
        }

        $tag = TagFactory::build($name, ...$arguments);

        return $this->update($tag, true);
    }

    /**
     * Add the current tag to the stack.
     *
     * @param \App\Libraries\Html\Tag\TagInterface $tag
     *   The tag
     * @param bool $updateScope
     *   True if the current scope needs to be updated
     *
     * @return \App\Libraries\Html\HtmlBuilder
     *   The HTML Builder object
     */
    private function update(TagInterface $tag, $updateScope = false)
    {
        if (null !== $this->scope) {
            $this->scope->content($this->scope->getContentAsArray(), $tag);
        } else {
            $this->storage[] = $tag;
        }

        if (true === $updateScope) {
            $this->scope = $tag;
        }

        return $this;
    }

    public function __toString(): string
    {
        $output = '';

        foreach ($this->storage as $item) {
            $output .= $item;
        }

        return $output;
    }
}
