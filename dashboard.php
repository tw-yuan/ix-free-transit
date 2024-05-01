<?php
require './db.php';
require './libs/Smarty.class.php';
$smarty = new Smarty;
session_start();

#query the session.
$mongoClient = new MongoDB\Driver\Manager($mongo_link);
$session_collection = $databases_name . ".sessions";
$filter = ['pdb_user_id' => $_SESSION['user']['id']];
$query = new MongoDB\Driver\Query($filter);
$cursor = $mongoClient->executeQuery($session_collection, $query);
$session = json_decode(json_encode($cursor->toArray()), true);

#query the prefixes.
$mongoClient = new MongoDB\Driver\Manager($mongo_link);
$prefixes_collection = $databases_name . ".prefixes";
$filter = ['pdb_user_id' => $_SESSION['user']['id']];
$query = new MongoDB\Driver\Query($filter);
$cursor = $mongoClient->executeQuery($prefixes_collection, $query);
$prefixes = json_decode(json_encode($cursor->toArray()), true);


if($_SESSION['user']['name']) {
    #below is static.
    $text = "Welcome, " . $_SESSION['user']['name'] . "!";
    $smarty->assign("username", $text);
    $smarty->assign("Login_button", '<a href="./auth.php?action=logout" target="_self" class="btn btn-danger">Logout</a>');
    #below is cutomized.
    $smarty->assign("network_count", count($_SESSION['user']['networks']));
    $smarty->assign("prefix_count", count($prefixes));
    $smarty->assign("session_count", count($session));
    $smarty->assign("userid", $_SESSION['user']['id']);
    $smarty->assign("email", $_SESSION['user']['email']);
} else {
    $smarty->assign("username", "Please login first.");
    $smarty->assign("Login_button", '<a href="./auth.php?action=login" target="_self" class="btn btn-success">Login with PeeringDB</a>');
    $smarty->assign("login_notice", '<div class="alert alert-danger" role="alert">Please login to access the Transit Manager.</div>');
    $smarty->assign("network_count", "0");
    $smarty->assign("prefix_count", "0");
    $smarty->assign("session_count", "0");
    $smarty->assign("userid", "N/A");
    $smarty->assign("email", "N/A");
}

$smarty->display('./template/html/index.tpl');
//print_r($_SESSION);

?>