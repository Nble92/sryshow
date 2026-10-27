<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos\Extension;

use DateInterval;
use DateTime;
use DateTimeZone;
use DecodeLabs\Cosmos\Locale;
use Stringable;

/**
 * @template TReturn
 */
interface Time
{
    /**
     * Custom format a date and wrap it
     *
     * @return ($date is null ? null : TReturn)
     */
    public function format(
        DateTime|DateInterval|string|Stringable|int|null $date,
        string $format,
        DateTimeZone|string|Stringable|bool|null $timezone = true
    ): mixed;

    /**
     * Custom format a date and wrap it
     *
     * @return ($date is null ? null : TReturn)
     */
    public function formatDate(
        DateTime|DateInterval|string|Stringable|int|null $date,
        string $format
    ): mixed;

    /**
     * Custom locale format a date with ICU and wrap it
     *
     * @return ($date is null ? null : TReturn)
     */
    public function pattern(
        DateTime|DateInterval|string|Stringable|int|null $date,
        string $pattern,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format date according to locale
     *
     * @return ($date is null ? null : TReturn)
     */
    public function locale(
        DateTime|DateInterval|string|Stringable|int|null $date,
        string|int|bool|null $dateSize = true,
        string|int|bool|null $timeSize = true,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format full date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function fullDateTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format full date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function fullDate(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format full time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function fullTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format long date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function longDateTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format long date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function longDate(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format long time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function longTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format medium date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function mediumDateTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format medium date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function mediumDate(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format medium time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function mediumTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format short date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function shortDateTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format short date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function shortDate(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format short time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function shortTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;




    /**
     * Format default date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function dateTime(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format default date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function date(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format default time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function time(
        DateTime|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;




    /**
     * Format interval since date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function since(
        DateTime|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval since date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function sinceAbs(
        DateTime|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval since date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function sinceAbbr(
        DateTime|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function until(
        DateTime|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function untilAbs(
        DateTime|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function untilAbbr(
        DateTime|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format interval until date
     *
     * @return ($date1 is null ? null : ($date2 is null ? null : TReturn))
     */
    public function between(
        DateTime|DateInterval|string|Stringable|int|null $date1,
        DateTime|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date1 is null ? null : ($date2 is null ? null : TReturn))
     */
    public function betweenAbbr(
        DateTime|DateInterval|string|Stringable|int|null $date1,
        DateTime|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;
}
