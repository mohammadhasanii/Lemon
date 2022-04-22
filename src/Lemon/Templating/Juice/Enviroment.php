<?php

declare(strict_types=1);

namespace Lemon\Templating\Juice;

use Lemon\Support\Types\Str;

/**
 * Runtime string manipulaton utility.
 */
final class Enviroment
{
    /**
     * Escapes html entities.
     */
    public function escapeHtml(string $content): string
    {
        return htmlspecialchars($content);
    }

    /**
     * Escapes data into javascript-ready.
     */
    public function escapeScript(string $content): string
    {
        return json_encode($content);
    }

    /**
     * Disables javascript in url attributes.
     */
    public function escapeAttribute(string $content): string
    {
        return Str::startsWith($content, 'javascript:') ? '' : $content;
    }
}
