<?php
// Nome: Gustavo De Oliveira Vital.PHP
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "processocadastro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Lista de IDs dos projetos a serem excluídos
$ids_projetos = [1, 2]; // Adicionei os ids do projetos

// Inicia uma transação para garantir que ambas as exclusões vão dar certo ou não
$conn->begin_transaction();

try {
    foreach ($ids_projetos as $id_projeto) {
        // Verifica se o ID do projeto é numérico
        if (!is_numeric($id_projeto)) {
            die("ID do projeto inválido");
        }

        // Exclui as atribuições associadas a este projeto
        $sql_delete_atribuicoes = "DELETE FROM atribuicoes WHERE id_projeto = $id_projeto";
        $conn->query($sql_delete_atribuicoes);

        // Exclui o projeto
        $sql_delete_projeto = "DELETE FROM projetos WHERE id_projeto = $id_projeto";
        $conn->query($sql_delete_projeto);
    }

    // Vai confirmar se todas as transações derem certo
    $conn->commit();

    echo "Projetos e atribuições excluídos com sucesso.";
} catch (Exception $e) {
    // Vai desfazer em caso de erro
    $conn->rollback();

    echo "Erro ao excluir projetos e atribuições: " . $e->getMessage();
}

$conn->close();
?>
