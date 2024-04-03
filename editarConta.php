<?php 

require_once "conexao.php";

// Inicializa as variáveis $tipoConta e $banco
$tipoConta = '';
$banco = '';

// Verifica se a variável $_GET['id'] está definida
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para obter as informações da conta com o ID especificado
    $sql = "SELECT * FROM `conta` WHERE id = $id LIMIT 1";
    $result = $conn->query($sql);

    // Verifica se a consulta retornou resultados
    if ($result->num_rows > 0) {
        // Recupera os dados da conta
        $row = $result->fetch_assoc();
        $banco = $row['banco'];
        $tipoConta = $row['tipoConta'];

        // Se o formulário for enviado (submit), atualiza os dados
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Verifica se os índices estão definidos antes de acessá-los
            if(isset($_POST['submit'])) {
                $banco = $_POST['banco'];
                $tipoConta = $_POST['tipoConta'];

                // Atualiza a consulta para usar um marcador de posição (?) para o ID
                $sql = "UPDATE `conta` SET `banco`=?, `tipoConta`=? WHERE id=?";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $banco, $tipoConta, $id);

                if($stmt->execute()){
                    header('Location: exibirConta.php');
                } else {
                    echo "Erro: ". $sql. "<br>". $conn->error;
                }

                $stmt->close();
            }
        }
    } else {
        echo "Nenhuma conta encontrada com o ID especificado.";
    }

    $conn->close();
} else {
    echo "ID da conta não especificado.";
}
?>

<div class="form">
    <!-- Adiciona um campo oculto para passar o ID da conta -->
    <form method="post" action="editarConta.php?id=<?php echo $id; ?>" id="formEditarConta">
        <label for="nome-banco">Banco</label>
        <!-- Preenche o valor do campo com os dados recuperados do banco de dados -->
        <input id="nome-banco" type="text" name="banco" placeholder="nome do banco" value="<?php echo $banco; ?>" />

        <label for="tipo-conta">Tipo de conta</label>
        <!-- Preenche o valor do campo com os dados recuperados do banco de dados -->
        <input id="tipo-conta" type="text" name="tipoConta" placeholder="Tipo de Conta" value="<?php echo $tipoConta; ?>" />

        <button class="button-45" type="submit" name="submit" role="button">salvar</button>
    </form>
</div>
