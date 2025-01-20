<?php

namespace App\Libraries\Html\Bootstrap;

use App\Libraries\Html\Html;
use App\Libraries\Html\HtmlTag;

/**
 * Clase para crear tarjetas de Bootstrap 5
 */
class Cards
{
    private $id;
    private $class;
    private $header;
    private $body;
    private $footer;
    private $image;
    private $imagePosition;
    private $title;
    private $subtitle;
    private $text;
    private $buttons;
    private $horizontal;
    private $attributes;

    /**
     * Constructor de la clase Cards
     *
     * @param array $attributes Atributos de la tarjeta
     */
    public function __construct($attributes = [])
    {
        $this->id = $this->get_Attribute($attributes, 'id', 'card-' . uniqid());
        $this->class = $this->get_Attribute($attributes, 'class', 'card');
        $this->header = $this->get_Attribute($attributes, 'header', '');
        $this->body = $this->get_Attribute($attributes, 'body', '');
        $this->footer = $this->get_Attribute($attributes, 'footer', '');
        $this->image = $this->get_Attribute($attributes, 'image', '');
        $this->imagePosition = $this->get_Attribute($attributes, 'imagePosition', 'top'); // top, bottom, overlay
        $this->title = $this->get_Attribute($attributes, 'title', '');
        $this->subtitle = $this->get_Attribute($attributes, 'subtitle', '');
        $this->text = $this->get_Attribute($attributes, 'text', '');
        $this->horizontal = $this->get_Attribute($attributes, 'horizontal', false);
        $this->buttons = [];
        $this->attributes = $attributes;
    }

    /**
     * Establece el título de la tarjeta
     *
     * @param string $title Título de la tarjeta
     * @param array $attributes Atributos adicionales para el título
     * @return self
     */
    public function set_Title($title, $attributes = []): self
    {
        $this->title = [
            'content' => $title,
            'attributes' => $attributes
        ];
        return $this;
    }

    /**
     * Establece el subtítulo de la tarjeta
     *
     * @param string $subtitle Subtítulo de la tarjeta
     * @param array $attributes Atributos adicionales para el subtítulo
     * @return self
     */
    public function set_Subtitle($subtitle, $attributes = []): self
    {
        $this->subtitle = [
            'content' => $subtitle,
            'attributes' => $attributes
        ];
        return $this;
    }

