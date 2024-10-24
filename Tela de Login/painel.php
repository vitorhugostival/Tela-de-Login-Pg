<?php
// Inicia a sessão se ainda não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br"> <!-- Alterei o idioma para português (pt-br) devido ao conteúdo em português -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
</head>
<body>
    <h1>Bem-vindo ao Painel</h1>
    <h2>
        <!-- Verifica se o nome está na sessão, senão exibe 'Visitante' -->
        <?php echo isset($_SESSION['nome_usuario']) ? $_SESSION['nome_usuario'] : 'Visitante'; ?>
    </h2>

    <p>
        <!-- Corrige o link do logout -->
        <a href="logout.php">Sair</a>
    </p>

</body>
</html>


