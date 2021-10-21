<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging;

use App\Domain\Messaging\Query;

interface QueryHandler
{
    public function handle(Query $query);
}
