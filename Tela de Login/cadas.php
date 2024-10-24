<?php
// Inclui a conexão com o banco de dados
include('conexao.php');

// Inicia a sessão
session_start(); // Certifique-se de iniciar a sessão no início

// Verifica se os dados foram enviados via POST
if (isset($_POST['logi']) && isset($_POST['senha'])) {

    // Verifica se o campo login está vazio
    if (strlen(trim($_POST['logi'])) == 0) {
        echo "Preencha seu Login";
    }
    // Verifica se o campo senha está vazio
    else if (strlen(trim($_POST['senha'])) == 0) {
        echo "Preencha sua Senha";
    } 
    // Caso ambos os campos estejam preenchidos
    else {
        // Protege contra SQL Injection usando prepared statements
        $logi = trim($_POST['logi']);
        $senha = trim($_POST['senha']); 

        // Consulta SQL para buscar o usuário no banco de dados
        $sql_code = "SELECT * FROM usuario WHERE logi = $1";
        $resultado = pg_query_params($conexao, $sql_code, array($logi));
        
        // Verifica se a consulta foi bem-sucedida
        if (!$resultado) {
            die("Erro na execução da consulta: " . pg_last_error($conexao));
        }

        $quantidade = pg_num_rows($resultado);

        if ($quantidade == 1) {
            $usuario = pg_fetch_assoc($resultado);

            // Debug: Verifica se os dados do usuário estão corretos
            echo "<pre>";
            print_r($usuario);
            echo "</pre>";

            // Verifica se a senha fornecida corresponde ao que está armazenado
            if (password_verify($senha, $usuario['senha'])) { // Use password_verify
                // Armazena as informações do usuário na sessão
                $_SESSION['nivel_usuario'] = $usuario['nivel_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                
                // Redireciona para o painel
                header("Location: painel.php");
                exit(); // Adicione exit() após o redirecionamento para evitar execução adicional
            } else {
                echo "Falha ao logar, usuário ou senha incorretos."; // Mensagem genérica
            }
        } else {
            echo "Falha ao logar, usuário ou senha incorretos."; // Mensagem genérica
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" type="text/css" href="estilocss">
</head>
<body>
    <h2>Login</h2>
    <form action="verificar.php" method="POST">
        <label for="logi">Login:</label>
        <input type="text" id="logi" name="logi" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>

