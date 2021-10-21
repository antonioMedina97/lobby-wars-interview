<?php

declare(strict_types=1);

namespace App\Domain\ReadModel;

interface ContractReadModel
{
    public function contractsValues(array ...$contracts): array;
}
