<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel;

use \PDO;
use App\Domain\ReadModel\ContractReadModel;

class PDOContractReadModel implements ContractReadModel
{
    public function __construct(public PDO $mysqlClient)
    {
    }

    public function contractsValues(array ...$contracts): array
    {
        $contractsLetters = array_unique(array_merge_recursive(...$contracts));

        $qMarks = str_repeat('? or contract_letter =', count($contractsLetters) - 1) . '?';

        $query = <<<SQL
                        select 
                            contract_letter as letter,
                            contract_letter_score as score
                        from contracts
                        where contract_letter = $qMarks 
                    SQL;

        $pdoStatement = $this->mysqlClient->prepare($query);
        $pdoStatement->execute($contractsLetters);

        $result = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $total = [];
        foreach ($result as $item) {
            $total[$item['letter']] = $item['score'];
        }

        return $total;
    }
}
