<?php

class DBConnect
{
    private ?PDO $pdo = null;

    public function getPDO(): PDO
    {
        if ($this->pdo === null) {
            $dsn = 'mysql:host=127.0.0.1;port=8889;dbname=repertoire;charset=utf8mb4';
            $user     = 'root';
            $password = 'root';

            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return $this->pdo;
    }
}