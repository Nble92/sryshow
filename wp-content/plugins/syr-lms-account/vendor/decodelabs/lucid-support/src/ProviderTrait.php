<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Exceptional;
use DecodeLabs\Lucid;

trait ProviderTrait
{
    protected function newSanitizer(mixed $value): Sanitizer
    {
        if (!class_exists(Lucid::class)) {
            throw Exceptional::ComponentUnavailable(
                'DecodeLabs/Lucid package is required for sanitisation'
            );
        }

        return Lucid::newSanitizer($value);
    }
}
