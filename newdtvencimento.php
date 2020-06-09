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
 
$charge_id = '572446';

// $charge_id refere-se ao ID da transação gerada anteriormente
$params = [
  'id' => $charge_id
];

$body = [
  'expire_at' => '2019-02-01',
];

try {
    $api = new Gerencianet($options);
    $charge = $api->updateBillet($params, $body);
    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}