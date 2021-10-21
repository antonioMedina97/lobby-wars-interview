<?php

declare(strict_types=1);

namespace App\Domain\Messaging;

use App\Application\Service\ContractResolver;
use App\Domain\Model\Contract;
use App\Infrastructure\Messaging\SimpleQueryHandler;

final class ResolveContractQueryHandler extends SimpleQueryHandler
{
    public function __construct(public ContractResolver $contractResolver)
    {
    }

    public function handleResolveContractQuery(ResolveContractQuery $resolveContractQuery): Contract
    {
        $contract = $resolveContractQuery->contract();
        $contractVersus = $resolveContractQuery->contractVersus();

        return $this->contractResolver->resolve($contract, $contractVersus);
    }
}