    /**
     * Establece el texto principal de la tarjeta
     *
     * @param string $text Texto de la tarjeta
     * @return self
     */
    public function set_Text($text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Establece la imagen de la tarjeta
     *
     * @param string $src URL de la imagen
     * @param string $alt Texto alternativo
     * @param string $position Posición de la imagen (top, bottom, overlay)
     * @param array $attributes Atributos adicionales para la imagen
     * @return self
     */
    public function set_Image($src, $alt = '', $position = 'top', $attributes = []): self
    {
        $this->image = [
            'src' => $src,
            'alt' => $alt,
            'attributes' => array_merge(['class' => 'card-img-' . $position], $attributes)
        ];
        $this->imagePosition = $position;
        return $this;
    }

    /**
     * Establece el encabezado de la tarjeta
     *
     * @param string $header Contenido del encabezado
     * @param array $attributes Atributos adicionales
     * @return self
     */
    public function set_Header($header, $attributes = []): self
    {
        $this->header = [
            'content' => $header,
            'attributes' => array_merge(['class' => 'card-header'], $attributes)
        ];
        return $this;
    }

    /**
     * Establece el pie de la tarjeta
     *
     * @param string $footer Contenido del pie
     * @param array $attributes Atributos adicionales
     * @return self
     */
    public function set_Footer($footer, $attributes = []): self
    {
        $this->footer = [
            'content' => $footer,
            'attributes' => array_merge(['class' => 'card-footer'], $attributes)
        ];
        return $this;
    }

    /**
     * Configura la tarjeta como horizontal
     *
     * @param bool $horizontal True para hacer la tarjeta horizontal
     * @return self
     */
    public function set_Horizontal($horizontal = true): self
    {
        $this->horizontal = $horizontal;
        if ($horizontal) {
            $this->class .= ' card-horizontal';
        }
        return $this;
    }

    /**
     * Agrega un botón a la tarjeta
     *
     * @param string $label Etiqueta del botón
     * @param array $attributes Atributos del botón
     * @return self
     */
    public function add_Button($label, $attributes = []): self
    {
        $default_attributes = [
            'class' => 'btn btn-primary',
            'type' => 'button'
        ];
        $this->buttons[] = [
            'label' => $label,
            'attributes' => array_merge($default_attributes, $attributes)
        ];
        return $this;
    }

    /**
     * Obtiene un atributo del array de atributos
     *
     * @param array $attributes Array de atributos
     * @param string $name Nombre del atributo
     * @param mixed $default Valor por defecto
     * @return mixed
     */
    private function get_Attribute($attributes, $name, $default = null)
    {
        return $attributes[$name] ?? $default;
    }

    /**
     * Renderiza los botones de la tarjeta
     *
     * @return string HTML de los botones
     */
    private function render_Buttons(): string
    {
        if (empty($this->buttons)) {
            return '';
        }

        $buttons = '';
        foreach ($this->buttons as $button) {
            $buttons .= Html::get_Button([
                'content' => $button['label'],
                'class' => $button['attributes']['class'],
                'type' => $button['attributes']['type']
            ]);
        }
        return $buttons;
    }

    /**
     * Renderiza la imagen de la tarjeta
     *
     * @return string HTML de la imagen
     */
    private function render_Image(): string
    {
        if (empty($this->image)) {
            return '';
        }

        return Html::get_Img([
            'src' => $this->image['src'],
            'alt' => $this->image['alt'],
            'class' => $this->image['attributes']['class']
        ]);
    }

    /**
     * Renderiza el cuerpo de la tarjeta
     *
     * @return string HTML del cuerpo
     */
    private function render_Body(): string
    {
        $body = '';

        // Título
        if (!empty($this->title)) {
            $titleAttrs = array_merge(
                ['class' => 'card-title'],
                $this->title['attributes'] ?? []
            );
            $body .= Html::get_H1([
                'content' => $this->title['content'],
                'class' => $titleAttrs['class']
            ]);
        }

        // Subtítulo
        if (!empty($this->subtitle)) {
            $subtitleAttrs = array_merge(
                ['class' => 'card-subtitle mb-2 text-muted'],
                $this->subtitle['attributes'] ?? []
            );
            $body .= Html::get_H1([
                'content' => $this->subtitle['content'],
                'class' => $subtitleAttrs['class']
            ]);
        }

        // Texto
        if (!empty($this->text)) {
            $body .= Html::get_P([
                'content' => $this->text,
                'class' => 'card-text'
            ]);
        }

        // Botones
        if (!empty($this->buttons)) {
            $body .= $this->render_Buttons();
        }

        return Html::get_Div([
            'content' => $body,
            'class' => 'card-body'
        ]);
    }

    /**
     * Convierte la tarjeta a HTML
     *
     * @return string
     */
    public function __toString()
    {
        $content = '';

        // Header
        if (!empty($this->header)) {
            $content .= Html::get_Div([
                'content' => $this->header['content'],
                'class' => $this->header['attributes']['class']
            ]);
        }

        // Imagen superior
        if (!empty($this->image) && $this->imagePosition === 'top') {
            $content .= $this->render_Image();
        }

        // Cuerpo
        $content .= $this->render_Body();

        // Imagen inferior
        if (!empty($this->image) && $this->imagePosition === 'bottom') {
            $content .= $this->render_Image();
        }

        // Footer
        if (!empty($this->footer)) {
            $content .= Html::get_Div([
                'content' => $this->footer['content'],
                'class' => $this->footer['attributes']['class']
            ]);
        }

        // Si es horizontal, envolver en un div con clase row
        if ($this->horizontal) {
            $content = Html::get_Div([
                'content' => $content,
                'class' => 'row g-0'
            ]);
        }

        // Tarjeta principal
        return Html::get_Div([
            'content' => $content,
            'id' => $this->id,
            'class' => $this->class
        ]);
    }
}
