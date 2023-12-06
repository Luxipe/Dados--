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

$idFornecedorParaExcluir = 1; // o id do fornecedor para excluir

try {
    // vai  Iniciar uma transação
    $conn->begin_transaction();

    // vai Excluir registros de compras associados ao fornecedor
    $sqlExcluirCompras = "DELETE FROM compras WHERE id_fornecedor = $idFornecedorParaExcluir";
    $conn->query($sqlExcluirCompras);

    // vai Excluir o fornecedor
    $sqlExcluirFornecedor = "DELETE FROM fornecedores WHERE id = $idFornecedorParaExcluir";
    $conn->query($sqlExcluirFornecedor);

    // vai confirmar, se todas as transações der certo.
    $conn->commit();

    echo "Fornecedor e compras associadas excluídos com sucesso.";
} catch (Exception $e) {

    // vai desfazer em caso de erro
    $conn->rollback();
    echo "Erro ao excluir fornecedor e compras associadas: " . $e->getMessage();
} finally {
    $conn->close();
}
?>
