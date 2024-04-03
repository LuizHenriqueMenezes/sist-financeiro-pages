<?php
require_once "conexao.php";

// Verifica se o formulário de exclusão foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    // Obtém o ID da conta a ser excluída
    $id = $_POST['delete_id'];

    // Deleta a conta do banco de dados com base no ID
    $sql = "DELETE FROM `conta` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de exibição de contas
        header('Location: exibirConta.php');
        exit;
    } else {
        echo "Erro ao excluir conta: " . $stmt->error;
    }

    $stmt->close();
}

// Busca todas as contas no banco de dados
$sql = "SELECT * FROM `conta`";
$result = $conn->query($sql);

// Verifica se a consulta retornou resultados
if ($result->num_rows > 0) {
    // Itera sobre as linhas resultantes
    while ($row = $result->fetch_assoc()) {
        $contaId = $row['id'];
        $contaBanco = $row['banco'];
        $contaTipo = $row['tipoConta'];

        // Exibe as informações da conta
        echo "<div class='contaBox'>";
        echo "<h1>Conta ID: $contaId</h1>";
        echo "<h3>Banco: $contaBanco</h3>";
        echo "<h3>Tipo de Conta: $contaTipo</h3>";
        echo "<div class='button-group'>";
        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='delete_id' value='$contaId'>";
        echo "<button class='button-46' type='submit' onclick='return confirm(\"Tem certeza que deseja excluir esta conta?\")'>Apagar</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "Nenhuma conta encontrada.";
}

$conn->close();
?>
