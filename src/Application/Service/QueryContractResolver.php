<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Messaging\Query;
use App\Domain\Messaging\ResolveContractQuery;
use App\Domain\Messaging\ResolveLetterContract;
use App\Domain\Model\Contract;

class QueryContractResolver
{
    public static function contractQuery(array $contractRequest): Query
    {
        $contract = new Contract($contractRequest[0] ?? null);
        $contractVersus = new Contract($contractRequest[1] ?? null);
        if (static::hasWildcard($contract)) {
            return new ResolveLetterContract($contract, $contractVersus);
        } elseif (static::hasWildcard($contractVersus)) {
            return new ResolveLetterContract($contractVersus, $contract);
        }

        return new ResolveContractQuery($contract, $contractVersus);
    }

    private static function hasWildcard(Contract $contract): bool
    {
        return (str_contains((string)$contract, '#'));
    }
}
