<?php
session_start();
require_once('config.php');
/**$collection = $databases_name . ".users";
$bulk = new MongoDB\Driver\BulkWrite;
$doc = [
    'pdb_user_id' => $_SESSION['user']['id'],
    'email' => $_SESSION['user']['email'],
    'name' => $_SESSION['user']['name']
];
$bulk->insert($doc);
//$result = $mongoClient->executeBulkWrite($collection, $bulk);
//print_r($result);
$filter = ['name' => 'FENG SHENG YUAN'];
$query = new MongoDB\Driver\Query($filter);
$cursor = $mongoClient->executeQuery($collection, $query);
$car = json_decode(json_encode($cursor->toArray()), true);
//print_r($car);
foreach($car as $value) {
    echo $value['name'];
    echo '<br>';
}
**/