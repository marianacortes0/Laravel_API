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




}