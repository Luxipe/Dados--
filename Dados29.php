<?php
// Nome: Gustavo De Oliveira Vital.PHP
$host = "localhost";
$usuario_bd = "root";
$senha_bd = "";
$nome_bd = "processocadastro";


$conn = new mysqli($host, $usuario_bd, $senha_bd, $nome_bd);


if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$id_funcionario_a_excluir = 101; // o id do funcionario a excluir.

// vai Iniciar uma transação
$conn->begin_transaction();

try {
    
    $sql_remover_associacoes = "DELETE FROM departamentos WHERE id_funcionario = $id_funcionario_a_excluir";
    $conn->query($sql_remover_associacoes);

    // vai  Excluir o funcionário da tabela funcionarios
    $sql_excluir_funcionario = "DELETE FROM funcionarios WHERE id = $id_funcionario_a_excluir";
    $conn->query($sql_excluir_funcionario);

    // vai confirmar, se todas as transações der certo.
    $conn->commit();

    echo "Funcionário e associações com departamentos excluídos com sucesso!";
} catch (Exception $e) {

    // vai desfazer em caso de erro
    $conn->rollback();
    echo "Erro ao excluir funcionário e associações com departamentos: " . $e->getMessage();
}

$conn->close();
?>
