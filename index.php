<?php
require 'gerencianet/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$clientId = 'XXX';
$clientSecret = 'XXX';

//CONFIGURANDO CLIENTE E SENHA PARA LANÇAMENTO
$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
];
 
//ITEM A SER VENDIDO
$item_1 = [
    'name' => 'Parcela de Internet', // nome do item, produto ou serviço
    'amount' => 1, // quantidade
    'value' => 5990 // valor (1000 = R$ 10,00)
];
 
$items =  [
    $item_1
];

// Exemplo para receber notificações da alteração do status da transação:
$metadata = ['notification_url'=>'URL de Notificação'];

$body  =  [
    'items' => $items,
    'metadata' => $metadata
];

try {
    $api = new Gerencianet($options);
    $charge = $api->createCharge([], $body);
    
    if (!empty($charge['data']['charge_id'])) {
      $params = [
        'id' => $charge['data']['charge_id']
      ];
      //DADOS DO CLIENTE QUE ESTA COMPRANDO
      $customer = [
        'name' => 'Cliente',
        'cpf' => '00000000000' ,
        'phone_number' => '7300000000' //ddd+numero
      ];
       
      /*DATA DE VENCIMENTO DO BOLETO*/
      $bankingBillet = [
        'expire_at' => '2019-06-10', 
        'customer' => $customer
      ];
      
      //forma de pagamento (banking_billet = boleto)
      $payment = [
        'banking_billet' => $bankingBillet
      ];
       
      $body = [
        'payment' => $payment
      ];
       
      try {
          $api = new Gerencianet($options);
          $charge = $api->payCharge($params, $body);
          //SUCESSO DA SOLICITAÇÃO

          ?>
          <a target="_black" href="pdf.php?boleto=<?=$charge['data']['pdf']['charge']; ?>">Boleto</a><br>
          Codigo de Barras: <?=$charge['data']['barcode']; ?><br>
          Data de Vencimento: <?=$charge['data']['expire_at']; ?><br>
          ID: <?=$charge['data']['charge_id']; ?><br>
          Status: <?=$charge['data']['status']; ?><br>
          Total: <?=$charge['data']['total']; ?><br>
          <?php
      } catch (GerencianetException $e) {
          print_r($e->code);
          print_r($e->error);
          print_r($e->errorDescription);
      } catch (Exception $e) {
          print_r($e->getMessage());
      }

    }
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}