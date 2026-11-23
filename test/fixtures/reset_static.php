<?php

namespace App\Service;

use App\Attribute\WorkerSafe;
use Symfony\Contracts\Service\ResetInterface;

// Detected: mutated through self:: and never cleared.
class StaticNotReset implements ResetInterface
{
    private static array $cache = [];

    public function add(): void
    {
        self::$cache[] = 1;
    }

    public function reset(): void
    {
    }
}

// Detected: mutated through static:: and never cleared.
class LateStaticNotReset implements ResetInterface
{
    private static int $counter = 0;

    public function increment(): void
    {
        static::$counter++;
    }

    public function reset(): void
    {
    }
}

// Ignored: cleared in reset().
class StaticCleared implements ResetInterface
{
    private static array $cleared = [];

    public function add(): void
    {
        self::$cleared[] = 1;
    }

    public function reset(): void
    {
        self::$cleared = [];
    }
}

// Ignored: self:: and static:: address the same property.
class StaticClearedWithOtherScope implements ResetInterface
{
    private static array $mixed = [];

    public function add(): void
    {
        self::$mixed[] = 1;
    }

    public function reset(): void
    {
        static::$mixed = [];
    }
}

// Ignored: explicitly marked as safe across requests.
class StaticWorkerSafe implements ResetInterface
{
    #[WorkerSafe]
    private static array $safe = [];

    public function add(): void
    {
        self::$safe[] = 1;
    }

    public function reset(): void
    {
    }
}
