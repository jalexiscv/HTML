<?php

declare(strict_types=1);

namespace App\Libraries\Html\Tag;

final class Comment extends AbstractTag
{
    public function render(): string
    {
        return sprintf('<!--%s-->', $this->renderContent());
    }
}
