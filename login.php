<?php
    session_start();
    require_once 'admin/models/usuarios.php';

    if (isset($_SESSION['usuario_id'])) {
        header('Location: index.php');
        exit;
    }

    $email = '';
    $erro = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        $usuario = new Usuario();
        $logado = $usuario->autenticar($email, $senha);

        if ($logado) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $logado['id'];
            $_SESSION['usuario_nome'] = $logado['nome'];
            $_SESSION['usuario_tipo'] = $logado['tipo'];

            header('Location: index.php');
            exit;
        }

        $erro = 'E-mail ou senha inválidos.';
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Loja Games</title>
    <link rel="stylesheet" href="admin/public/css/style.css">
    <style>
        body {
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--marinho) 0%, var(--marinho-claro) 60%, var(--vinho) 100%);
        }
        .caixa-login {
            background-color: var(--branco);
            border-radius: 10px;
            border-top: 5px solid var(--vinho);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            padding: 35px 30px;
            width: 100%;
            max-width: 360px;
        }
        .caixa-login .logo {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--marinho);
            margin-bottom: 5px;
        }
        .caixa-login .logo span {
            color: var(--vinho);
        }
        .caixa-login .subtitulo {
            text-align: center;
            color: var(--texto-suave);
            font-size: 14px;
            margin: 0 0 25px;
        }
        .caixa-login label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--marinho);
            margin-bottom: 6px;
        }
        .caixa-login input {
            width: 100%;
            margin-bottom: 18px;
        }
        .caixa-login button {
            width: 100%;
            padding: 11px;
            font-size: 15px;
        }
        .erro {
            background-color: var(--erro-fundo);
            color: var(--erro);
            border-left: 4px solid var(--erro);
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 18px;
        }
        .voltar {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            text-decoration: none;
        }
        .voltar:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="caixa-login">
        <div class="logo">Loja <span>Games</span></div>
        <p class="subtitulo">Entre com sua conta</p>

        <?php if ($erro): ?>
            <div class="erro"><?= $erro ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required
                value="<?= htmlspecialchars($email) ?>">

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>

        <a class="voltar" href="index.php">&larr; Voltar para a loja</a>
    </div>
</body>
</html>
