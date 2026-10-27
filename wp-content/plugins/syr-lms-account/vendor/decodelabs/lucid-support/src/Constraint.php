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
 * @template TParam
 * @template TValue
 */
interface Constraint
{
    /**
     * @param Processor<TValue> $processor
     */
    public function __construct(Processor $processor);

    /**
     * @return array<string>|null
     */
    public static function getProcessorOutputTypes(): ?array;

    public function getName(): string;
    public function getWeight(): int;

    /**
     * @return Processor<TValue>
     */
    public function getProcessor(): Processor;

    /**
     * @param TParam $param
     * @return $this
     */
    public function setParameter(mixed $param): static;
    public function getParameter(): mixed;

    public function prepareValue(mixed $value): mixed;

    /**
     * @param TValue $value
     * @return TValue|null
     */
    public function alterValue(mixed $value): mixed;

    /**
     * @param TValue|null $value
     * @return Generator<int, Error|null, mixed, bool>
     */
    public function validate(mixed $value): Generator;
}
