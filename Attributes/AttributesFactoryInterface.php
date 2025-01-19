<?php

declare(strict_types=1);

namespace App\Libraries\Html\Attributes;

interface AttributesFactoryInterface
{
    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes
     *
     * @return \App\Libraries\Html\Attributes\AttributesInterface
     *   The attributes
     */
    public static function build(
        array $attributes = []
    );

    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes
     *
     * @return \App\Libraries\Html\Attributes\AttributesInterface
     *   The attributes
     */
    public function getInstance(
        array $attributes = []
    );
}
