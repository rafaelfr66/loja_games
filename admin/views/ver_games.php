<?php
    require_once '../config/auth.php';
    require_once '../models/games.php';
    $game = new Game();

    $nome = $_GET['buscar'] ?? '';
    $games = $nome ? $game->buscarPorNome($nome) : $game->listarGames();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Jogos - Loja Games</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .top-bar h2 {
            margin: 0;
            text-align: left;
        }
        .top-bar form {
            display: flex;
            gap: 8px;
        }
        .tabela {
            overflow-x: auto;
        }
        td.titulo {
            text-align: left;
            font-weight: 600;
            color: var(--marinho);
        }
        td.descricao {
            text-align: left;
            color: var(--texto-suave);
            font-size: 14px;
            max-width: 280px;
        }
        .actions {
            white-space: nowrap;
        }
        .actions a {
            font-size: 13px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 0 2px;
        }
        .actions .editar {
            color: var(--marinho);
            border: 1px solid var(--marinho);
        }
        .actions .editar:hover {
            background-color: var(--marinho);
            color: var(--branco);
        }
        .actions .excluir {
            color: var(--erro);
            border: 1px solid var(--erro);
        }
        .actions .excluir:hover {
            background-color: var(--erro);
            color: var(--branco);
        }
    </style>
    <script>
        function confirmarExclusao(titulo, id) {
            if (confirm('Tem certeza que deseja excluir o jogo "' + titulo + '"?')) {
                window.location.href = '../controllers/deletar_game.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="topo">
        <a class="logo" href="../../index.php">Loja <span>Games</span></a>
        <div class="acoes">
            <span class="ola">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
            <a class="btn btn-contorno" href="../../index.php">Ver Loja</a>
            <a class="btn btn-contorno" href="../../logout.php">Sair</a>
        </div>
    </div>

    <div class="conteudo">
        <div class="top-bar">
            <h2>Gerenciar Jogos</h2>
            <form method="GET" action="">
                <input type="text" name="buscar" placeholder="Buscar por nome..."
                    value="<?= htmlspecialchars($nome) ?>">
                <button type="submit">Buscar</button>
            </form>
            <a class="btn" href="cadastrar_game.php">+ Cadastrar Novo Jogo</a>
        </div>

        <div class="tabela">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Categoria</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
                <?php if (count($games) > 0): ?>
                    <?php foreach ($games as $g): ?>
                        <tr>
                            <td><?= $g['id'] ?></td>
                            <td class="titulo"><?= $g['titulo'] ?></td>
                            <td class="descricao"><?= $g['descricao'] ?></td>
                            <td>R$ <?= number_format($g['preco'], 2, ',', '.') ?></td>
                            <td><?= $g['estoque'] ?></td>
                            <td><?= $g['categoria'] ?></td>
                            <td><?= $g['imagem'] ?></td>
                            <td class="actions">
                                <a class="editar" href="editar_game.php?id=<?= $g['id'] ?>">Editar</a>
                                <a class="excluir" href="#" onclick="confirmarExclusao('<?= addslashes($g['titulo']) ?>',
                                    <?= $g['id'] ?>)">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">Nenhum jogo encontrado.</td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
