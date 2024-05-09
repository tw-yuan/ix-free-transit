<?php
echo "Cron Starting!\n";
require './config.php';
# update prefix list
echo "Fetching user info";
$mongoClient = new MongoDB\Driver\Manager($mongo_link);
$collection = $databases_name . ".users";
$filter = [];
$query = new MongoDB\Driver\Query($filter);
$user_info = $mongoClient->executeQuery($collection, $query);
$user_info = json_decode(json_encode($user_info->toArray()), true);
echo "...DONE\nFetching prefix with AS-SET.\n";

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
        if ($net['active'] != 'no'){
            $asn = $net['asn'];
            $pdb_url = $peeringdb_cache . "api/net?asn=" . $asn;
            $asn_info = getAPI($pdb_url);
            if ($asn_info['data']['0']['irr_as_set']) {
                $bgpq_req = $asn_info['data']['0']['irr_as_set'];
            } else {
                $bgpq_req = "AS".$asn;
            }

            $collection = $databases_name . ".networks";
            $doc = [
                'as_set' => $bgpq_req
            ];
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->update(
                ['asn' => $asn],
                ['$set' => $doc],
                ['multi' => true, 'upsert' => true]
            );
            $result = $mongoClient->executeBulkWrite($collection, $bulk);
            echo $bgpq_req;
            $bgpq_url = $bgpq_api . "route6?req=" . $bgpq_req;
            $prefix_info = getAPI($bgpq_url)['NN'];
            foreach ($prefix_info as $prefixes) {
                $collection = $databases_name . ".prefixes";
                $doc = [
                    'pdb_user_id' => $id,
                    'prefix' => $prefixes['prefix'],
                    'source' => "IRR",
                    'status' => 'accepted'
                ];
                $bulk = new MongoDB\Driver\BulkWrite;
                $bulk->update(
                    ['pdb_user_id' => $id, 'prefix' => $prefixes['prefix']],
                    ['$set' => $doc],
                    ['multi' => true, 'upsert' => true]
                );
                $result = $mongoClient->executeBulkWrite($collection, $bulk);
            }
            echo "...DONE\n";
        }
    }
}
# update ix information
## I dont need this, so I didnt write it.
# create session
# update routemap
# update ripe asset object
require './mail.php';
echo "RIPE Update Mail sent.\n";
# function
function getAPI($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}
