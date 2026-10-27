<?php
/**
 * This is a stub file for IDE compatibility only.
 * It should not be included in your projects.
 */
namespace DecodeLabs;

use DecodeLabs\Veneer\Proxy as Proxy;
use DecodeLabs\Veneer\ProxyTrait as ProxyTrait;
use DecodeLabs\Cosmos\Context as Inst;
use DecodeLabs\Cosmos\Locale as LocalePlugin;
use DateTimeZone as TimezonePlugin;

class Cosmos implements Proxy
{
    use ProxyTrait;

    const VENEER = 'DecodeLabs\\Cosmos';
    const VENEER_TARGET = Inst::class;

    public static Inst $instance;
    public static LocalePlugin $locale;
    public static TimezonePlugin $timezone;

    public static function setLocale(LocalePlugin|string $locale): Inst {
        return static::$instance->setLocale(...func_get_args());
    }
    public static function getLocale(): LocalePlugin {
        return static::$instance->getLocale();
    }
    public static function normalizeLocale(LocalePlugin|string|null $locale = NULL): LocalePlugin {
        return static::$instance->normalizeLocale(...func_get_args());
    }
    public static function normalizeLocaleString(LocalePlugin|string|null $locale = NULL): string {
        return static::$instance->normalizeLocaleString(...func_get_args());
    }
    public static function setTimezone(TimezonePlugin|string $timezone): Inst {
        return static::$instance->setTimezone(...func_get_args());
    }
    public static function getTimezone(): TimezonePlugin {
        return static::$instance->getTimezone();
    }
    public static function normalizeTimezone(TimezonePlugin|string|null $timezone): TimezonePlugin {
        return static::$instance->normalizeTimezone(...func_get_args());
    }
    public static function normalizeTimezoneString(TimezonePlugin|string|null $timezone): string {
        return static::$instance->normalizeTimezoneString(...func_get_args());
    }
};
