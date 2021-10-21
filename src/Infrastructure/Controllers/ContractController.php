<?php

declare(strict_types=1);

namespace App\Infrastructure\Controllers;

use Psr\Http\Message\ResponseInterface;
use App\Infrastructure\Messaging\QueryBus;
use Psr\Http\Message\ServerRequestInterface;
use App\Application\Service\QueryContractResolver;

class ContractController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $contract = $queryParams['contract'] ? explode(' vs ', $queryParams['contract']) : null;

        try {
            $contractWinner = $this->queryBus->dispatch(QueryContractResolver::contractQuery($contract));

            $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->getBody()
                ->write(json_encode($contractWinner));
        } catch (\Throwable $e) {
            $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->getBody()
                ->write(json_encode($e->getMessage()));
        }

        return $response;
    }
}
