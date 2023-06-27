<?php

declare(strict_types=1);

namespace Infrastructure\Common\Bus\Inflector;

use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

/**
 * Handle command by calling the "execute" method.
 */
class ExecuteInflector implements MethodNameInflector
{
    /**
     * {@inheritdoc}
     */
    public function inflect($command, $commandHandler)
    {
        return 'execute';
    }
}
