# HTMLTag

## Descripción

Esta es una biblioteca PHP que maneja la generación de etiquetas HTML, sus atributos y contenido.

El enfoque está en la seguridad, velocidad y facilidad de uso.

## Requisitos

* PHP 5.6 para uso regular.
* PHP 7 para desarrollo y ejecución de pruebas.

## Instalación

```composer require jalexiscv/Html```

## Uso

```php
<?php

include 'vendor/autoload.php';

// Objeto Meta.
$meta = \App\Libraries\Html\HtmlTag::tag('meta', ['name' => 'author']);
$meta->attr('content', 'pol dellaiera');

// Objeto Título.
$title = \App\Libraries\Html\HtmlTag::tag('h1', ['class' => 'title'], 'Bienvenido a HTMLTag');

// Objeto Párrafo.
$paragraph = \App\Libraries\Html\HtmlTag::tag('p', ['class' => 'section']);
$paragraph->attr('class')->append('paragraph');
$paragraph->content('Esta biblioteca te ayuda a crear HTML.');

// Pie de página simple
$footer = \App\Libraries\Html\HtmlTag::tag('footer', [], '¡Gracias por usarla!');

// Etiqueta body.
// Agregar contenido que puede ser transformado en cadenas.
$body = \App\Libraries\Html\HtmlTag::tag('body', [], [$title, $paragraph, $footer]);

// Corregir algo que ya fue agregado.
$paragraph->attr('class')->remove('section')->replace('paragraph', 'description');

// Alterar los valores de atributos específicos.
$meta->attr('content')->alter(
    function ($values) {
        return array_map('strtoupper', $values);
    }
);

echo $meta . $body;
```

Imprimirá:

```html
<meta content="POL DELLAIERA" name="author"/>
<body>
  <h1 class="title">Bienvenido a HTMLTag</h1>
  <p class="description">Esta biblioteca te ayuda a crear HTML.</p>
  <footer>¡Gracias por usarla!</footer>
</body>
```

# Constructor HTML

La biblioteca viene con una clase Constructor HTML que te permite crear contenido HTML rápidamente.

```php
<?php 

include 'vendor/autoload.php';

$builder = new \App\Libraries\Html\HtmlBuilder();

$html = $builder
    ->c(' Comentario 1 ') // Agregar un comentario
    ->p(['class' => ['paragraph']], 'algún contenido')
    ->div(['class' => 'container'], 'esto es un div simple')
    ->_() // Finalizar etiqueta <div>
    ->c(' Comentario 2 ')
    ->region([], 'región con etiquetas <inseguras>')
    ->_()
    ->c(' Comentario 3 ')
    ->a()
    ->c(' Comentario 4 ')
    ->span(['class' => 'link'], 'Contenido del enlace')
    ->_()
    ->div(['class' => 'Clases "inseguras"'], 'Contenido <a href="#">inseguro</a>')
    ->_()
    ->c(' Comentario 5 ');

echo $html;
```

Esto producirá:

```html
<!-- Comentario 1 -->
<p class="paragraph">
  algún contenido
  <div class="container">
    esto es un div simple
  </div>
</p>
<!-- Comentario 2 -->
<region>
  región con etiquetas &lt;inseguras&gt;
</region>
<!-- Comentario 3 -->
<a>
  <!-- Comentario 4 -->
  <span class="link">
    Contenido del enlace
  </span>
</a>
<div class="Clases &quot;inseguras&quot;">
  Contenido &lt;a href=&quot;#&quot;&gt;inseguro&lt;/a&gt;
</div>
<!-- Comentario 5 -->
```

## Notas Técnicas

### Análisis de Etiquetas

```
 El nombre de la etiqueta    Un atributo                El contenido
  |                              |                           |
 ++-+                      +-----+-----+                +----+-----+
 |  |                      |           |                |          |
 
<body class="content node" id="node-123" data-clickable>¡Hola mundo!</body>

      |                                               |
      +-----------------------+-----------------------+
                              |
                        Los atributos
```
   
La biblioteca está construida alrededor de 3 objetos:

* El objeto Tag que maneja los atributos, el nombre de la etiqueta y el contenido,
* El objeto Attributes que maneja los atributos,
* El objeto Attribute que maneja un atributo que está compuesto por nombre y su(s) valor(es).

El objeto Tag utiliza el objeto Attributes que es, básicamente, el almacenamiento de objetos Attribute.
Puedes usar cada uno de estos objetos individualmente.

Todos los métodos están documentados a través de interfaces y tu IDE debería poder autocompletar cuando sea necesario.

La mayoría de los parámetros de los métodos son [variadics](http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list) y
aceptan valores anidados ilimitados o arrays de valores.
También puedes encadenar la mayoría de los métodos.

