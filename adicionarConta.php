<?php 

require_once "conexao.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Verifica se os índices estão definidos antes de acessá-los
    if(isset($_POST['submit'])) {
        $banco = $_POST['banco'];
        $tipoConta = $_POST['tipoConta'];
       
        $sql = "INSERT INTO `conta`(`id`, `banco`, `tipoConta`) VALUES (NULL,'$banco','$tipoConta');";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $banco, $tipoConta);

        if($stmt->execute()){
            header('Location: home.php');
        }else{
            echo "Erro: ". $sql. "<br>". $conn->error;
        }
    
        $stmt->close();

}
}
    $conn->close();
 ?>


