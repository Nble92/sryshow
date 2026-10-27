<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @template TOutput
 */
interface Processor
{
    public function __construct(Sanitizer $sanitizer);

    /**
     * @return array<string>
     */
    public function getOutputTypes(): array;

    public function getName(): string;
    public function getSanitizer(): Sanitizer;

    /**
     * Does this processor require a list of values?
     */
    public function isMultiValue(): bool;

    /**
     * Prepare value before coercion
     */
    public function prepareValue(mixed $value): mixed;

    /**
     * Apply value processing before validation
     *
     * @param TOutput $value
     * @return TOutput|null
     */
    public function alterValue(mixed $value): mixed;

    /**
     * Coerce input to output type or null
     *
     * @return TOutput|null
     */
    public function coerce(mixed $value): mixed;


    /**
     * Test validity of constraint
     *
     * @return $this
     */
    public function test(
        string $constraint,
        mixed $param
    ): static;


    /**
     * @return array<string, mixed>
     */
    public function getDefaultConstraints(): array;


    /**
     * @return array<string, Constraint<mixed, TOutput>>
     */
    public function prepareConstraints(): array;


    /**
     * Test constraints and yield errors in sequence
     *
     * @param TOutput|null $value
     * @return Generator<Error|null>
     */
    public function validate(mixed $value): Generator;

    /**
     * Test type and yield errors in sequence
     *
     * @param TOutput|null $value
     * @return Generator<Error|null>
     */
    public function validateType(mixed $value): Generator;
}
