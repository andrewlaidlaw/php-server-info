<?php
require_once('functions.php');
require_once('page-header.php');
require('vendor/autoload.php');

// Opening page
echo '<h1>Server Info</h1>
<p>Search for a server model by machine type / model:</p>
';

// Create form that provides data for this page to process
echo '
<form action="index.php" method="post">
<div class="ds-input-container ds-col-6 ds-mar-b-2">
    <label for="model" class="ds-input-label">Model:</label>
    <input type="text" class="ds-input" name="model" placeholder="9117">
</div>
<div class="ds-input-container ds-col-6 ds-mar-b-2">
    <label for="type" class="ds-input-label">Type:</label>
    <input type="text" class="ds-input" name="type" placeholder="MMD">
</div>
<div class="ds-input-container ds-col-12 ds-mar-b-2">
<input type="submit" class="ds-button ds-primary ds-text-align-center" label="Look Up">
</form>
';

$model = $_POST['model'];
$type = $_POST['type'];
$modelType = $model . '-' . $type;

if($model && $type) {

    // Simple response
    echo '<p class="ds-heading-5">Machine Type / Model is: ' . $modelType . '</p>
    <div class="ds-hr ds-mar-b-2_5"></div>
    ';

    // Section to create table of rPerf and CPW figures
    echo '<h3>Performance Figures</h3>
    <p>';
    $rperfclient = new GuzzleHttp\Client([ 'base_uri'=>'http://nodejs-mongodb-reader:8080/']);
    $rperfresponse = $rperfclient->request('GET', 'findall?modelType=' . $modelType);
    $content = $rperfresponse->getBody();
    $servers = json_decode($content, false);
    drawTable($servers);
    echo '</p>
    ';

    // Section to provide a link to the sales manual
    $smclient = new GuzzleHttp\Client([ 'base_uri'=>'http://smfinder:8080/']);
    $smresponse = $smclient->request('GET', '?mtm=' . $modelType);
    $smurl = $smresponse->getBody();
    echo '<h3>Sales Manual Link</h3>
    <p><a href="' . $smurl . '">' . $servers[0]->commonName . ' (' . $modelType .') sales manual</a></p>
    ';

    //Section to provide information on important dates
    $srclient = new GuzzleHttp\Client([ 'base_uri'=>'http://smreader:8080/']);
    $srresponse = $srclient->request('GET', '?url=' . $smurl);
    $srdetails = $srresponse->getBody();
    $dates = json_decode($srdetails,false);
    renderDates($dates);

}

// Add footer from template
require_once('page-footer.php');
?>