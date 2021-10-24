<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\Contract;
use App\Domain\ReadModel\ContractReadModel;

class ContractResolver
{
    private const RULER = 'Z';
    public function __construct(public ContractReadModel $contractReadModel)
    {
    }

    public function resolve(Contract $contract, Contract $contractVersus): Contract
    {
        if(str_contains((string)$contract, static::RULER)){
            $winningContract = $contract;
        }
        else if(str_contains((string)$contractVersus, static::RULER)){
            $winningContract = $contractVersus;
        }
        else{
            $contractValues = $this->contractReadModel->contractsValues(
                $contract->split(),
                $contractVersus->split()
            );
    
            $contractAmount = ContractCalculator::calculateScore($contract, $contractValues);
            $contractVersusAmount = ContractCalculator::calculateScore($contractVersus, $contractValues);

            $winningContract = ($contractAmount > $contractVersusAmount) ? $contract : $contractVersus;
        }


        return $winningContract;
    }
}
