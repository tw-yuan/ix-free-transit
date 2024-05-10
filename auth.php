<?php
require_once('config.php');
ini_set('max_execution_time', 300);

define('OAUTH2_CLIENT_ID', $Peeringdb_OAUTH2_CLIENT_ID);
define('OAUTH2_CLIENT_SECRET', $Peeringdb_OAUTH2_CLIENT_SECRET);
define('REDIRECT_URI', $REDIRECT_URI);

$authorizeURL = 'https://auth.peeringdb.com/oauth2/authorize';
$tokenURL = 'https://auth.peeringdb.com/oauth2/token/';
$apiURLBase = 'https://auth.peeringdb.com/profile/v1';

session_start();

if (get('action') == 'login') {

    $params = array(
        'client_id' => OAUTH2_CLIENT_ID,
        'redirect_uri' => REDIRECT_URI,
        'response_type' => 'code',
        'scope' => 'profile email networks',
        'perms' => '0100'
    );
    header('Location: ' . $authorizeURL . '?' . http_build_query($params));
    die();
}

if ($_GET['code']) {
    $_SESSION['code'] = $_GET['code'];
    $data = array(
        "client_id" => OAUTH2_CLIENT_ID,
        "client_secret" => OAUTH2_CLIENT_SECRET,
        "grant_type" => 'authorization_code',
        "code" => $_SESSION['code'],
        "redirect_uri" => REDIRECT_URI
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $tokenURL);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response, true);
    $_SESSION['access_token'] = $results['access_token'];
    $user = apiRequest($apiURLBase);
    $_SESSION['user'] = $user;
    header('Location: ' . $_SERVER['PHP_SELF']);
}

if (session('access_token')) {
    $_SESSION['user'] = json_decode(json_encode($_SESSION['user']), true);
    $mongoClient = new MongoDB\Driver\Manager($mongo_link);
    $collection = $databases_name . ".users";
    $doc = [
        'email' => $_SESSION['user']['email'],
        'name' => $_SESSION['user']['name']
    ];
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(
        ['pdb_user_id' => $_SESSION['user']['id']],
        ['$set' => $doc],
        ['multi' => true, 'upsert' => true]
    );
    $result = $mongoClient->executeBulkWrite($collection, $bulk);

    foreach ($_SESSION['user']['networks'] as $value) {

        $collection = $databases_name . ".networks";
        $filter = ['pdb_user_id' => $_SESSION['user']['id'], 'pdb_network_id' => $value['id']];
        $query = new MongoDB\Driver\Query($filter);
        $net_info = $mongoClient->executeQuery($collection, $query);
        $net_info = json_decode(json_encode($net_info->toArray()), true);

        if ($net_info[0]['active'] == 'no') {
            $collection = $databases_name . ".networks";
            $doc = [
                'pdb_network_id' => $value['id'],
                'asn' => $value['asn'],
                'name' => $value['name'],
                'active' => 'no'
            ];
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->update(
                ['pdb_user_id' => $_SESSION['user']['id'], 'pdb_network_id' => $value['id']],
                ['$set' => $doc],
                ['multi' => true, 'upsert' => true]
            );
            $result = $mongoClient->executeBulkWrite($collection, $bulk);
        } else {
            $collection = $databases_name . ".networks";
            $doc = [
                'pdb_network_id' => $value['id'],
                'asn' => $value['asn'],
                'name' => $value['name'],
                'active' => 'yes'
            ];
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->update(
                ['pdb_user_id' => $_SESSION['user']['id'], 'pdb_network_id' => $value['id']],
                ['$set' => $doc],
                ['multi' => true, 'upsert' => true]
            );
            $result = $mongoClient->executeBulkWrite($collection, $bulk);
        }
    }
    //update_userinfo($mongoClient,$databases_name);
}

if (get('action') == 'logout') {
    unset($_SESSION['access_token']);
    unset($_SESSION['user']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    die();
}

function apiRequest($url, $post = FALSE, $headers = array())
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);


    if ($post)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

    $headers[] = 'Accept: application/json';

    if (session('access_token'))
        $headers[] = 'Authorization: Bearer ' . session('access_token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    return json_decode($response);
}

function logout($url, $data = array())
{
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
        CURLOPT_POSTFIELDS => http_build_query($data),
    ));
    $response = curl_exec($ch);
    return json_decode($response);
}

function get($key, $default = NULL)
{
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default = NULL)
{
    return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}


header('Location: ./dashboard.php');
