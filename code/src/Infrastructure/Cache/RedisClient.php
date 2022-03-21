<?php

declare(strict_types=1);

namespace TS\Infrastructure\Cache;

use Predis\Client;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

final class RedisClient implements CacheItemPoolInterface
{
    /**
     * @var CacheItemInterface[]
     */
    private array $deferred;

    private Client $client;

    public function __construct(string $redisHost, string $redisPassword, string $redisPort)
    {
        $this->client = new Client([
            'host' => $redisHost,
            'port' => $redisPort,
        ], [
            'parameters' => [
                'password' => $redisPassword,
            ],
        ]);

        $this->client->connect();
    }

    public function getItem(string $key): CacheItemInterface
    {
        $value = $this->client->get($key);

        return new CacheItem($key, $value);
    }

    /**
     * @return CacheItemInterface[]
     */
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
        return (bool) $this->client->flushall();
    }

    public function deleteItem(string $key): bool
    {
        return (bool) $this->client->del($key);
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
        return (bool) $this->client->set($item->getKey(), $item->get());
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->deferred[] = $item;

        return true;
    }

    public function commit(): bool
    {
        foreach ($this->deferred as $item) {
            $this->save($item);
        }

        return true;
    }
}
