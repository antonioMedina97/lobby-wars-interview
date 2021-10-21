<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use App\Domain\Messaging\Query;

abstract class SimpleQueryHandler implements QueryHandler
{
    /**
     * @throws \Exception
     */
    public function handle(Query $query)
    {
        $method = $this->getHandleMethod($query);

        if (! method_exists($this, $method)) {
            throw new \Exception(static::class, $method);
        }

        return $this->$method($query);
    }

    private function getHandleMethod(Query $query): string
    {
        $classParts = explode('\\', get_class($query));

        return 'handle' . end($classParts);
    }
}
