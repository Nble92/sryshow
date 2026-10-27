<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos\Extension;

use DecodeLabs\Cosmos\Locale;

/**
 * @template TReturn
 */
interface Number
{
    /**
     * @return ($value is null ? null : TReturn)
     */
    public function format(
        int|float|string|null $value,
        ?string $unit = null,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($value is null ? null : TReturn)
     */
    public function pattern(
        int|float|string|null $value,
        string $pattern,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($value is null ? null : TReturn)
     */
    public function decimal(
        int|float|string|null $value,
        ?int $precision = null,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($value is null ? null : TReturn)
     */
    public function currency(
        int|float|string|null $value,
        ?string $code,
        ?bool $rounded = null,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($value is null ? null : TReturn)
     */
    public function percent(
        int|float|string|null $value,
        float $total = 100.0,
        int $decimals = 0,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($value is null ? null : TReturn)
     */
    public function scientific(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($value is null ? null : TReturn)
     */
    public function spellout(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($value is null ? null : TReturn)
     */
    public function ordinal(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($diff is null ? null : TReturn)
     */
    public function diff(
        int|float|string|null $diff,
        ?bool $invert = false,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($bytes is null ? null : TReturn)
     */
    public function fileSize(
        ?int $bytes,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($bytes is null ? null : TReturn)
     */
    public function fileSizeDec(
        ?int $bytes,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($counter is null ? null : TReturn)
     */
    public function counter(
        int|float|string|null $counter,
        bool $allowZero = false,
        string|Locale|null $locale = null
    ): mixed;
}
