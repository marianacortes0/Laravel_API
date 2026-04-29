<?php
// migrate.php - ejecutar UNA sola vez luego eliminar o proteger
if (php_sapi_name() !== 'cli' && $_SERVER['HTTP_HOST'] !== 'laravel-api.azurewebsites.net') {
    die('No autorizado');
}
chdir(__DIR__);
echo shell_exec('php artisan migrate --force 2>&1');