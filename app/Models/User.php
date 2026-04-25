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






}