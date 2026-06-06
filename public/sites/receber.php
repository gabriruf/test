<?php
session_start();

if ($_SESSION["tipo_user"] !== "Donatário") {
    header("Location: ./doacao.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pedidos Disponíveis</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../styles/receber.css">
        <link rel="icon" type="image/x-icon" href="../images/logo-favicon.ico">
        <link rel="stylesheet" href="../styles/cards.css">
    </head>
    <body>

        <header class="topbar">
            <div class="topbar-container">
                <h1 class="logo">Minhas solicitações</h1>
                <div class="search-filter-container">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Buscar pedidos...">
                    </div>
                    <button class="filter-btn">
                        <i class="fa-solid fa-sliders"></i>
                    </button>
                </div>
                <div class="notification-icon">
                    <i class="fa-regular fa-bell"></i>
                </div>
                <h2 id="welcome-text">Bem-vindo, <?php echo $_SESSION["username"];?></h2>
            </div>
            
        </header>

        <main class="main-container">
            <main class="card-container">
            <div class="illustration-container">
                <div class="circle-bg">
                    <div class="box-icon">
                        <span class="heart small-heart-1">♥</span>
                        <span class="heart small-heart-2">♥</span>
                        <div class="box-lid-left"></div>
                        <div class="box-lid-right"></div>
                        <div class="box-body">
                            <span class="main-heart">♥</span>
                        </div>
                    </div>
                </div>
            </div>

            <p class="status-message">
                Você ainda não tem<br>pedidos cadastrados.
            </p>

            <a href="./Criar_pedido.html">
            <div class="actions-container">
                <button class="btn btn-primary">
                    <span class="material-icons-outlined"></span>
                    CRIAR PEDIDO
                </button>
            </div></a>
        </main>

        <nav class="sidebar">
            <ul>
                <li class="active"><a href="#"><span>Início</span></a></li>
                <li><a href="#"><span>Favoritos</span></a></li>
                <li><a href="./doacao.php"><span>Minhas doações</span></a></li>
                <li><a href="./perfil.php"><span>Perfil</span></a></li>
                <li><a href="./ondedoar.html" target="_blank">Saiba onde doar</a></li>
                <li><a href="./conheFinanceiro.html" target="_blank">Conhecimento Financeiro</a></li>
                <li><a href="./sobreNos.html" target="_blank">Sobre nós</a></li>
            </ul>
        </nav>


       <script src="../scripts/cards.js"></script>
    </body>
</html>