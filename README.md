# Biblioteca HTMLTag

## Descripción

Esta es una biblioteca PHP diseñada para la generación segura y eficiente de HTML estructurado. Proporciona una API fluida y orientada a objetos que facilita la creación, manipulación y renderizado de elementos HTML, manteniendo un alto nivel de seguridad y rendimiento.

La biblioteca está construida sobre un sistema modular que separa las responsabilidades entre etiquetas, atributos y contenido, permitiendo una manipulación precisa y segura de cada componente HTML. Esta arquitectura facilita la extensibilidad y el mantenimiento del código.

### ¿Por qué usar HTMLTag? 

1. **Seguridad Integrada**:
   - Escape automático de contenido HTML para prevenir XSS
   - Validación y sanitización de atributos
   - Manejo seguro de caracteres especiales 
   - Protección contra inyección de código malicioso

2. **Rendimiento Optimizado**:
   - Generación eficiente de HTML
   - Mínimo overhead en memoria
   - Carga perezosa de componentes
   - Optimización de strings y concatenaciones

3. **API Intuitiva**:
   - Interfaz fluida para encadenamiento de métodos
   - Sintaxis clara y consistente
   - Autocompletado en IDEs modernos
   - Documentación completa y ejemplos prácticos

4. **Flexibilidad y Extensibilidad**:
   - Sistema modular de componentes
   - Fácil creación de elementos personalizados
   - Soporte para atributos personalizados
   - Integración con frameworks existentes

5. **Herramientas Especializadas**:
   - Constructor HTML para creación rápida
   - Gestión avanzada de clases CSS
   - Soporte para data-attributes
   - Componentes Bootstrap 5 integrados

### Componentes Principales

La biblioteca incluye varios componentes especializados:

- **HtmlTag**: Núcleo de la biblioteca para crear y manipular etiquetas HTML
- **HtmlBuilder**: Constructor fluido para generación rápida de HTML
- **Modals**: Sistema completo para ventanas modales de Bootstrap 5
- **Grid**: Componente para crear tablas y grids dinámicos
- **Attributes**: Sistema avanzado de gestión de atributos HTML

Características principales:
- Seguridad: Escape automático de contenido
- Velocidad: Optimizada para rendimiento
- Usabilidad: API intuitiva y fluida
- Flexibilidad: Altamente extensible

## Requisitos

* PHP 5.6 o superior para uso en producción
* PHP 7.0 o superior para desarrollo y pruebas

## Instalación

```bash
composer require jalexiscv/Html
```

## Uso Básico

```php
<?php

include 'vendor/autoload.php';

// Crear un meta tag
$meta = \App\Libraries\Html\HtmlTag::tag('meta', ['name' => 'author']);
$meta->attr('content', 'pol dellaiera');

// Crear un título
$title = \App\Libraries\Html\HtmlTag::tag('h1', ['class' => 'title'], 'Bienvenido a HTMLTag');

// Crear un párrafo
$paragraph = \App\Libraries\Html\HtmlTag::tag('p', ['class' => 'section']);
$paragraph->attr('class')->append('paragraph');
$paragraph->content('Esta biblioteca te ayuda a crear HTML de forma segura y eficiente.');

// Crear un pie de página
$footer = \App\Libraries\Html\HtmlTag::tag('footer', [], '¡Gracias por usar HTMLTag!');

// Crear el cuerpo del documento
$body = \App\Libraries\Html\HtmlTag::tag('body', [], [$title, $paragraph, $footer]);

// Modificar clases existentes
$paragraph->attr('class')
    ->remove('section')
    ->replace('paragraph', 'description');

// Transformar valores de atributos
$meta->attr('content')->alter(
    function ($values) {
        return array_map('strtoupper', $values);
    }
);

echo $meta . $body;
```

Resultado:

```html
<meta content="POL DELLAIERA" name="author"/>
<body>
  <h1 class="title">Bienvenido a HTMLTag</h1>
  <p class="description">Esta biblioteca te ayuda a crear HTML de forma segura y eficiente.</p>
  <footer>¡Gracias por usar HTMLTag!</footer>
</body>
```

# Constructor HTML (HtmlBuilder)

La biblioteca incluye una clase `HtmlBuilder` que proporciona una interfaz fluida para crear HTML rápidamente:

