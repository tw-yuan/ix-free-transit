<?php
require './config.php';
# update prefix list
$mongoClient = new MongoDB\Driver\Manager($mongo_link);
$collection = $databases_name . ".users";
$filter = [];
$query = new MongoDB\Driver\Query($filter);
$user_info = $mongoClient->executeQuery($collection, $query);
$user_info = json_decode(json_encode($user_info->toArray()), true);
foreach ($user_info as $user) {
    $id = $user['pdb_user_id'];
    $collection = $databases_name . ".prefixes";
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['pdb_user_id' => $id, 'source' => "IRR"]);
    $result = $mongoClient->executeBulkWrite($collection, $bulk);

    #=========================

    $collection = $databases_name . ".networks";
    $filter = ['pdb_user_id' => $id];
    $query = new MongoDB\Driver\Query($filter);
    $net_info = $mongoClient->executeQuery($collection, $query);
    $net_info = json_decode(json_encode($net_info->toArray()), true);
    foreach ($net_info as $net) {
        $asn = $net['asn'];
        $ch = curl_init();
        $pdb_url = $peeringdb_cache . "api/net?asn=" . $asn;
        curl_setopt($ch, CURLOPT_URL, $pdb_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        $asn_info = json_decode($result, true);
        if ($asn_info['data']['0']['irr_as_set']) {
            $bgpq_req = $asn_info['data']['0']['irr_as_set'];
        } else {
            $bgpq_req = $asn;
        }
        echo $bgpq_req;
        echo "<br>";
    }
}
# update ix information
# create session
# update routemap