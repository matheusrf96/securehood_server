<?php

require_once "../config.php";
require_once "../db/db.php";

$db = new DB();

if(isset($_GET)){
    // Busca alerta

    $db->query("
        SELECT mensagem_usuario.*, usuario.username, usuario.primeiroNome, usuario.ultimoNome
        FROM mensagem_usuario
        INNER JOIN usuario ON mensagem_usuario.remetente_id = usuario.id
        WHERE mensagem_usuario.id = ?
    ");
    $db->bind(1, $_GET['id']);
    $result = $db->singleResult(); // Manda para a view

    if($result['destinatario_id'] == $_SESSION['usuario']['id']){
        // Atualiza como lida

        $db->query("
            UPDATE mensagem_usuario
            SET lida = 1,
            dataLida = NOW()
            WHERE id = ?
        ");
        $db->bind(1, $_GET['id']);
        $db->execute();
    }
    else{
        header("Location: ../index.php");
    }
}
else{
    header("Location: ../index.php");
}

?>