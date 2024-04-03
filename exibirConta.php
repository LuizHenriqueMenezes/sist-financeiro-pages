<?php
require_once "conexao.php";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $banco = $_POST['banco'];
    $tipoConta = $_POST['tipoConta'];

    // Insere a nova conta no banco de dados
    $sql = "INSERT INTO `conta` (`banco`, `tipoConta`) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $banco, $tipoConta);

    if ($stmt->execute()) {
        // Redireciona de volta para a página principal
        header('Location: home.php');
        exit;
    } else {
        echo "Erro ao inserir nova conta: " . $stmt->error;
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
        echo "<a href='editarConta.php?id=$contaId'><button class='button-47' role='button'>editar</button></a>";
        echo "<a href='apagarConta.php?id=$contaId'><button class='button-46' role='button'>apagar</button></a>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "Nenhuma conta encontrada.";
}

$conn->close();
?>
