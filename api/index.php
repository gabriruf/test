<?php
session_start();

define(ROOT_PATH, dirname(__DIR__, 1));
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo ROOT_PATH ?>/styles/style.css">
        <link rel="stylesheet" href="<?php echo ROOT_PATH ?>/styles/form.css">
        <link rel="icon" type="image/x-icon" href="<?php echo ROOT_PATH ?>/images/logo-favicon.ico">
        <title>Login DOA FÁCIL</title>
    </head>
    <body>

    <header class="header">
        <div class="a">
            <img id="header-logo" alt='Logotipo do "Doá Facil"' src="<?php echo ROOT_PATH ?>/images/img00.png">
        
            <div class="textos-header">
                <h1><span style="color: rgb(0, 165, 0);">DOA</span><span style="color: rgb(0, 81, 255);">Fácil</span></h1>
                <h4>CONECTANDO QUEM DOA A QUEM PRECISA</h4>
            </div>
        </div>
    
    <h3 class="titulo-login">LOGIN</h3> 
    </header>

        <main class="container">
          <?php
            if (isset($_POST["login"])) {
                require_once("database.php");

                try {
                    require_once("tabelaUser.php");

                    $erroArray = [];
                    $email = htmlspecialchars($_POST["email"]);
                    $senha = htmlspecialchars($_POST["senha"]);
                    $tipo_user = htmlspecialchars($_POST["opcoes-acesso"]);

                    $stmt = $conn->prepare('SELECT nome_user, pass_user FROM doafacil.Users WHERE email_user = :email AND tipo_user = :tipo');
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':tipo', $tipo_user, PDO::PARAM_STR);
                    $stmt->execute();
                    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (empty($email) OR empty($senha) OR empty($tipo_user)) {
                        array_push($erroArray, "Todos os campos devem ser preenchidos!");
                        throw new Exception();
                    } else if ($dados === false) {
                        array_push($erroArray, "E-mail ou tipo de dado incorreto");
                        throw new Exception();
                    }

                    $senhaHashBanco = $dados["pass_user"];

                    $checkSenha = password_verify($senha, $senhaHashBanco);

                    if ($checkSenha == false) {
                        array_push($erroArray, "A senha está incorreta");
                        throw new Exception();
                    }

                    if (count($erroArray) > 0) {
                        throw new Exception();
                    } else {
                        // Preenche as variáveis de sessão
                        $_SESSION["email"] = $email;
                        $_SESSION["username"] = $dados["nome_user"];
                        $_SESSION["tipo_user"] = $tipo_user;
                        
                        // --- NOVA LÓGICA DE REDIRECIONAMENTO ---
                        if ($tipo_user === "Donatário") {
                            // Redireciona Donatário
                            header("Location: " . ROOT_PATH . "/sites/receber.php"); 
                        } elseif ($tipo_user === "Doador") {
                            // Redireciona Doador
                            header("Location: " . ROOT_PATH . "/sites/doacao.php"); 
                        } else {
                            // Prevenção caso caia em alguma outra opção no futuro
                            header("Location: " . ROOT_PATH . "/sites/perfil.php"); 
                        }
                        exit();
                    }
                } catch (Exception $e) {
                    foreach ($erroArray as $e) {
                        echo "<div><p style='color: #ff0202'>$e</p></div>";
                    }
                }

                // Close connection
                $conn = null;
            }
            ?>
            <form action="./index.php" method="POST" class="form-cadastro">
                <div class="input-group full-width">
                    <input type="email" id="email" name="email" placeholder=" " required>
                    <label for="email" class="float-label">EMAIL:</label>
                </div>

                <div class="input-group full-width">
                    <input type="password" id="senha" name="senha" placeholder=" " required>
                    <label for="senha" class="float-label">SENHA:</label>
                </div>

                <div class="input-group full-width" id="escolha">
                    <label for="opt-acesso" id="opcao">TIPO DE ACESSO:</label>
                    <select name="opcoes-acesso" id="opt-acesso" required>
                        <option value="">-- Selecione uma opção --</option>
                        <option value="Donatário">Donatário</option>
                        <option value="Doador">Doador</option>
                    </select>
                </div>

                <div class="button-container">
                    <button type="submit" value="login" name="login" class="btn">ENTRAR</button>
                </div>

                <p class="nao-conta">Ainda não possui uma conta?&nbsp;<a href="cadastro.php">Cadastre-se</a></p>
            </form>
        </main>

    </body>
</html>