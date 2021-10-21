<?php

namespace App\Test\Infrastructure\Controllers;

use App\Domain\Messaging\ResolveContractQuery;
use App\Domain\Messaging\ResolveLetterContract;
use App\Domain\Model\Contract;
use App\Infrastructure\Controllers\ContractController;
use App\Infrastructure\Messaging\QueryBus;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

final class ContractControllerTest extends TestCase
{
    private QueryBus $queryBus;
    private ServerRequestInterface $request;
    private ResponseInterface $response;
    private StreamInterface $streamInterface;
    private MessageInterface $messageInterface;

    protected function setUp(): void
    {
        $this->queryBus = $this->createMock(QueryBus::class);
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->streamInterface = $this->createMock(StreamInterface::class);
        $this->messageInterface = $this->createMock(MessageInterface::class);
    }

    public function test_invoke(): void
    {
        $resolveContractQuery = new ResolveContractQuery(
            new Contract('KNV' ?? null),
            new Contract('VV' ?? null),
        );

        $contract = new Contract('KNV');

        $this->request->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['contract' => 'KNV vs VV']);

        $this->queryBus->expects($this->once())
            ->method('dispatch')
            ->with($resolveContractQuery)
            ->willReturn($contract);

        $this->response->expects($this->once())
            ->method('withStatus')
            ->with(200)
            ->willReturnSelf();

        $this->streamInterface->expects($this->once())
            ->method('write')
            ->with(json_encode($contract))
            ->willReturn(2);

        $this->messageInterface->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->response->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($this->messageInterface);

        $sut = new ContractController($this->queryBus);
        $sut($this->request, $this->response);
    }

    public function test_invoke_on_exception(): void
    {
        $resolveContractQuery = new ResolveContractQuery(
            new Contract('KNV' ?? null),
            new Contract('VV' ?? null),
        );

        $this->request->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['contract' => 'KNV vs VV']);

        $this->queryBus->expects($this->once())
            ->method('dispatch')
            ->with($resolveContractQuery)
            ->willThrowException(new \Exception('Test exception', 500));

        $this->response->expects($this->once())
            ->method('withStatus')
            ->with(500)
            ->willReturnSelf();

        $this->streamInterface->expects($this->once())
            ->method('write')
            ->with(json_encode('Test exception'))
            ->willReturn(2);

        $this->messageInterface->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->response->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($this->messageInterface);

        $sut = new ContractController($this->queryBus);
        $sut($this->request, $this->response);
    }

    public function test_invoke_on_wildcard(): void
    {
        $resolveContractQuery = new ResolveLetterContract(
            new Contract('K#V' ?? null),
            new Contract('VV' ?? null),
        );

        $contractLetter = 'N';

        $this->request->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['contract' => 'K#V vs VV']);

        $this->queryBus->expects($this->once())
            ->method('dispatch')
            ->with($resolveContractQuery)
            ->willReturn($contractLetter);

        $this->response->expects($this->once())
            ->method('withStatus')
            ->with(200)
            ->willReturnSelf();

        $this->streamInterface->expects($this->once())
            ->method('write')
            ->with(json_encode($contractLetter))
            ->willReturn(2);

        $this->messageInterface->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->response->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($this->messageInterface);

        $sut = new ContractController($this->queryBus);
        $sut($this->request, $this->response);
    }
}