```php
<?php 

include 'vendor/autoload.php';

$builder = new \App\Libraries\Html\HtmlBuilder();

$html = $builder
    ->c('<!-- Inicio de contenido -->') // Agregar comentario
    ->p(['class' => ['paragraph']], 'Este es un párrafo')
    ->div(['class' => 'container'], 'Este es un div')
    ->_() // Cerrar div
    ->c('<!-- Sección de navegación -->')
    ->region([], 'Contenido con <etiquetas> especiales')
    ->_()
    ->c('<!-- Enlaces -->')
    ->a()
    ->c('<!-- Contenido del enlace -->')
    ->span(['class' => 'link'], 'Texto del enlace')
    ->_()
    ->div(['class' => 'contenido-especial'], 'Contenido con <marcado> HTML')
    ->_()
    ->c('<!-- Fin de contenido -->');

echo $html;
```

Resultado:

```html
<!-- Inicio de contenido -->
<p class="paragraph">
  Este es un párrafo
  <div class="container">
    Este es un div
  </div>
</p>
<!-- Sección de navegación -->
<region>
  Contenido con &lt;etiquetas&gt; especiales
</region>
<!-- Enlaces -->
<a>
  <!-- Contenido del enlace -->
  <span class="link">
    Texto del enlace
  </span>
</a>
<div class="contenido-especial">
  Contenido con &lt;marcado&gt; HTML
</div>
<!-- Fin de contenido -->
```

## Arquitectura

### Estructura de Componentes

```
 Nombre de etiqueta         Atributo                   Contenido
  |                            |                           |
 ++-+                    +-----+-----+              +------+-----+
 |  |                    |           |              |            |
 
<div class="contenedor" id="main" data-tipo>Contenido HTML</div>

     |                                              |
     +----------------------+----------------------+
                           |
                      Atributos
```
   
La biblioteca está construida sobre tres componentes principales:

1. **Tag**: Gestiona la etiqueta HTML completa
   - Nombre de la etiqueta
   - Atributos
   - Contenido

2. **Attributes**: Colección de atributos
   - Almacena múltiples objetos Attribute
   - Gestiona la serialización

3. **Attribute**: Gestiona un atributo individual
   - Nombre del atributo
   - Valor o valores
   - Reglas de procesamiento

### Características Clave

- Interfaces bien documentadas con soporte para autocompletado en IDEs
- Métodos con parámetros variables ([variadics](http://php.net/manual/es/functions.arguments.php#functions.variable-arg-list))
- Soporte para valores anidados y arrays
- Encadenamiento de métodos para una API fluida
- Soporte para cualquier valor que implemente `__toString()`

### Ejemplos de Uso

#### Encadenamiento de Métodos

```php
<?php 

include 'vendor/autoload.php';

$tag = \App\Libraries\Html\HtmlTag::tag('div');
$tag
    ->attr('class', ['HEADER', ['NAV', ['menu']], 'nav', '  a', '  b  ', [' c']])
    ->replace('menu', 'main-menu')
    ->alter(
        function ($values) {
            $values = array_map('strtolower', $values);
            $values = array_unique($values);
            $values = array_map('trim', $values);
            natcasesort($values);
            return $values;
        }
    );
$tag->content('Menú Principal');

echo $tag; // <div class="a b c header nav main-menu">Menú Principal</div>
```

### Sistema de Atributos

Los atributos se manejan a través de clases especializadas que implementan `AttributeInterface`. La biblioteca incluye tres tipos predefinidos:

1. `Generic`: Atributo por defecto
2. `DOMAttribute`: Utiliza la extensión DOM de PHP
3. `Class_`: Especializado para clases CSS

#### Atributos Personalizados

Puedes crear tus propios manejadores de atributos:

```php
<?php

\App\Libraries\Html\Attribute\AttributeFactory::$registry['class'] = MiClaseAtributo::class;

$tag = \App\Libraries\Html\HtmlTag::tag('p');
$tag->attr('class', 'primario', 'secundario', ['destacado', 'grande'], 'oculto');

echo $tag; // <p class="destacado grande oculto primario secundario"></p>
```

## Seguridad

La biblioteca implementa automáticamente:

- Escape de contenido HTML
- Sanitización de atributos
- Protección contra XSS
- Validación de valores

## Pruebas y Calidad

### Herramientas de Calidad

- **PHPSpec**: Pruebas de comportamiento
  ```bash
  composer phpspec
  ```

- **PHPBench**: Pruebas de rendimiento
  ```bash
  composer bench
  ```

- **PHPInfection**: Pruebas de mutación
  ```bash
  composer infection
  ```

### Integración Continua

La biblioteca utiliza [Travis CI](https://travis-ci.org/drupol/htmltag/builds) para:
- Ejecución automática de pruebas
- Verificación de estándares de código
- Medición de rendimiento

## Contribuciones

¡Las contribuciones son bienvenidas! Puedes:

1. Reportar problemas
2. Sugerir mejoras
3. Enviar pull requests
4. Mejorar la documentación

## Licencia

Esta biblioteca está disponible bajo la licencia MIT. Ver el archivo LICENSE para más detalles.