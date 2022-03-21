<?php

declare(strict_types=1);

namespace TS\Infrastructure\Cache;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Psr\Cache\CacheItemInterface;

final class CacheItem implements CacheItemInterface
{
    private const DEFAULT_EXPIRATION = 'now +1 year';

    private string $key;
    private mixed $value;
    private bool $hit;
    private DateTimeInterface|int|null $expiration;

    public function __construct(string $key, mixed $value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->hit = null !== $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get(): mixed
    {
        return $this->value;
    }

    public function isHit(): bool
    {
        return $this->hit;
    }

    public function set(mixed $value): static
    {
        $this->value = $value;

        return new self($this->key, $value);
    }

    public function expiresAt(?DateTimeInterface $expiration): static
    {
        $this->expiration = $expiration;
        if (null === $expiration) {
            $this->expiration = new DateTimeImmutable(self::DEFAULT_EXPIRATION);
        }

        return new CacheItem($this->key, $this->value);
    }

    public function expiresAfter(DateInterval|int|null $time): static
    {
        if ($time instanceof DateInterval) {
            $this->expiration = (new DateTimeImmutable())->add($time);

            return new CacheItem($this->key, $this->value);
        }

        if (is_int($time)) {
            $this->expiration = new DateTimeImmutable(sprintf('now +%d seconds', $time));

            return new CacheItem($this->key, $this->value);
        }

        $this->expiration = new DateTimeImmutable(self::DEFAULT_EXPIRATION);

        return new CacheItem($this->key, $this->value);
    }

    public function expiration(): DateTimeInterface|int|null
    {
        return $this->expiration;
    }
}
