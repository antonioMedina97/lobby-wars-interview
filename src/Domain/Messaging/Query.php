<?php

declare(strict_types=1);

namespace App\Domain\Messaging;

interface Query
{
    public static function fromArray(array $data);

    public function serialize(): array;
}
