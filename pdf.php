<?php
header("Content-type:application/pdf");
$mensagem = file_get_contents("https://download.gerencianet.com.br/176967_42_MALZE3/176967-392767-MALZE8.pdf?sandbox=true");

echo $mensagem;