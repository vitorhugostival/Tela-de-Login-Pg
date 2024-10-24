<?php
// Inicia a sessão se ainda não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o nível de acesso do usuário está na sessão
if (!isset($_SESSION['nivel'])) {
    // Se o nível de acesso não estiver definido, bloqueia o acesso e exibe uma mensagem
    die("Você não pode acessar essa página porque não está logado. <p><a href=\"cadas.php\">Entrar</a></p>");
}
?>
