<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Cadastre-se</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php 
        include("../includes/conexao.php");
        session_start();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $mysqli->real_escape_string($_POST['nome']);
            $email = $mysqli->real_escape_string($_POST['email']);
            $senha = $mysqli->real_escape_string($_POST['senha']);
            $cep = $mysqli->real_escape_string($_POST['cep']);
            $endereco = $mysqli->real_escape_string($_POST['endereco']);
            $bairro = $mysqli->real_escape_string($_POST['bairro']);
            $cidade = $mysqli->real_escape_string($_POST['cidade']);
            $estado = $mysqli->real_escape_string($_POST['estado']);

            // Verificar se o e-mail já existe
            $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "<div class='message'>
                        <p>Este e-mail já está em uso, tente outro por favor!</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn' style='background-color:rgb(179, 0, 98);'>Voltar</button></a>";
            } else {
                // Inserir novo usuário
                $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, email, senha, cep, endereco, bairro, cidade, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $nome, $email, $senha, $cep, $endereco, $bairro, $cidade, $estado);

                if ($stmt->execute()) {
                    echo "<div class='message'>
                            <p>Cadastro realizado com sucesso!</p>
                          </div> <br>";
                    echo "<a href='../index.php'><button class='btn' style='background-color:rgb(179, 0, 98);'>Acessar agora</button></a>";
                } else {
                    echo "<div class='message'>
                            <p>Erro ao cadastrar: " . $stmt->error . "</p>
                          </div>";
                }
            }

            $stmt->close();
        } else {
        ?>

            <header>Cadastrar-se</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" id="nome" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" placeholder="00000-000" maxlength="9" required>
                </div>

                <div class="field input">
                    <label for="endereco">Endereço</label>
                    <input type="text" name="endereco" id="endereco" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" id="bairro" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="estado">Estado (UF)</label>
                    <input type="text" name="estado" id="estado" maxlength="2" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" style="background-color:rgb(179, 0, 98);" name="submit" value="Cadastrar-se">
                </div>

                <div class="links">
                    Já tem uma conta? <a href="../index.php" >Entre aqui</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>

    <!-- Script ViaCEP -->
    <script>
    document.getElementById('cep').addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('endereco').value = data.logradouro || '';
                        document.getElementById('bairro').value = data.bairro || '';
                        document.getElementById('cidade').value = data.localidade || '';
                        document.getElementById('estado').value = data.uf || '';
                    } else {
                        alert('CEP não encontrado!');
                    }
                })
                .catch(() => alert('Erro ao consultar o CEP!'));
        }
    });
    </script>
</body>
</html>