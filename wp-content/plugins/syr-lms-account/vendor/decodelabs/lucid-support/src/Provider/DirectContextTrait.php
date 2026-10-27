<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Provider;

use Closure;
use DecodeLabs\Lucid\Constraint\NotFoundException as ConstraintNotFoundException;
use DecodeLabs\Lucid\ProviderTrait;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;
use Exception;

trait DirectContextTrait
{
    use ProviderTrait;

    public function cast(
        string $type,
        mixed $value,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($value)->as($type, $setup);
    }

    public function validate(
        string $type,
        mixed $value,
        array|Closure|null $setup = null
    ): Result {
        return $this->sanitize($value)->validate($type, $setup);
    }

    public function is(
        string $type,
        mixed $value,
        array|Closure|null $setup = null
    ): bool {
        try {
            return $this->validate($type, $value, $setup)->isValid();
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sanitize(mixed $value): Sanitizer
    {
        return $this->newSanitizer($value);
    }
}
