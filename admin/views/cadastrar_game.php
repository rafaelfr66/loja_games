<?php
require_once '../config/auth.php';
require_once '../models/games.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagemNome = $_FILES['imagem']['name'];
    $imagemTmp = $_FILES['imagem']['tmp_name'];
    $caminhoDestino = '../public/imagens/' . $imagemNome;

    if (move_uploaded_file($imagemTmp, $caminhoDestino)) {
        $novo = new Game([
            'titulo' => $_POST['titulo'],
            'descricao' => $_POST['descricao'],
            'preco' => $_POST['preco'],
            'estoque' => $_POST['estoque'],
            'categoria' => $_POST['categoria'],
            'imagem' => $imagemNome
        ]);

        if ($novo->cadastrarGame()) {
            $mensagem = 'sucesso';
        } else {
            echo "Erro ao cadastrar no banco de dados.";
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Jogo - Loja Games</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .mensagem {
            display: none;
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
            <h2>Cadastrar Novo Jogo</h2>

            <?php if ($mensagem === 'sucesso'): ?>
                <div class="mensagem alerta-sucesso" id="mensagem">Jogo cadastrado com sucesso!</div>
                <script>
                    document.getElementById('mensagem').style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('mensagem').style.display = 'none';
                    }, 3000);
                </script>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>

                <div class="linha">
                    <div>
                        <label for="preco">Preço (R$)</label>
                        <input type="number" step="0.01" id="preco" name="preco" required>
                    </div>
                    <div>
                        <label for="estoque">Estoque</label>
                        <input type="number" id="estoque" name="estoque" required>
                    </div>
                </div>

                <label for="categoria">Categoria</label>
                <input type="text" id="categoria" name="categoria" required>

                <label for="imagem">Imagem</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required>

                <div class="botoes">
                    <button type="submit">Cadastrar</button>
                    <a href="ver_games.php">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
