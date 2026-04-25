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

    /**
     * Actualiza los campos proporcionados de un usuario existente.
     * Retorna el usuario actualizado o null si no existe.
     */
    public static function update(int $id, array $data): ?self
    {
        self::init();

        foreach (self::$users as $user) {
            if ($user->id === $id) {
                if (isset($data['name']))  $user->name  = $data['name'];
                if (isset($data['email'])) $user->email = $data['email'];
                if (isset($data['age']))   $user->age   = (int) $data['age'];
                return $user;
            }
        }

        return null;
    }

    /**
     * Elimina un usuario por ID.
     * Retorna true si fue eliminado, false si no existía.
     */
    public static function delete(int $id): bool
    {
        self::init();

        foreach (self::$users as $index => $user) {
            if ($user->id === $id) {
                array_splice(self::$users, $index, 1);
                return true;
            }
        }

        return false;
    }

    /** Serializa el objeto a array (útil para json()). */
    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'age'   => $this->age,
        ];
    }
}