<?php

namespace App\Test\Application\Service;

use App\Application\Service\ContractResolver;
use App\Domain\Model\Contract;
use App\Domain\ReadModel\ContractReadModel;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ContractResolverTest extends TestCase
{
    public function test_aa()
    {
        $contract = new Contract('KNV');
        $contractVersus = new Contract('NVV');

        $contractValues = ['K' => 5, 'N' => 2, 'V' => 1];

        $contractReadModel = $this->createMock(ContractReadModel::class);

        $contractReadModel->expects($this->once())
            ->method('contractsValues')
            ->with($contract->split(), $contractVersus->split())
            ->willReturn($contractValues);

        $contractResolver = new ContractResolver($contractReadModel);

        Assert::assertEquals($contract, $contractResolver->resolve($contract, $contractVersus));
    }
}