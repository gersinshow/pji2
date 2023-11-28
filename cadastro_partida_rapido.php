<?php
session_start();
include('config.php');

// Verifica se o usuário está autenticado como administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenha os dados do formulário
   
    $id_equipe1 = $_POST['nome_equipe1'];
    $id_equipe2 = $_POST['nome_equipe2'];
    $id_campeonato = $_POST['nome_campeonato'];
    $data_partida = $_POST['data_partida'];
    $resultado_equipe1 = $_POST['resultado_equipe1'];
    $resultado_equipe2 = $_POST['resultado_equipe2'];
    



    // Obtenha o próximo valor único para 'id_partida'
    $sql = "SELECT MAX(id_partida) AS max_id FROM cadastro_partida_rapida";
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $next_id = $row['max_id'] + 1;

    // Inserir os dados na tabela 'partida' com o novo 'id_partida'
    $sql_insert = "INSERT INTO cadastro_partida_rapida (id_partida, id_equipe1, id_equipe2, id_campeonato, data_partida, resultado_equipe1, resultado_equipe2) VALUES ('$next_id', '$id_equipe1', '$id_equipe2','$id_campeonato', '$data_partida', '$resultado_equipe1', '$resultado_equipe2' )";


    // Feche a conexão com o banco de dados
    
}
$conexao->close();

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_2/style_atleta.css">
    <link rel="shortcut icon" href="img/Logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Cadastro de Partida</title>
</head>
<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .back-button {
        padding: 5px 10px;
        text-decoration: none;
        background-color: green; 
        border: none;
        border-radius: 20px;
        color: white;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.4s ease;
    }

    .back-button:hover {
        background-color: darkgreen; 
    }
</style>
<body>
    <div class="boxzinha">
        <div class="formulario-boxzinha">
            <div class="header">
                <h2>Cadastro de Partida</h2>
                <a class="back-button" href="cadastros-gerais.php">Voltar</a>
            </div>

            <form action="cadastro_partida_rapido.php" method="POST">

                <div class="inputszinha">
                        <label for="nome_campeonato">Nome do Campeonato</label>
                        <select name="nome_campeonato" id="nome_campeonato">
                        <?php

                            $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPorta);
                            // Recupera as opções do banco de dados
                            $sql = "SELECT id_campeonato, titulo FROM campeonato";
                            $resultado = $conexao->query($sql);
                                if ($resultado->num_rows > 0) {
                                while ($row = $resultado->fetch_assoc()) {
                                    echo '<option value="'.$row["id_campeonato"].'">'.$row["titulo"].' </option>';
                                }
                            } else {
                                echo '<option value="">Nenhuma campeonato cadastrado</option>';
                            }
                        ?>
                        </select>
                    </div>
                    
                <div class="inputszinha">
                    <label for="data_partida">Data da partida</label>
                    <input type="date" id="data_partida" name="data_partida" placeholder="Digite a data da partida" >
                </div>

                <div class="inputszinha">
                    <label for="nome_equipe1">Equipe 1</label>
                    <select name="nome_equipe1" id="nome_equipe1">
                    <?php

                        $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPorta);
                        // Recupera as opções do banco de dados
                        $sql = "SELECT id_equipe, nome FROM equipe";
                        $resultado = $conexao->query($sql);
                            if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo '<option value="'.$row["id_equipe"].'">'.$row["nome"].' </option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma equipe cadastrada</option>';
                        }
                    ?>
                    </select>
                </div>

                
                <div class="inputszinha">
                    <label for="resultado_equipe1">Resultado equipe 1</label>
                    <input type="number" id="resultado_equipe1" name="resultado_equipe1" placeholder="Digite o resultado da equipe 1" >
                </div>


                <div class="inputszinha">
                    <label for="nome_equipe2">Equipe 2</label>
                    <select name="nome_equipe2" id="nome_equipe2">
                    <?php

                        $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPorta);
                        // Recupera as opções do banco de dados
                        $sql = "SELECT id_equipe, nome FROM equipe";
                        $resultado = $conexao->query($sql);
                            if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo '<option value="'.$row["id_equipe"].'">'.$row["nome"].' </option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma equipe cadastrada</option>';
                        }
                    ?>
                    </select>
                </div>

                <div class="inputszinha">
                    <label for="resultado_equipe2">Resultado equipe 2 </label>
                    <input type="number" id="resultado_equipe2" name="resultado_equipe2" placeholder="Digite o resultado da equipe 2 " >
                </div>
              

                <div class="inputszinha">
                    <button type="submit" name="submit">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <?php
    // Sua lógica PHP aqui
    if (isset($_POST['submit'])) {
        // Sua lógica de processamento aqui

        if ($conexao->query($sql_insert) === TRUE) {
            echo "<script>
            Swal.fire({
                text: 'Partida Cadastrada com Sucesso!',
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });
            </script>";
        } else {
            echo "Erro ao cadastrar partida: " . $conexao->error;
        }

        $conexao->close();
    }
    ?>

</body>

</html>