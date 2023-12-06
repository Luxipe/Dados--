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


$eventos_a_excluir = "1,2"; // IDs dos eventos a excluir

// Divide a string de IDs em um array
$eventos_array = explode(",", $eventos_a_excluir);


$participantes_a_excluir = "1,2"; // o id do participantes a excluir

// Divide a string de IDs em um array
$participantes_array = explode(",", $participantes_a_excluir);

// Inicia uma transação para garantir que ambas as exclusões vão dar certo ou não.
$conn->begin_transaction();

try {
    // Itera sobre a lista de eventos a serem excluídos
    foreach ($eventos_array as $id_evento) {
        // Exclui os participantes associados a este evento
        foreach ($participantes_array as $id_participante) {
            $sql_delete_participante = "DELETE FROM participantes WHERE id_participante = $id_participante AND id_evento = $id_evento";
            $conn->query($sql_delete_participante);
        }

        // Exclui o evento
        $sql_delete_evento = "DELETE FROM eventos WHERE id_evento = $id_evento";
        $conn->query($sql_delete_evento);
    }

    // Confirma se todas as transações deram certo.
    $conn->commit();

    echo "Eventos e participantes excluídos com sucesso.";
} catch (Exception $e) {
    // Desfaz em caso de erro
    $conn->rollback();
    
    echo "Erro ao excluir eventos e participantes: " . $e->getMessage();
}

$conn->close();
?>
