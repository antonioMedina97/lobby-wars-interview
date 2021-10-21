<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use App\Domain\Messaging\Query;
use Psr\Container\ContainerInterface;

class SimpleQueryBus implements QueryBus
{
    public function __construct(public ContainerInterface $container)
    {
    }

    public function dispatch(Query $query)
    {
        $handlerClass = \get_class($query) . 'Handler';

        if ($handler = $this->container->make($handlerClass)) {
            return $handler->handle($query);
        }

        throw new \Exception();
    }
}
