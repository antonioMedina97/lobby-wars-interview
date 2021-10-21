<?php

declare(strict_types=1);

namespace App\Domain\Messaging;

use App\Domain\Model\Contract;

class ResolveLetterContract implements Query
{
    public function __construct(public Contract $contract, public Contract $contractVersus)
    {
    }

    public function contract(): Contract
    {
        return $this->contract;
    }

    public function contractVersus(): Contract
    {
        return $this->contractVersus;
    }

    public static function fromArray(array $data): self
    {
        return new static(
            $data['contract'] ?? null,
            $data['contract2'] ?? null
        );
    }

    public function serialize(): array
    {
        return [
            'contract' => $this->contract(),
            'contract2' => $this->contractVersus(),
        ];
    }
}
