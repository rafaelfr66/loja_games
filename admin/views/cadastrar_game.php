<?php
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
    <title>Cadastrar Jogo</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .mensagem {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <h2>Cadastrar Novo Jogo</h2>

    <?php if ($mensagem === 'sucesso'): ?>
        <div class="mensagem" id="mensagem">Jogo cadastrado com sucesso!</div>
        <script>
            document.getElementById('mensagem').style.display = 'block';
            setTimeout(() => {
                document.getElementById('mensagem').style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea name="descricao" rows="4" required></textarea><br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" step="0.01" name="preco" required><br><br>

        <label for="estoque">Estoque:</label><br>
        <input type="number" name="estoque" required><br><br>

        <label for="categoria">Categoria:</label><br>
        <input type="text" name="categoria" required><br><br>

        <label for="imagem">Imagem:</label><br>
        <input type="file" name="imagem" accept="image/*" required><br><br>

        <button type="submit">Cadastrar</button>
        <a href="ver_games.php">Voltar</a>
    </form>
</body>
</html>
