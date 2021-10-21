<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Assert\Assertion;
use Assert\AssertionFailedException;

final class Contract extends ValueObject
{
    public function __construct(public string $contract)
    {
        $this->validateContract();
    }

    private function validateContract(): void
    {
        try {
            Assertion::string($this->contract);
        } catch (AssertionFailedException $e) {
            throw new \Exception('Invalid contract format');
        }
    }
    public function __toString(): string
    {
        return $this->contract;
    }

    public function split(): array
    {
        return str_split($this->contract);
    }
}
