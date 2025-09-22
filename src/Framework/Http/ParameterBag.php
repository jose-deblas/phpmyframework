<?php

namespace Framework\Http;

class ParameterBag implements \ArrayAccess, \IteratorAggregate, \Countable {
    private array $parameters;

    public function __construct(array $parameters = []) {
        $this->parameters = $parameters;
    }

    public function all(): array {
        return $this->parameters;
    }

    public function get(string $key, $default = null): mixed {
        return $this->parameters[$key] ?? $default;
    }

    public function set(string $key, $value): void {
        $this->parameters[$key] = $value;
    }

    public function has(string $key): bool {
        return array_key_exists($key, $this->parameters);
    }

    public function remove(string $key): void {
        unset($this->parameters[$key]);
    }

    public function clear(): void {
        $this->parameters = [];
    }

    public function replace(array $parameters): void {
        $this->parameters = $parameters;
    }

    public function count(): int {
        return count($this->parameters);
    }

    public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->parameters);
    }

    public function offsetExists(mixed $offset): bool {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void {
        if (null === $offset) {
            throw new \InvalidArgumentException('Key cannot be null');
        }
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void {
        $this->remove($offset);
    }
}
