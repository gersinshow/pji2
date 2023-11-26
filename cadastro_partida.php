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
    $id_campeonato = $_POST['nome_campeonato']; // assumindo que isso corresponde ao id do campeonato
    $id_modalidade = 1; // assumindo que isso corresponde ao id da modalidade
    $id_unidade1 = $_POST['nome_unidade1']; // assumindo que isso corresponde ao id da unidade 1
    $id_equipe1 = $_POST['nome_equipe1']; // assumindo que isso corresponde ao id da equipe 1
    $id_unidade2 = $_POST['nome_unidade2']; // assumindo que isso corresponde ao id da unidade 2
    $id_equipe2 = $_POST['nome_equipe2']; // assumindo que isso corresponde ao id da equipe 2
    $cidade = $_POST['cidade'];
    $local_partida = $_POST['local'];
    $data = $_POST['data'];
    $horario = $_POST['hora'];
    $categoria = $_POST['categoria'];
    $arbitro1 = $_POST['arbitro1'];
    $arbitro2 = $_POST['arbitro2'];
    $apontador = $_POST['apontador'];
    $horario_1t_inicio = $_POST['horario_1t_inicio'];
    $horario_1t_fim = $_POST['horario_1t_fim'];
    $horario_1t_result_equipe1 = $_POST['resultado_equipe1_1t'];
    $horario_1t_result_equipe2 = $_POST['resultado_equipe2_1t'];
    $horario_2t_inicio = $_POST['horario_2t_inicio'];
    $horario_2t_fim = $_POST['horario_2t_fim'];
    $horario_2t_result_equipe1 = $_POST['resultado_equipe1_2t'];
    $horario_2t_result_equipe2 = $_POST['resultado_equipe2_2t'];
    $horario_prorrogacao_inicio = $_POST['horario_prorrogacao_inicio'];
    $horario_prorrogacao_fim = $_POST['horario_prorrogacao_fim'];
    $horario_prorrogacao_result_equipe1 = $_POST['resultado_equipe1_prorrogacao'];
    $horario_prorrogacao_result_equipe2 = $_POST['resultado_equipe2_prorrogacao'];
    $ocorrencias = $_POST['ocorrencias'];



    // Obtenha o próximo valor único para 'id_partida'
    $sql = "SELECT MAX(id_partida) AS max_id FROM partida";
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $next_id = $row['max_id'] + 1;

    // Inserir os dados na tabela 'partida' com o novo 'id_partida'
    $sql_insert = "INSERT INTO partida (id_campeonato, id_modalidade, id_partida, id_unidade1, id_equipe1, id_unidade2, id_equipe2, cidade, local_partida, data, horario, categoria, arbitro1, arbitro2, apontador, horario_1t_inicio, horario_1t_fim, horario_1t_result_equipe1, horario_1t_result_equipe2, horario_2t_inicio, horario_2t_fim, horario_2t_result_equipe1, horario_2t_result_equipe2, horario_prorrogacao_inicio, horario_prorrogacao_fim, horario_prorrogacao_result_equipe1, horario_prorrogacao_result_equipe2, ocorrencias) VALUES ('$id_campeonato', '$id_modalidade', '$next_id', '$id_unidade1', '$id_equipe1', '$id_unidade2', '$id_equipe2', '$cidade', '$local_partida', '$data', '$horario', '$categoria', '$arbitro1', '$arbitro2', '$apontador', '$horario_1t_inicio', '$horario_1t_fim', '$horario_1t_result_equipe1', '$horario_1t_result_equipe2', '$horario_2t_inicio', '$horario_2t_fim', '$horario_2t_result_equipe1', '$horario_2t_result_equipe2', '$horario_prorrogacao_inicio', '$horario_prorrogacao_fim', '$horario_prorrogacao_result_equipe1', '$horario_prorrogacao_result_equipe2', '$ocorrencias')";

    if ($conexao->query($sql_insert) === TRUE) {
        $_SESSION['successMessage'] = "Dados Inseridos com Sucesso.";
    } else {
        echo "Erro ao inserir dados: " . $conexao->error;
    }

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

            <form action="cadastro_partida.php" method="POST">

            <div class="inputszinha">
                    <label for="nome_campeonato">Campeonato</label>
                    <select name="nome_campeonato" id="nome_campeonato">
                    <?php

                        $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPorta);
                        // Recupera as opções do banco de dados
                        $sql = "SELECT id_campeonato, titulo, ano FROM campeonato";
                        $resultado = $conexao->query($sql);
                            if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo '<option value="'.$row["id_campeonato"].'">'.$row["titulo"].' '.$row["ano"].' </option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma equipe cadastrada</option>';
                        }
                    ?>
                    </select>
                </div>

            <div class="inputszinha">
                    <label for="nome_unidade1">Unidade 1</label>
                    <select name="nome_unidade1" id="nome_unidade1">
                    <?php

                        $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPorta);
                        // Recupera as opções do banco de dados
                        $sql = "SELECT id_unidade, sigla_instituicao, campus FROM unidade";
                        $resultado = $conexao->query($sql);
                            if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo '<option value="'.$row["id_unidade"].'">'.$row["sigla_instituicao"].' '.$row["campus"].'</option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma unidade cadastrada</option>';
                        }
                    ?>
                    </select>
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
                    <label for="nome_unidade2">Unidade 2</label>
                    <select name="nome_unidade2" id="nome_unidade2">
                    <?php
                        $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPorta);
                        // Recupera as opções do banco de dados
                        $sql = "SELECT id_unidade, sigla_instituicao, campus FROM unidade";
                        $resultado = $conexao->query($sql);
                            if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo '<option value="'.$row["id_unidade"].'">'.$row["sigla_instituicao"].' '.$row["campus"].'</option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma unidade cadastrada</option>';
                        }
                    ?>
                    </select>
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
                    <label for="cidade"> Cidade</label>
                    <input type="text" id="cidade" name="cidade" placeholder = "Digite o nome da cidade da partida" >
                </div>
                <div class="inputszinha">
                    <label for="local">Local da Partida</label>
                    <input type="text" id="local" name="local" placeholder="Digite o nome do local da partida" >
                </div>
                <div class="inputszinha">
                    <label for="data"> Data </label>
                    <input type="date" id="data" name="data" placeholder="Digite a data da partida" >
                </div>
                <div class="inputszinha">
                    <label for="hora">Horário</label>
                    <input type="time" id="hora" name="hora" placeholder="Digite o horário da partida" >
                </div>

                <div class="inputszinha">
                    <label for="categoria">Categoria</label>
                    <input type="text" id="categoria" name="categoria" placeholder="Digite a categoria" >
                </div>
                <div class="inputszinha">
                    <label for="arbitro1">Árbitro 1</label>
                    <input type="text" id="arbitro1" name="arbitro1" >
                </div>
                <div class="inputszinha">
                    <label for="arbitro2">Árbitro 2</label>
                    <input type="text" id="arbitro2" name="arbitro2" >
                </div>
                <div class="inputszinha">
                    <label for="apontador">Apontador</label>
                    <input type="text" id="apontador" name="apontador" >
                </div>
                <div class="inputszinha">
                    <label for="horario_1t_inicio">Horário do começo do 1º tempo</label>
                    <input type="time" id="horario_1t_inicio" name="horario_1t_inicio" placeholder="Digite o horário do inicio do primeiro tempo" >
                </div>
                <div class="inputszinha">
                    <label for="horario_1t_fim">Horário do fim do 1º tempo</label>
                    <input type="time" id="horario_1t_fim" name="horario_1t_fim" placeholder="Digite o horário do fim do primeiro tempo" >
                </div>
                <div class="inputszinha">
                    <label for="resultado_equipe1_1t">Resultado equipe 1 1º tempo</label>
                    <input type="number" id="resultado_equipe1_1t" name="resultado_equipe1_1t" placeholder="Digite o resultado da equipe 1 no primeiro tempo" >
                </div>
                <div class="inputszinha">
                    <label for="resultado_equipe2_1t">Resultado equipe 2 1º tempo</label>
                    <input type="number" id="resultado_equipe2_1t" name="resultado_equipe2_1t" placeholder="Digite o resultado da equipe 2 no primeiro tempo" >
                </div>
                <div class="inputszinha">
                    <label for="horario_2t_inicio">Horário do começo do 2º tempo</label>
                    <input type="time" id="horario_2t_inicio" name="horario_2t_inicio" placeholder="Digite o horário do inicio do segundo tempo" >
                </div>
                <div class="inputszinha">
                    <label for="horario_2t_fim">Horário do fim do 2º tempo</label>
                    <input type="time" id="horario_2t_fim" name="horario_2t_fim" placeholder="Digite o horário do fim do segundo tempo" >
                </div>
                <div class="inputszinha">
                    <label for="resultado_equipe1_2t">Resultado equipe 1 2º tempo</label>
                    <input type="number" id="resultado_equipe1_2t" name="resultado_equipe1_2t" placeholder="Digite o resultado da equipe 1 no segundo tempo" >
                </div>
                <div class="inputszinha">
                    <label for="resultado_equipe2_2t">Resultado equipe 2 2º tempo</label>
                    <input type="number" id="resultado_equipe2_2t" name="resultado_equipe2_2t" placeholder="Digite o resultado da equipe 2 no segundo tempo" >    
                </div>
                <div class="inputszinha">
                    <label for="horario_prorrogacao_inicio">Horário do inicio da prorrogação</label>
                    <input type="time" id="horario_prorrogacao_inicio" name="horario_prorrogacao_inicio" placeholder="Digite o horário do inicio da prorrogação" >
                </div>
                <div class="inputszinha">
                    <label for="horario_prorrogacao_fim">Horário do fim da prorrogação</label>
                    <input type="time" id="horario_prorrogacao_fim" name="horario_prorrogacao_fim" placeholder="Digite o horário do fim da prorrogação" >
                </div>
                <div class="inputszinha">
                    <label for="resultado_equipe1_prorrogacao">Resultado equipe 1 prorrogação</label>
                    <input type="number" id="resultado_equipe1_prorrogacao" name="resultado_equipe1_prorrogacao" placeholder="Digite o resultado da equipe 1 na prorrogação" >
                </div>
                <div class="inputszinha">
                    <label for="resultado_equipe2_prorrogacao">Resultado equipe 2 prorrogação</label>
                    <input type="number" id="resultado_equipe2_prorrogacao" name="resultado_equipe2_prorrogacao" placeholder="Digite o resultado da equipe 2 na prorrogação" >    
                </div>
                <div class="inputszinha">
                    <label for="ocorrencias">Informe as ocorrências</label>
                    <input type="text" id="ocorrencias" name="ocorrencias" placeholder="Digite as ocorrências da partida" >    
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


</body>

</html>