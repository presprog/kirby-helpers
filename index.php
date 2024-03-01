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
 * Reads an SVG file and returns it as string.
 *
 * @param string $file
 *
 * @return string
 */
function inline_svg(string $file, string $class = null): string
{
    $svg = F::read($file);

    if ($class) {
        $svg = str_replace('<svg', sprintf('<svg class="%s"', $class), $svg);
    }

    return $svg ?: '';
}

function inline_icon(Field|string $icon, string $class = null): string
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
