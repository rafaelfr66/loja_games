SET NAMES utf8mb4;
USE loja_games;

INSERT INTO games (id, titulo, descricao, preco, estoque, categoria, imagem, created_at, updated_at) VALUES
(2, 'God of War', 'Jogo de ação com Kratos em uma jornada épica.', 249.99, 15, 'Ação', 'god_of_war.jpg', '2026-09-10 22:54:46', '2026-09-10 22:54:46'),
(4, 'The Legend of Zelda: Beath of the Wild', 'Um jogo de aventura', 350.00, 44, 'Aventura', 'images.jpg', '2026-10-22 18:25:28', '2026-10-22 18:25:28');

INSERT INTO usuarios (id, nome, email, senha, tipo, created_at, updated_at) VALUES
(1, 'evandro', 'evandro@gmail.com', '$2y$12$siX1u80hTsFbL.Rvj431K.9qY7jJ.4hEe8qyiOMyX0bezf0pXoM7G', 'admin', '2026-09-10 22:54:46', '2026-10-22 19:09:15'),
(2, 'pedro', 'pedro@gmail.com', '$2y$12$PI7PN6wyPnDfjeGOXP3CEuVQxD2m19nhj34PsL1CEShiMcMI6OxaK', 'user', '2026-09-10 22:54:46', '2026-10-22 19:09:15');
