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

$idLivroParaExcluir = 1; // o id livro para excluir

try {
    // vai Iniciar uma transação
    $conn->begin_transaction();

    // vai  Excluir associações do livro com autores
    $sqlExcluirAssociacoes = "DELETE FROM autores WHERE id_livro = $idLivroParaExcluir";
    $conn->query($sqlExcluirAssociacoes);

    // vai  Excluir o livro
    $sqlExcluirLivro = "DELETE FROM livros WHERE id = $idLivroParaExcluir";
    $conn->query($sqlExcluirLivro);

    // vai confirmar, se todas as transações der certo.
    $conn->commit();

    echo "Livro e associações com autores excluídos com sucesso.";
} catch (Exception $e) {

    // vai desfazer em caso de erro
    $conn->rollback();
    echo "Erro ao excluir livro e associações com autores: " . $e->getMessage();
} finally {
    $conn->close();
}
?>
