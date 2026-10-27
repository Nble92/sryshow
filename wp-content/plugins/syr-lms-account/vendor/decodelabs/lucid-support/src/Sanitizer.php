<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Closure;
use DecodeLabs\Lucid\Validate\Result;

interface Sanitizer
{
    /**
     * Process value as type
     *
     * @param array<string, mixed>|Closure|null $setup
     */
    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed;


    /**
     * Validate value as type
     *
     * @param array<string, mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result;


    /**
     * Load processor for value
     *
     * @param array<string, mixed>|Closure|null $setup
     * @return Processor<mixed>
     */
    public function loadProcessor(
        string $type,
        array|Closure|null $setup = null
    ): Processor;
}
