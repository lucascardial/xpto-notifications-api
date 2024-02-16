<?php

namespace Core\Interfaces\Cqrs;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}
