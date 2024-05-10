<?php
require './db.php';
require './libs/Smarty.class.php';
$smarty = new Smarty;
session_start();

#query the session.
$mongoClient = new MongoDB\Driver\Manager($mongo_link);
$collection = $databases_name . ".prefixes";
$filter = ['pdb_user_id' => $_SESSION['user']['id']];
$query = new MongoDB\Driver\Query($filter);
$prefixes = $mongoClient->executeQuery($collection, $query);
$prefixes = json_decode(json_encode($prefixes->toArray()), true);

#query the users.
$prefixes_collection = $databases_name . ".users";
$filter = ['pdb_user_id' => $_SESSION['user']['id']];
$query = new MongoDB\Driver\Query($filter);
$cursor = $mongoClient->executeQuery($prefixes_collection, $query);
$users = json_decode(json_encode($cursor->toArray()), true);

if($_SESSION['user']['id']) {
    #below is static.
    $text = "Welcome, " . $users['0']['name'] . "!";
    $smarty->assign("username", $text);
    $smarty->assign("Login_button", '<a href="./auth.php?action=logout" target="_self" class="btn btn-danger">Logout</a>');
    #below is cutomized.
    $smarty->assign("prefix_list", $prefixes);
    $smarty->assign("userid", $_SESSION['user']['id']);
    $smarty->assign("asn", $system_as);
    $smarty->display('./template/html/prefix.tpl');
} else {
    header('Location: ./dashboard.php');
}
