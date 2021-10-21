<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use App\Domain\Messaging\Query;

interface QueryBus
{
    public function dispatch(Query $query);
}
