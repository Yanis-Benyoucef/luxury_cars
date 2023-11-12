<?php

function getConnection(): PDO
{
    $dbConfig = parse_ini_file(__DIR__ . '/../config/db.ini');

    [
        'DB_HOST'     => $host,
        'DB_PORT'     => $port,
        'DB_NAME'     => $dbName,
        'DB_CHARSET'  => $dbCharset,
        'DB_USER'     => $user,
        'DB_PASSWORD' => $password
    ] = $dbConfig;

    $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=$dbCharset";

    return new PDO($dsn, $user, $password, [
        // Je définis le mode d'erreur à Exception : PDO lancera une exception en cas d'erreur
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        // Je définis le mode de lecture des résultats de requête à un tableau associatif : à chaque fois que je ferai un $stmt->fetch() ou bien $stmt->fetchAll(), PDO me retournera automatiquement un tableau associatif
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}