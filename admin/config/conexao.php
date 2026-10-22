<?php

$env = __DIR__ . '/../../.env';

if (file_exists($env)) {
    foreach (file($env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
        if (str_starts_with(trim($linha), '#') || !str_contains($linha, '=')) {
            continue;
        }

        [$chave, $valor] = explode('=', $linha, 2);

        if (getenv(trim($chave)) === false) {
            putenv(trim($chave) . '=' . trim($valor));
        }
    }
}

define('servidor', getenv('DB_HOST'));
define('usuario', getenv('DB_USER'));
define('senha', getenv('DB_PASS'));
define('bd', getenv('DB_NAME'));

try {
    $pdo = new PDO(
        'mysql:host=' . servidor . ';dbname=' . bd . ';charset=utf8mb4',
        usuario,
        senha
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    echo 'Erro! Não foi possível conectar ao banco. Erro: ' . $e->getMessage();
}