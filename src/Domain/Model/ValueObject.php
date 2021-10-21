<?php

declare(strict_types=1);

namespace App\Domain\Model;

abstract class ValueObject
{
    abstract public function __toString(): string;
}
