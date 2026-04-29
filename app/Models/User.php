<?php

namespace App\Models;

use JsonSerializable;

class User implements JsonSerializable
{
    public int $id;
    public string $name;
    public string $email;
    public int $age;

    public function __construct(array $attrs = [])
    {
        $this->id    = (int) ($attrs['id']    ?? 0);
        $this->name  = (string) ($attrs['name']  ?? '');
        $this->email = (string) ($attrs['email'] ?? '');
        $this->age   = (int) ($attrs['age']   ?? 0);
    }

    private static function file(): string
    {
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'laravel-api-users-' . getmypid() . '.json';
    }

    private static function load(): array
    {
        $file = self::file();
        if (!file_exists($file)) {
            $seed = [
                ['id' => 1, 'name' => 'Alice',   'email' => 'alice@example.com',   'age' => 30],
                ['id' => 2, 'name' => 'Bob',     'email' => 'bob@example.com',     'age' => 25],
                ['id' => 3, 'name' => 'Charlie', 'email' => 'charlie@example.com', 'age' => 35],
            ];
            self::persist($seed, 4);
            return ['users' => $seed, 'nextId' => 4];
        }
        return json_decode(file_get_contents($file), true);
    }

    private static function persist(array $users, int $nextId): void
    {
        file_put_contents(self::file(), json_encode(['users' => $users, 'nextId' => $nextId]));
    }

    public static function all(): array
    {
        return array_map(fn($u) => new self($u), self::load()['users']);
    }

    public static function find(int $id): ?self
    {
        foreach (self::load()['users'] as $u) {
            if ($u['id'] === $id) {
                return new self($u);
            }
        }
        return null;
    }

    public static function create(array $attrs): self
    {
        $state = self::load();
        $new = [
            'id'    => $state['nextId'],
            'name'  => (string) $attrs['name'],
            'email' => (string) $attrs['email'],
            'age'   => (int) $attrs['age'],
        ];
        $state['users'][] = $new;
        self::persist($state['users'], $state['nextId'] + 1);
        return new self($new);
    }

    public static function where(string $field, mixed $value): object
    {
        $found = array_filter(self::load()['users'], fn($u) => ($u[$field] ?? null) === $value);

        return new class($found) {
            public function __construct(private array $found) {}
            public function exists(): bool { return count($this->found) > 0; }
        };
    }

    public function update(array $attrs): self
    {
        $state = self::load();
        foreach ($state['users'] as &$u) {
            if ($u['id'] === $this->id) {
                foreach (['name', 'email', 'age'] as $f) {
                    if (array_key_exists($f, $attrs)) {
                        $u[$f]       = $f === 'age' ? (int) $attrs[$f] : (string) $attrs[$f];
                        $this->{$f}  = $u[$f];
                    }
                }
                break;
            }
        }
        self::persist($state['users'], $state['nextId']);
        return $this;
    }

    public function delete(): bool
    {
        $state = self::load();
        $state['users'] = array_values(array_filter(
            $state['users'],
            fn($u) => $u['id'] !== $this->id
        ));
        self::persist($state['users'], $state['nextId']);
        return true;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'age'   => $this->age,
        ];
    }
}
