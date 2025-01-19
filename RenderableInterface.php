<?php

declare(strict_types=1);

namespace App\Libraries\Html;

/**
 * Interface RenderableInterface.
 */
interface RenderableInterface
{
    /**
     * Render the object.
     *
     * @return string
     *   The object rendered in a string
     */
    public function render(): string;
}
