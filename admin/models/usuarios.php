<?php

require_once __DIR__ . '/../config/conexao.php';

class Usuario
{
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $tipo;
    private $pdo;

    public function __construct($atrib = [])
    {
        global $pdo;
        $this->pdo = $pdo;

        if (!empty($atrib)) {
            $this->id = $atrib['id'] ?? null;
            $this->nome = $atrib['nome'];
            $this->email = $atrib['email'];
            $this->senha = $atrib['senha'];
            $this->tipo = $atrib['tipo'] ?? 'user';
        }
    }

    public function buscarPorEmail($email)
    {
        $sth = $this->pdo->prepare(
            "SELECT * FROM usuarios WHERE email = :email"
        );

        $sth->bindValue(':email', $email, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function autenticar($email, $senha)
    {
        $usuario = $this->buscarPorEmail($email);

        if (!$usuario) {
            return false;
        }

        if (password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }

        if (hash_equals($usuario['senha'], hash('sha256', $senha))) {
            $this->atualizarSenha($usuario['id'], $senha);
            return $usuario;
        }

        return false;
    }

    public function atualizarSenha($id, $senha)
    {
        $sth = $this->pdo->prepare(
            "UPDATE usuarios SET senha = :senha, updated_at = NOW() WHERE id = :id"
        );

        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT), PDO::PARAM_STR);

        return $sth->execute();
    }
}
