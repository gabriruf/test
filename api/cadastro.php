<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/styles/style.css">
        <link rel="stylesheet" href="../public/styles/form.css">
        <link rel="icon" type="image/x-icon" href="../public/images/logo-favicon.ico">
        <title>Cadastro - DOA FÁCIL</title>
    </head>
    <body>
        <header class="header">
        <div class="a">
            <img id="header-logo" alt='Logotipo do "Doá Facil"' src="../public/images/img00.png">
        
            <div class="textos-header">
                <h1><span style="color: rgb(0, 165, 0);">DOA</span><span style="color: rgb(0, 81, 255);">Fácil</span></h1>
                <h4>CONECTANDO QUEM DOA A QUEM PRECISA</h4>
            </div>
        </div>
            <h3 class="titulo-login">CADASTRE - SE</h3>
        </header>
        
        <main class="container">
            <?php
                if (isset($_POST["login"])) {
                    require_once("database.php"); 
                    try {
                        require_once("tabelaUser.php");

                        $nomeUser = htmlspecialchars($_POST["nome"]);
                        $email = htmlspecialchars($_POST["email"]);
                        $endereco = htmlspecialchars($_POST["endereco"]);
                        $num_endereco = htmlspecialchars($_POST["num_endereco"]);
                        $celular = htmlspecialchars($_POST["celular"]);
                        $cep = htmlspecialchars($_POST["cep"]);
                        $tipo_acesso = htmlspecialchars(($_POST["access-type"]));
                        $senha = password_hash($_POST["senha"], PASSWORD_BCRYPT);

                        $erroArray = [];

                        if (empty($nomeUser) OR empty($email) OR empty($endereco) OR empty($num_endereco) OR empty($celular) OR empty($cep) OR empty($tipo_acesso) OR empty($_POST["senha"]) OR empty($_POST["repetir-senha"])) {
                            array_push($erroArray, "Todos os campos devem ser preenchidos!");
                        }

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            array_push($erroArray, "Formato de e-mail incorreto");
                        }

                        $checkEmail = $conn->prepare("SELECT email_user FROM doafacil.Users
                                                    WHERE email_user = ?;");
                        $checkEmail->execute([$email]);
                        if ($checkEmail->rowCount() > 0) {
                            array_push($erroArray, "E-mail já existe na base de dados!");
                        }

                        if (!preg_match("/^[0-9]*$/", $num_endereco)) {
                            array_push($erroArray, "Número de endereço inválido.");
                        }

                        if (strlen($_POST["senha"]) < 8) {
                            array_push($erroArray, "Senha deve ter pelo menos 8 digitos!");
                        }

                        if ($_POST["senha"] !== $_POST["repetir-senha"]) {
                            array_push($erroArray, "As senhas digitadas não são as mesmas!");
                        }

                        if (count($erroArray) > 0) {
                            foreach ($erroArray as $error) {
                                echo "<div><p>ERRO: $error</p></div>";
                            }
                        } else {
                            $sql = "INSERT INTO doafacil.Users (nome_user, email_user, endereco_user, num_endereco_user, cel_user, cep_user, tipo_user, pass_user)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([$nomeUser, $email, $endereco, intval($num_endereco), $celular, $cep, $tipo_acesso, $senha]);
                            header("Location: index.php");
                            exit();
                        }
                    } catch(PDOException $e) {
                        $erroSQL = $stmt->errorCode();
                        echo "Error during insert: $erroSQL \n" . $e->getMessage();
                    }

                    // Close connection
                    $conn = null;
                }
            ?>

            <form action="./cadastro.php" method="POST" class="form-cadastro">
            
                <div class="input-group full-width">
                    <input type="text" id="nome" name="nome" placeholder=" " required>
                    <label for="nome" class="float-label">NOME:</label>
                </div>

                <div class="input-group full-width">
                    <input type="email" id="email" name="email" placeholder=" " required>
                    <label for="email" class="float-label">EMAIL:</label>
                </div>

                <div class="input-group">
                    <input type="tel" id="celular" name="celular" placeholder="(00) 00000-0000" maxlength="15" required>
                    <label for="celular" class="float-label">CELULAR:</label>
                </div>

                <div class="input-group">
                    <input type="text" id="cep" name="cep" placeholder=" " maxlength="9" required>
                    <label for="cep" class="float-label">CEP:</label>
                </div>

                <div class="input-group">
                    <input type="text" id="endereco" name="endereco" placeholder=" " required>
                    <label for="endereco" class="float-label">ENDEREÇO:</label>
                </div>

                <div class="input-group">
                    <input type="number" id="num_endereco" name="num_endereco" min="1" max="255" placeholder=" " required>
                    <label for="num_endereco" class="float-label">NÚMERO:</label>
                </div>

                <div class="input-group radio-group full-width">
                    <span class="radio-title">TIPO DE ACESSO:</span>

                    <input type="radio" id="donatario" name="access-type" value="Donatário" required>
                    <label for="donatario">Donatário</label>

                    <input type="radio" id="doador" name="access-type" value="Doador" required>
                    <label for="doador">Doador</label>
                </div>

                <div class="input-group">
                    <input type="password" id="senha" name="senha" placeholder=" " required>
                    <label for="senha" class="float-label">SENHA:</label>
                </div>

                <div class="input-group">
                    <input type="password" id="repetir-senha" name="repetir-senha" placeholder=" " required>
                    <label for="repetir-senha" class="float-label">CONFIRME A SENHA:</label>
                </div>

                <div class="button-container">
                    <button type="submit" value="login" name="login" class="btn-criar">CRIAR</button>
                </div>
            </form>
        </main>

        <script src="../public/scripts/mascaras.js"></script>
        

    </body>
</html>