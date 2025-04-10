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
 * Reads an SVG file and returns it as string. You may add CSS classes or other attributes like `data`.
 * Be aware that attributes are simply appended - they will not be merged with existing attributes on the SVG, e.g. you cannot overwrite `width`, `height` or `viewBox`.
 */
function inline_svg(string $file, string|null $class = null, array $attributes = []): string
{
    $svg = F::read($file);

    if ($class) {
        $attributes['class'] = ($attributes['class'] ?? '') ? join(' ', [$attributes['class'], $class]): $class;
    }

    foreach ($attributes as $key => $value) {
        $svg = str_replace('<svg', sprintf('<svg %s="%s"', $key, htmlspecialchars($value, ENT_QUOTES, 'UTF-8')), $svg);
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
