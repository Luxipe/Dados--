<?php
// Nome: Gustavo De Oliveira Vital.PHP
$servername = "localhost";
$username = "root";
$password = "";
$database = "processocadastro";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para inserir dados nas tabelas
function inserirDados() {
    global $conn;

    // Inserção na tabela resultados_exames
    $sqlInserirResultados = "INSERT INTO resultados_exames (id_resultado, tipo_exame, resultado) VALUES
        (1, 'Exame de Sangue', 'Normal'),
        (2, 'Raio-X', 'Fratura identificada')";

    $conn->query($sqlInserirResultados);

    // Inserção na tabela pacientes
    $sqlInserirPacientes = "INSERT INTO pacientes (id_paciente, nome_paciente, data_nascimento) VALUES
        (1, 'Mariana', '1995-06-10'),
        (2, 'Rafael', '1987-09-25')";

    $conn->query($sqlInserirPacientes);

    echo "Dados inseridos com sucesso.";
}

// uma Função para remover resultado de exame e paciente
function removerResultadoEPaciente($idResultadoExame) {
    global $conn;

    // vai Inicia uma transação
    $conn->begin_transaction();

    try {
        // Remove o resultado de exame
        $sqlRemoverResultado = "DELETE FROM resultados_exames WHERE id_resultado = $idResultadoExame";
        $conn->query($sqlRemoverResultado);

        // Remove o paciente associado ao resultado
        $sqlRemoverPaciente = "DELETE FROM pacientes WHERE id_paciente = (
            SELECT id_paciente FROM resultados_exames WHERE id_resultado = $idResultadoExame
        )";
        $conn->query($sqlRemoverPaciente);

        // vai confirmar, se todas as transações der certo.
        $conn->commit();

        echo "Resultado de exame e paciente removidos com sucesso.";
    } catch (Exception $e) {
        // Desfaz em caso de erro
        $conn->rollback();
        echo "Erro ao remover resultado de exame e paciente: " . $e->getMessage();
    }
}


inserirDados(); // Insere os dados nas tabelas

// Remove os dados com base nos requisitos
$idResultadoExameParaRemover = 1;
removerResultadoEPaciente($idResultadoExameParaRemover);

$conn->close();
?>
