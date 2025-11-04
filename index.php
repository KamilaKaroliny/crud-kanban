<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php 
            include("./includes/conexao.php");

            if (isset($_POST['submit'])) {
                $email = $mysqli->real_escape_string($_POST['email']);
                $senha = $mysqli->real_escape_string($_POST['senha']);

                $query = "SELECT * FROM usuarios WHERE Email='$email' AND senha='$senha'";
                $result = $mysqli->query($query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Username'];
                    $_SESSION['id'] = $row['Id'];
                    header("Location: ./public/read-usuarios.php");
                    exit;
                } else {
                    echo "<div class='message'>
                            <p>Nome de usuário ou senha incorretos</p>
                          </div> <br>";
                    echo "<a href='index.php'><button class='btn' style='background-color:rgb(179, 0, 98);'>Voltar</button></a>";
                }
            } else {
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" style="background-color:rgb(179, 0, 98);" name="submit" value="Login">
                </div>
                <div class="links">
                    Não tem uma conta? <a href="./public/cadastro.php">Cadastre-se aqui</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>