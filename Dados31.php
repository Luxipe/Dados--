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

$idAlunoParaExcluir = 1; // ID do aluno para excluir.

try {
    // Excluir associações do aluno com cursos
    $sqlExcluirAssociacoes = "DELETE FROM cursos WHERE id_aluno = $idAlunoParaExcluir";
    $conn->query($sqlExcluirAssociacoes);

    // Excluir o aluno
    $sqlExcluirAluno = "DELETE FROM alunos WHERE id = $idAlunoParaExcluir";
    $conn->query($sqlExcluirAluno);

    echo "Aluno e associações com cursos excluídos com sucesso.";
} catch (Exception $e) {
    echo "Erro ao excluir aluno e associações com cursos: " . $e->getMessage();
} finally {
    $conn->close();
}
?>
