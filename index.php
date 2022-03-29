<?php
require_once('functions.php');
require_once('page-header.php');
require('vendor/autoload.php');

// Display title and description
echo '<h2 class="ds-heading-1 ds-col-10">Server Info</h2>
<p class="ds-col-10 ds-margin-bottom-2">Search for a server model by machine type / model:</p>
';

// Create form that provides data for this page to process
echo '
<div class="ds-row">
<form id="lookupform" action="index.php" method="post">
<div class="ds-input-container ds-col-3">
    <label for="model" class="ds-input-label">Machine type:</label>
    <input type="text" class="ds-input" name="model" placeholder="9117">
</div>
<div class="ds-input-container ds-col-3">
    <label for="type" class="ds-input-label">Model:</label>
    <input type="text" class="ds-input" name="type" placeholder="MMD">
</div>
<div class="ds-input-container ds-col-3">
    <label for="submit" class="ds-input-label">&nbsp;</label>
    <input type="submit" name="submit" class="ds-button ds-primary ds-text-align-center" value="Look up server">
</div>
</form>
</div>
<div class="ds-row">
';

// Collect data passed in through POST from form above and tidy
$model = substr($_POST['model'],0,4);
$type = strtoupper(substr($_POST['type'],0,3));
$modelType = $model . '-' . $type;

// TODO
// Add logic to check the machine type and model (4 digit number, 3 character alphanumeric)

// Only proceed if a machine type and model number were provided
if($model && $type) {

    // Collect the data from various sources

    // Start with the performance numbers
    $rperfclient = new GuzzleHttp\Client([ 'base_uri'=>'http://nodejs-mongodb-reader:8080/']);
    $rperfresponse = $rperfclient->request('GET', 'findall?modelType=' . $modelType);
    $content = $rperfresponse->getBody();
    $servers = json_decode($content, false);

    // Get the sales manual link
    $smclient = new GuzzleHttp\Client([ 'base_uri'=>'http://smfinder:8080/lookup']);
    $smresponse = $smclient->request('GET', '?mtm=' . $modelType);
    $smurl = $smresponse->getBody();

    // Then use that to get the dates
    $srclient = new GuzzleHttp\Client([ 'base_uri'=>'http://smreader:8080/']);
    $srresponse = $srclient->request('GET', '?url=' . $smurl);
    $srdetails = $srresponse->getBody();
    $dates = json_decode($srdetails,false);

    // Now we can render our page

    // TODO
    // Add logic to provide some level of error checking - ie 'Missing' response to sales manual lookup
    
    // Simple response
    echo '<h2 class="ds-heading-2">Server: ' . $servers[0]->commonName . ' - Machine Type / Model: ' . $modelType . ' - Generation: ' . parseGeneration($servers[0]->architecture) . '</h2>
    <div class="ds-hr ds-mar-b-2"></div>
    ';

    //Section to provide information on important dates
    echo '<h3 class="ds-heading-3">Important Dates</h3>
    <div class="ds-pad-b-3">';
    renderDates($dates);
    echo '</div>';

    // Section to create table of rPerf and CPW figures
    echo '<h3 class="ds-heading-3">Performance Figures</h3>
    <div class="ds-pad-b-3">';
    drawTable($servers);
    echo '</div>
    ';

    // Section to provide a link to the sales manual
    echo '<h3 class="ds-heading-3">Sales Manual Link</h3>
    <div class="ds-pad-b-3">
    <a href="' . $smurl . '">' . $servers[0]->commonName . ' (' . $modelType .') sales manual</a>
    </div>
    ';

// // If we don't have both machine type and model, provide instructions
} else {
    echo '<div class="ds-pad-b-3">Please enter a machine type and model number to get information about:
        <ul class="ds-list-icon ds-offset-1 ds-col-8">
            <li class="ds-flex"><span class="ds-icon-information ds-pad-r-2" role="img" aria-label="Information icon"></span>Dates for announcement, availability, withdrawal, and end of service</li>
            <li class="ds-flex"><span class="ds-icon-information ds-pad-r-2" role="img" aria-label="Information icon"></span>Performance figures for variants (CPW and rPerf)</li>
            <li class="ds-flex"><span class="ds-icon-information ds-pad-r-2" role="img" aria-label="Information icon"></span>A link to the sales manual for the server</li>
        </ul>
    </div>';
}

echo '</div>';

// Add footer from template
require_once('page-footer.php');
?>