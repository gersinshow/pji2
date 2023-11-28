<?php
session_start();
include('config.php');

// Consulta ao banco de dados para obter as informações das partidas cadastradas
$sql = "SELECT p.id_partida, p.id_equipe1, p.id_equipe2, p.id_campeonato, p.data_partida, p.resultado_equipe1, p.resultado_equipe2, e1.nome as nome_equipe1, e2.nome as nome_equipe2, c.titulo as nome_campeonato
        FROM cadastro_partida_rapida p
        INNER JOIN equipe e1 ON p.id_equipe1 = e1.id_equipe
        INNER JOIN equipe e2 ON p.id_equipe2 = e2.id_equipe
        INNER JOIN campeonato c ON p.id_campeonato = c.id_campeonato";
$result = $conexao->query($sql);

// Fecha a conexão com o banco de dados
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JIF 2024</title>
    <link rel="shortcut icon" href="img/Logo.ico">
    <link href="./assets/logo.svg" rel="icon" />
    <link href="./css3/style.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
</head>

<style>
    h1, p {
        color: white;
    }
</style>

<body class="green">
    <a href="login.php"> <button>Administração</button> </a>
    <div id="app">
        <header>
            <h1>JIF 2024</h1>
        </header>
        <main id="cards">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Formatando a data para exibir no formato dia/mês/ano
                    $data_formatada = date('d/m/Y', strtotime($row["data_partida"]));

                    echo '<div class="card">
                    <h2>Partida ' . $row["id_partida"] . ' </h2> 
                    <p>' . $row["nome_campeonato"] . '</p>
                    <p>' . $data_formatada . '</p>
                    
                    <ul>
                        <li>
                            <div class="sele1">
                                <div class="nome"> ' . $row["nome_equipe1"] . ' </div>
                            </div>
                                <div class="placar">
                                    <strong> ' . $row["resultado_equipe1"] . ' X ' . $row["resultado_equipe2"] . ' </strong>
                                </div>
                            <div class="sele2">
                                <div class="nome2">' . $row["nome_equipe2"] . '</div>
                             </div>
                        </li>
                    </ul>
                </div>';
                }
            } else {
                echo "Nenhuma partida cadastrada.";
            }
            ?>
        </main>
    </div>
</body>

</html>
