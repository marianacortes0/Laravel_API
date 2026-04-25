<?php

namespace App\Models;

/**
 * Modelo User
 * 
 * Equivalente al interface User + array users[] de TypeScript.
 * Simula una base de datos en memoria con un array estático.
 */
class User
{
    public int $id;
    public string $name;
    public string $email;
    public int $age;

    public function __construct(int $id, string $name, string $email, int $age)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->email = $email;
        $this->age   = $age;
    }

    // -------------------------------------------------------
    // "Base de datos" simulada (equivalente al array users[])
    // -------------------------------------------------------

    /** @var self[] */
    private static array $users = [];

    private static bool $initialized = false;

    /**
     * Inicializa el array con datos de ejemplo (se ejecuta una sola vez).
     */
    private static function init(): void
    {
        if (self::$initialized) {
            return;
        }

        self::$users = [
            new self(1, 'Alice',   'alice@example.com',   30),
            new self(2, 'Bob',     'bob@example.com',     25),
            new self(3, 'Charlie', 'charlie@example.com', 35),
        ];

        self::$initialized = true;
    }

    // -------------------------------------------------------
    // Métodos de acceso al "repositorio"
    // -------------------------------------------------------

    /** Devuelve todos los usuarios. */
    public static function all(): array
    {
        self::init();
        return array_values(self::$users);
    }

    /** Busca un usuario por ID. Retorna null si no existe. */
    public static function find(int $id): ?self
    {
        self::init();
        foreach (self::$users as $user) {
            if ($user->id === $id) {
                return $user;
            }
        }
        return null;
    }

    /** Crea y persiste un nuevo usuario. */
    public static function create(string $name, string $email, int $age): self
    {
        self::init();

        $newId = count(self::$users) > 0
            ? max(array_map(fn($u) => $u->id, self::$users)) + 1
            : 1;

        $user = new self($newId, $name, $email, $age);
        self::$users[] = $user;

        return $user;
    }


}