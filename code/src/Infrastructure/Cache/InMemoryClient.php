<?php

declare(strict_types=1);

namespace TS\Infrastructure\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

final class InMemoryClient implements CacheItemPoolInterface
{
    public function __construct(private array $items = [])
    {
    }

    public function getItem(string $key): CacheItemInterface
    {
        return new CacheItem($key, $this->items[$key] ?? null);
    }

    public function getItems(array $keys = []): array
    {
        $items = [];
        foreach ($keys as $key) {
            $items[] = $this->getItem($key);
        }

        return $items;
    }

    public function hasItem(string $key): bool
    {
        return $this->getItem($key)->isHit();
    }

    public function clear(): bool
    {
        $this->items = [];

        return true;
    }

    public function deleteItem(string $key): bool
    {
        if (in_array($key, $this->items, true)) {
            unset($this->items[$key]);
        }

        return true;
    }

    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            $this->deleteItem($key);
        }

        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        $this->items[$item->getKey()] = $item->get();

        return true;
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        return $this->save($item);
    }

    public function commit(): bool
    {
        return true;
    }
}
