<?php

declare(strict_types=1);

namespace App\Domain\Messaging;

use App\Application\Service\ContractLetterResolver;
use App\Infrastructure\Messaging\SimpleQueryHandler;

final class ResolveLetterContractHandler extends SimpleQueryHandler
{
    public function __construct(public ContractLetterResolver $contractLetterResolver)
    {
    }

    public function handleResolveLetterContract(ResolveLetterContract $resolveContractQuery): string
    {
        $contract = $resolveContractQuery->contract();
        $contractVersus = $resolveContractQuery->contractVersus();

        return $this->contractLetterResolver->resolve($contract, $contractVersus);
    }
}
