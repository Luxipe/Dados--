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


$id_cliente_a_excluir = 789; // o id do cliente a excluir

// vai  Iniciar uma transação
$conn->begin_transaction();

try {
    // vai excluir o cliente da tabela vendas
    $sql_remover_vendas = "DELETE FROM vendas WHERE id_cliente = $id_cliente_a_excluir";
    $conn->query($sql_remover_vendas);

    // vai Excluir o cliente da tabela clientes
    $sql_excluir_cliente = "DELETE FROM clientes WHERE id = $id_cliente_a_excluir";
    $conn->query($sql_excluir_cliente);

    // vai confirmar, se todas as transações der certo.
    $conn->commit();

    echo "Cliente e vendas excluídos com sucesso!";
} catch (Exception $e) {
    
    // vai desfazer em caso de erro
    $conn->rollback();
    echo "Erro ao excluir cliente e vendas: " . $e->getMessage();
}

$conn->close();
?>