El tipo de valores permitidos puede ser casi cualquier cosa. Si es un objeto, debe implementar el método `__toString()`.

#### Ejemplos

Encadenamiento de métodos:

```php
<?php 

include 'vendor/autoload.php';

$tag = \App\Libraries\Html\HtmlTag::tag('body');
$tag
    ->attr('class', ['FRONT', ['NODE', ['sidebra']], 'node', '  a', '  b  ', [' c']])
    ->replace('sidebra', 'sidebar')
    ->alter(
        function ($values) {
            $values = array_map('strtolower', $values);
            $values = array_unique($values);
            $values = array_map('trim', $values);
            natcasesort($values);

            return $values;
        }
    );
$tag->content('¡Hola mundo!');

echo $tag; // <body class="a b c front node sidebar">¡Hola mundo!</body>
```

Los siguientes ejemplos producirán el mismo HTML:

```php
<?php 

include 'vendor/autoload.php';

$tag = \App\Libraries\Html\HtmlTag::tag('body');
$tag->attr('class', ['front', ['node', ['sidebar']]]);
$tag->content('¡Hola mundo!');

echo $tag; // <body class="front node sidebar">¡Hola mundo!</body>
```

### Atributos

Los atributos se manejan a través de objetos dedicados.
Cada atributo es un objeto que implementa `AttributeInterface`.

La biblioteca viene con algunos atributos predefinidos:

* `Generic`: el atributo predeterminado que se usa cuando no se encuentra ningún otro,
* `DOMAttribute`: un atributo que usa la extensión DOM de PHP para procesar valores,
* `Class_`: un atributo específico para manejar clases CSS.

Puedes crear tus propios atributos implementando `AttributeInterface` o extendiendo uno existente.

Para registrar un atributo personalizado:

```php
<?php

\App\Libraries\Html\Attribute\AttributeFactory::$registry['class'] = MyCustomAttributeClass::class;

$tag = \App\Libraries\Html\HtmlTag::tag('p');

// Agregar un atributo de clase y algunos valores.
$tag->attr('class', 'E', 'C', ['A', 'B'], 'D', 'A', ' F ');

echo $tag; // <p class="A B C D E F"></p>
```

## Inyección de dependencias y extensiones

Gracias a las fábricas proporcionadas en la biblioteca, es posible utilizar clases diferentes en lugar de las predeterminadas.

Ej: Quieres tener un manejo especial para el atributo "class".

```php
<?php 

include 'vendor/autoload.php';

class MyCustomAttributeClass extends \App\Libraries\Html\Attribute\Attribute {
    /**
     * {@inheritdoc}
     */
    protected function preprocess(array $values, array $context = []) {
        // Eliminar valores duplicados.
        $values = array_unique($values);

        // Recortar valores.
        $values = array_map('trim', $values);

        // Convertir a minúsculas
        $values = array_map('strtolower', $values);

        // Ordenar valores.
        natcasesort($values);

        return $values;
    }
}

\App\Libraries\Html\Attribute\AttributeFactory::$registry['class'] = MyCustomAttributeClass::class;

$tag = HtmlTag::tag('p'); 

// Agregar un atributo de clase y algunos valores.
$tag->attr('class', 'E', 'C', ['A', 'B'], 'D', 'A', ' F ');
// Agregar un atributo aleatorio y los mismos valores.
$tag->attr('data-original', 'e', 'c', ['a', 'b'], 'd', 'a', ' f ');

echo $tag; // <p class="a b c d e f" data-original="e c a b d a  f "/>
```

El mismo mecanismo se aplica para la clase `Tag`.

## Seguridad

Para evitar problemas de seguridad, todos los objetos impresos están escapados.

Si los objetos se utilizan como entrada y si implementan el método `__toString()`, se convertirán en cadenas.
Es responsabilidad del usuario asegurarse de que impriman salida **insegura** para que no se escapen dos veces.

## Calidad del código, pruebas y benchmarks

Cada vez que se introducen cambios en la biblioteca, [Travis CI](https://travis-ci.org/drupol/htmltag/builds) ejecuta las pruebas y los benchmarks.

La biblioteca tiene pruebas escritas con [PHPSpec](http://www.phpspec.net/).
No dudes en revisarlas en el directorio `spec`. Ejecuta `composer phpspec` para ejecutar las pruebas.

[PHPBench](https://github.com/phpbench/phpbench) se utiliza para benchmark la biblioteca, para ejecutar los benchmarks: `composer bench`

[PHPInfection](https://github.com/infection/infection) se utiliza para asegurarse de que tu código esté correctamente probado, ejecuta `composer infection` para probar tu código.

## Contribuir

No dudes en contribuir a esta biblioteca enviando solicitudes de extracción en Github. Estoy bastante reactivo :-)