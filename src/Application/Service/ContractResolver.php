<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\Contract;
use App\Domain\ReadModel\ContractReadModel;

class ContractResolver
{
    public function __construct(public ContractReadModel $contractReadModel)
    {
    }

    public function resolve(Contract $contract, Contract $contractVersus): Contract
    {
        $contractValues = $this->contractReadModel->contractsValues(
            $contract->split(),
            $contractVersus->split()
        );

        $contractAmount = ContractCalculator::calculateScore($contract, $contractValues);
        $contractVersusAmount = ContractCalculator::calculateScore($contractVersus, $contractValues);

        return ($contractAmount > $contractVersusAmount) ? $contract : $contractVersus;
    }
}
