<?php
require_once('page-header.php');
echo "<h1>Server Info</h1>
<p>Search for a server model by machine type / model:</p>
";

$client = new GuzzleHttp\Client();
$res = $client->get('http://nodejs-mongodb-reader/findall?commonName=E980');
echo $res->getStatusCode();           // 200
echo $res->getHeader('content-type'); // 'application/json; charset=utf8'
echo $res->getBody();                 // {"type":"User"...'
var_export($res->json());             // Outputs the JSON decoded data


require_once('page-footer.php');
?>