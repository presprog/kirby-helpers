<?php declare(strict_types=1);

use Kirby\Content\Field;
use Kirby\Filesystem\F;
use Kirby\Toolkit\A;

/**
 * Joins path fragments to a single path with DIRECTORY_SEPARATOR
 *
 * @param string[] $fragments
 * @return string
 */
function path(...$fragments): string
{
    return A::join($fragments, DIRECTORY_SEPARATOR);
}

/**
 * Reads an SVG file and returns it as string. You may add arbitrary attributes as array (e.g. `data-?`) or CSS classes as string
 * Be aware that attributes are simply appended: They will not be merged with existing attributes on the SVG nor will the existing attributes be removed, i.e. you cannot overwrite `width`, `height` or `viewBox`.
 */
function inline_svg(string $file, array|string|null $attributes = null): string
{
    $svg = F::read($file);

    if (is_string($attributes)) {
        $attributes = ['class' => $attributes];
    }

    foreach ($attributes ?? [] as $key => $value) {
        $svg = str_replace('<svg', sprintf('<svg %s="%s"', $key, htmlspecialchars($value, ENT_QUOTES)), $svg);
    }

    return $svg ?: '';
}

function inline_icon(Field|string $icon, string|null $class = null): string
{
    if ($icon instanceof Field) {
        $icon = $icon->value();
    }

    $source = option('tobimori.icon-field.folder');

    if (is_callable($source)) {
        $source = $source();
    }

    return inline_svg(path($source, $icon), $class);
}
