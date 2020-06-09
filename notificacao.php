<?php
require 'gerencianet/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$clientId = 'XXX';
$clientSecret = 'XXX';

$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => true
];

//TOKEN PARA CONSULTA DE STATUS NO GERENCIANET
$token = 'token';
//$token = $_POST["notification"];
$params = [
  'token' => $token
];

try {
    $api = new Gerencianet($options);
    $chargeNotification = $api->getNotification($params, []);
  	//Para identificar o status atual da sua transação você deverá contar o número de situações contidas no array, pois a última posição guarda sempre o último status. Veja na um modelo de respostas na seção "Exemplos de respostas" abaixo.
  
  	// Veja abaixo como acessar o ID e a String referente ao último status da transação.
    
    // Conta o tamanho do array data (que armazena o resultado)
    $i = count($chargeNotification["data"]);
    // Pega o último Object chargeStatus
    $ultimoStatus = $chargeNotification["data"][$i-1];

    var_dump($chargeNotification);

    exit;

    // Acessando o array Status
    $status = $ultimoStatus["status"];
    // Obtendo o ID da transação    
    $charge_id = $ultimoStatus["identifiers"]["charge_id"];
    // Obtendo a String do status atual
    $statusAtual = $status["current"];

if($statusAtual == 'waiting'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Aguardando";
}
if($statusAtual == 'paid'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Pago";
}
if($statusAtual == 'unpaid'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Não Pago";
}
if($statusAtual == 'refunded'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Devolvido";
}
if($statusAtual == 'contested'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Contestado";
}  
if($statusAtual == 'canceled'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Cancelado";
}
if($statusAtual =='settled'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Status Pago Manualmenmte";
}
if($statusAtual == 'expired'){
	echo "O id da transação é: ".$charge_id." seu novo status é: Status Pago Manualmenmte";
}    
 
    //print_r($chargeNotification);
} catch (GerencianetException $e) {
	echo '<pre>';
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
    echo '</pre>';
} catch (Exception $e) {
	echo '<pre>';
    print_r($e->getMessage());
    echo '</pre>';
}