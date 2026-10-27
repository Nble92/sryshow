<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos;

use DateTimeZone as Timezone;
use DecodeLabs\Cosmos;
use DecodeLabs\Veneer;
use DecodeLabs\Veneer\Plugin;
use IntlTimeZone;
use Locale as SysLocale;

class Context
{
    #[Plugin]
    public Locale $locale;

    #[Plugin]
    public Timezone $timezone;


    /**
     * Initialize system settings
     */
    protected function __construct()
    {
        // Locale
        $this->setLocale(SysLocale::getDefault());

        // Timezone
        date_default_timezone_set('UTC');
        $this->setTimezone('UTC');
    }


    /**
     * Set locale
     *
     * @return $this
     */
    public function setLocale(
        string|Locale $locale
    ): static {
        if (!$locale instanceof Locale) {
            $locale = new Locale($locale);
        }

        SysLocale::setDefault((string)$locale);
        Veneer::replacePlugin($this, 'locale', $locale);
        return $this;
    }

    /**
     * Get locale
     */
    public function getLocale(): Locale
    {
        return $this->locale;
    }

    /**
     * Normalize locale
     */
    public function normalizeLocale(
        string|Locale|null $locale = null
    ): Locale {
        if ($locale === null) {
            $locale = $this->getLocale();
        } elseif (is_string($locale)) {
            $locale = new Locale($locale);
        }

        return $locale;
    }

    /**
     * Normalize locale
     */
    public function normalizeLocaleString(
        string|Locale|null $locale = null
    ): string {
        return (string)$this->normalizeLocale($locale);
    }



    /**
     * Set timezone
     *
     * @return $this
     */
    public function setTimezone(
        string|Timezone $timezone
    ): static {
        if (!$timezone instanceof Timezone) {
            $timezone = $this->createTimezone($timezone);
        }

        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     */
    public function getTimezone(): Timezone
    {
        return $this->timezone;
    }

    /**
     * Normalize timezone
     */
    public function normalizeTimezone(
        string|Timezone|null $timezone
    ): Timezone {
        if ($timezone === null) {
            $timezone = $this->getTimezone();
        } elseif (is_string($timezone)) {
            $timezone = $this->createTimezone($timezone);
        }

        return $timezone;
    }

    /**
     * Normalize timezone
     */
    public function normalizeTimezoneString(
        string|Timezone|null $timezone
    ): string {
        return $this->normalizeTimezone($timezone)->getName();
    }

    /**
     * Parse and create DateTimeZone
     */
    protected function createTimezone(
        string $timezone
    ): Timezone {
        if (preg_match('/^[a-z]{3}$/', $timezone)) {
            $timezone = strtoupper($timezone);
        } elseif (preg_match('|^([a-z\-]+)/([a-z\-]+)$|', $timezone, $matches)) {
            $timezone = ucfirst($matches[1]) . '/' . ucfirst($matches[2]);
        }

        if (false !== ($canon = IntlTimeZone::getCanonicalID($timezone))) {
            $timezone = $canon;
        }

        return new Timezone($timezone);
    }
}


// Register the Veneer facade
Veneer::register(Context::class, Cosmos::class);
