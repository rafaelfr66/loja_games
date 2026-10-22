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
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .caixa-login {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 340px;
        }
        .caixa-login h2 {
            margin-top: 0;
            color: #007bff;
        }
        .caixa-login label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
        .caixa-login input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }
        .caixa-login button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .caixa-login button:hover {
            background-color: #0056b3;
        }
        .erro {
            background-color: #f8d7da;
            color: #dc3545;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .voltar {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="caixa-login">
        <h2>&#127918; Entrar</h2>

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
