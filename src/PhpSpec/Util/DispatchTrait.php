<?php

namespace PhpSpec\Util;

use PhpSpec\Wrapper\Collaborator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @internal
 */
trait DispatchTrait
{
    private function dispatch(object $eventDispatcher, object $event, string $eventName) : object
    {
        if ($this->isNewSymfonyContract($eventDispatcher)) {
            return $eventDispatcher->dispatch($event, $eventName);
        }

        return $eventDispatcher->dispatch($eventName, $event);
    }

    private function isNewSymfonyContract(object $eventDispatcher): bool
    {
        // This trait may be used with a double, in the tests
        if ($eventDispatcher instanceof Collaborator) {
            $eventDispatcher = $eventDispatcher->getWrappedObject();
        }

        // EventDispatcherInterface contract implemented in Symfony >= 4.3
        return $eventDispatcher instanceof EventDispatcherInterface;
    }
}
