<?php

define('servidor', '172.31.207.149');
define('usuario', 'loja');
define('senha', '123456');
define('bd', 'loja_games');

try {
    $pdo = new PDO(
        'mysql:host=' . servidor . ';dbname=' . bd . ';charset=utf8mb4',
        usuario,
        senha
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Banco conectado com sucesso!';

} catch (PDOException $e) {
    echo 'Erro! Não foi possível conectar ao banco. Erro: ' . $e->getMessage();
}