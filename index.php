<?php
    session_start();
    require_once 'admin/models/games.php';
    $game = new Game();

    $nome = $_GET['buscar'] ?? '';
    $games = $nome ? $game->buscarPorNome($nome) : $game->listarGames();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Games</title>
    <link rel="stylesheet" href="admin/public/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .topo {
            background-color: #007bff;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .topo h1 {
            margin: 0;
            font-size: 26px;
        }
        .topo form {
            display: flex;
            gap: 10px;
        }
        .topo input {
            padding: 8px;
            border: none;
            border-radius: 5px;
            width: 220px;
        }
        .topo button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #0056b3;
            color: white;
            cursor: pointer;
        }
        .topo button:hover,
        .topo .btn-admin:hover {
            background-color: #004085;
        }
        .topo .acoes {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .topo .ola {
            align-self: center;
            font-size: 14px;
        }
        .topo .btn-admin {
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #0056b3;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }
        .conteudo {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }
        .vitrine {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .card img,
        .card .sem-imagem {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 0;
        }
        .card .sem-imagem {
            background-color: #ddd;
            color: #888;
            font-size: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card .info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }
        .card h3 {
            margin: 0;
            font-size: 18px;
        }
        .categoria {
            align-self: flex-start;
            background-color: #e7f1ff;
            color: #007bff;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 10px;
        }
        .card p {
            margin: 0;
            color: #555;
            font-size: 14px;
            flex: 1;
        }
        .preco {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
        }
        .estoque {
            font-size: 13px;
            color: #888;
        }
        .esgotado {
            color: #dc3545;
        }
        .vazio {
            text-align: center;
            color: #888;
        }
        .rodape {
            text-align: center;
            color: #888;
            font-size: 13px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="topo">
        <h1>&#127918; Loja Games</h1>
        <div class="acoes">
            <form method="GET" action="">
                <input type="text" name="buscar" placeholder="Buscar por nome..."
                    value="<?= htmlspecialchars($nome) ?>">
                <button type="submit">Buscar</button>
            </form>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span class="ola">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
                <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                    <a class="btn-admin" href="admin/views/ver_games.php">Gerenciar Games</a>
                <?php endif; ?>
                <a class="btn-admin" href="logout.php">Sair</a>
            <?php else: ?>
                <a class="btn-admin" href="login.php">Entrar</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="conteudo">
        <h2><?= $nome ? 'Resultados para "' . htmlspecialchars($nome) . '"' : 'Nossos Jogos' ?></h2>

        <?php if (count($games) > 0): ?>
            <div class="vitrine">
                <?php foreach ($games as $g): ?>
                    <div class="card">
                        <?php if ($g['imagem'] && file_exists('admin/public/imagens/' . $g['imagem'])): ?>
                            <img src="admin/public/imagens/<?= htmlspecialchars($g['imagem']) ?>"
                                alt="<?= htmlspecialchars($g['titulo']) ?>">
                        <?php else: ?>
                            <div class="sem-imagem">&#127918;</div>
                        <?php endif; ?>

                        <div class="info">
                            <span class="categoria"><?= htmlspecialchars($g['categoria']) ?></span>
                            <h3><?= htmlspecialchars($g['titulo']) ?></h3>
                            <p><?= htmlspecialchars($g['descricao']) ?></p>
                            <span class="preco">R$ <?= number_format($g['preco'], 2, ',', '.') ?></span>
                            <?php if ($g['estoque'] > 0): ?>
                                <span class="estoque"><?= $g['estoque'] ?> em estoque</span>
                            <?php else: ?>
                                <span class="estoque esgotado">Esgotado</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="vazio">Nenhum jogo encontrado.</p>
        <?php endif; ?>
    </div>

    <div class="rodape">Loja Games &copy; <?= date('Y') ?></div>
</body>
</html>
