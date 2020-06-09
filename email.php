<?php
require 'gerencianet/autoload.php'; // caminho relacionado a SDK
 
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
$clientId = 'XXX';
$clientSecret = 'XXX';
 
$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
];
 
$charge_id = '572583';
// $charge_id refere-se ao ID da transação ("charge_id")
$params = [
  'id' => $charge_id
];
 
$body = [
  'email' => 'seuemail@hotmail.com'
];
 
try {
    $api = new Gerencianet($options);
    $response = $api->resendBillet($params, $body);
 
    print_r($response);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}