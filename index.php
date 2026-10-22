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
        .destaque {
            background-color: var(--marinho-claro);
            color: var(--branco);
            text-align: center;
            padding: 40px 20px;
        }
        .destaque h2 {
            color: var(--branco);
            font-size: 30px;
            margin: 0 0 8px;
        }
        .destaque p {
            margin: 0;
            color: rgba(255, 255, 255, 0.75);
        }
        .titulo-secao {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            border-bottom: 2px solid var(--borda);
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .titulo-secao h2 {
            margin: 0;
            text-align: left;
            font-size: 22px;
        }
        .titulo-secao span {
            color: var(--texto-suave);
            font-size: 14px;
        }
        .vitrine {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
        }
        .card {
            background-color: var(--branco);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(20, 33, 61, 0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(20, 33, 61, 0.15);
        }
        .card img,
        .card .sem-imagem {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 0;
        }
        .card .sem-imagem {
            background: linear-gradient(135deg, var(--marinho), var(--vinho));
            color: rgba(255, 255, 255, 0.6);
            font-size: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card .info {
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }
        .categoria {
            color: var(--vinho);
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .card h3 {
            margin: 0;
            font-size: 18px;
            color: var(--marinho);
        }
        .card p {
            margin: 0;
            color: var(--texto-suave);
            font-size: 14px;
            line-height: 1.4;
            flex: 1;
        }
        .card .rodape-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--borda);
            padding-top: 12px;
            margin-top: 5px;
        }
        .preco {
            font-size: 20px;
            font-weight: bold;
            color: var(--marinho);
        }
        .estoque {
            font-size: 12px;
            color: var(--texto-suave);
        }
        .esgotado {
            color: var(--erro);
            font-weight: bold;
        }
        .vazio {
            text-align: center;
            color: var(--texto-suave);
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <div class="topo">
        <a class="logo" href="index.php">Loja <span>Games</span></a>
        <div class="acoes">
            <form method="GET" action="">
                <input type="text" name="buscar" placeholder="Buscar por nome..."
                    value="<?= htmlspecialchars($nome) ?>">
                <button type="submit">Buscar</button>
            </form>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span class="ola">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
                <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                    <a class="btn btn-contorno" href="admin/views/ver_games.php">Gerenciar Games</a>
                <?php endif; ?>
                <a class="btn btn-contorno" href="logout.php">Sair</a>
            <?php else: ?>
                <a class="btn btn-contorno" href="login.php">Entrar</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!$nome): ?>
        <div class="destaque">
            <h2>Os melhores jogos estão aqui</h2>
            <p>Confira nosso catálogo e encontre seu próximo game.</p>
        </div>
    <?php endif; ?>

    <div class="conteudo">
        <div class="titulo-secao">
            <h2><?= $nome ? 'Resultados para "' . htmlspecialchars($nome) . '"' : 'Nossos Jogos' ?></h2>
            <span><?= count($games) ?> jogo(s)</span>
        </div>

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
                            <div class="rodape-card">
                                <span class="preco">R$ <?= number_format($g['preco'], 2, ',', '.') ?></span>
                                <?php if ($g['estoque'] > 0): ?>
                                    <span class="estoque"><?= $g['estoque'] ?> em estoque</span>
                                <?php else: ?>
                                    <span class="estoque esgotado">Esgotado</span>
                                <?php endif; ?>
                            </div>
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
