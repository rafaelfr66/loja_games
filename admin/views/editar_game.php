<?php
require_once '../config/auth.php';
require_once '../models/games.php';

$game = new Game();
$dados = null;

if (isset($_GET['id'])) {
    $dados = $game->buscarGamePorId($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editar = new Game([
        'id' => $_POST['id'],
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'preco' => $_POST['preco'],
        'estoque' => $_POST['estoque'],
        'categoria' => $_POST['categoria'],
        'imagem' => $_POST['imagem'] // temporariamente mantém a imagem atual
    ]);
    if ($editar->editarGame()) {
        echo "<script>alert('Jogo editado com sucesso!');
        window.location.href = 'ver_games.php';</script>";
        exit;
    } else {
        echo "Erro ao editar!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jogo - Loja Games</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .imagem-atual {
            margin: 0 0 18px;
            color: var(--texto-suave);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="topo">
        <a class="logo" href="../../index.php">Loja <span>Games</span></a>
        <div class="acoes">
            <a class="btn btn-contorno" href="ver_games.php">Gerenciar Games</a>
        </div>
    </div>

    <div class="conteudo">
        <div class="formulario">
            <h2>Editar Jogo</h2>

            <?php if ($dados): ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $dados['id'] ?>">

                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" value="<?= $dados['titulo'] ?>" required>

                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" required><?= $dados['descricao'] ?></textarea>

                    <div class="linha">
                        <div>
                            <label for="preco">Preço (R$)</label>
                            <input type="number" step="0.01" id="preco" name="preco" value="<?= $dados['preco'] ?>" required>
                        </div>
                        <div>
                            <label for="estoque">Estoque</label>
                            <input type="number" id="estoque" name="estoque" value="<?= $dados['estoque'] ?>" required>
                        </div>
                    </div>

                    <label for="categoria">Categoria</label>
                    <input type="text" id="categoria" name="categoria" value="<?= $dados['categoria'] ?>" required>

                    <label>Imagem atual</label>
                    <p class="imagem-atual"><?= $dados['imagem'] ?></p>
                    <input type="hidden" name="imagem" value="<?= $dados['imagem'] ?>">

                    <div class="botoes">
                        <button type="submit">Salvar</button>
                        <a href="ver_games.php">Cancelar</a>
                    </div>
                </form>
            <?php else: ?>
                <p>Jogo não encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>