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

            // Debug: Exibir informações do usuário
            // echo "<pre>";
            // print_r($usuario);
            // echo "</pre>";

            // Verifica se a senha fornecida corresponde ao que está armazenado
            // Se a senha estiver em texto simples
            if ($senha === $usuario['senha']) { 
                // Armazena as informações do usuário na sessão
                $_SESSION['nivel_usuario'] = $usuario['nivel_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                
                // Redireciona para o painel
                header("Location: painel.php");
                exit(); // Adicione exit() após o redirecionamento para evitar execução adicional
            } else {
                // Mensagem de erro genérica
                echo "Falha ao logar, usuário ou senha incorretos."; 
            }
        } else {
            echo "Falha ao logar, usuário ou senha incorretos."; // Mensagem genérica
        }
    }
}
?>
