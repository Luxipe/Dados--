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

$id_usuario_a_excluir = 123; // o id do usuario a excluir

// vai Iniciar uma transação
$conn->begin_transaction();

try {
    $sql_excluir_pedidos = "DELETE FROM pedidos WHERE id_usuario = $id_usuario_a_excluir";
    $conn->query($sql_excluir_pedidos);

    // Exclui o usuário da tabela 'usuarios'
    $sql_excluir_usuario = "DELETE FROM usuarios WHERE id = $id_usuario_a_excluir";
    $conn->query($sql_excluir_usuario);

    // Confirma a transação se todas as consultas foram bem-sucedidas
    $conn->commit();

    echo "Usuário e pedidos excluídos com sucesso!";
} catch (Exception $e) {
    
    // Desfaz a transação em caso de erro
    $conn->rollback();
    echo "Erro ao excluir usuário e pedidos: " . $e->getMessage();
}


$conn->close();
?>
