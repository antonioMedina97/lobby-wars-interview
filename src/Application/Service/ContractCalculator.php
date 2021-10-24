<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\Contract;

class ContractCalculator
{
    private const KING = 'K';
    private const VALIDATOR = 'V';

    public static function calculateScore(Contract $contract, array $scores): int | float
    {
        $contract = $contract->split();

        $kingFound = static::thereIsAKing($contract);

        if($kingFound && in_array(self::VALIDATOR, $contract))
        {
            $contract = array_diff($contract, array(static::VALIDATOR));
        }

        $contractScores = 0;
        foreach ($contract as $contractLetters) {
            $contractScores += $scores[$contractLetters] ?? 0;
        }

        return $contractScores;
    }

    private static function thereIsAKing(array $contract): bool
    {
        return in_array(static::KING, $contract);
    }
}
