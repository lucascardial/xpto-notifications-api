<?php

namespace Core\Interfaces\Cqrs;

interface QueryHandlerInterface
{
    public function handle(QueryInterface $query): mixed;
}
