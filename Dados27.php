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

$id_produto_a_excluir = 456; // o id produto a excluir.

// vai Iniciar uma transação
$conn->begin_transaction();

try {
   
    $sql_remover_associacoes = "DELETE FROM categorias WHERE id_produto = $id_produto_a_excluir";
    $conn->query($sql_remover_associacoes);

    // vai Excluir o produto da tabela produtos
    $sql_excluir_produto = "DELETE FROM produtos WHERE id = $id_produto_a_excluir";
    $conn->query($sql_excluir_produto);

    // vai confirmar, se todas as transações der certo.
    $conn->commit();

    echo "Produto e associações excluídos com sucesso!";
} catch (Exception $e) {
    
    // vai desfazer em caso de erro
    $conn->rollback();
    echo "Erro ao excluir produto e associações: " . $e->getMessage();
}

$conn->close();
?>
