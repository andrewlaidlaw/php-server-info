<?php

function drawLine($server) {
    echo '<tr>';
    echo '<td>' . $server->totalCores . ' at ' . $server->frequencyGHz . ' GHz</td>';
    echo '<td>' . $server->CPW . '</td>';
    echo '<td>' . $server->rperfSMT1 . '</td>';
    echo '<td>' . $server->rperfSMT2 . '</td>';
    echo '<td>' . $server->rperfSMT4 . '</td>';
    echo '<td>' . $server->rperfSMT8 . '</td>';
    echo '</tr>
    ';
}

function drawTable($servers) {
    echo '<div class="ds-table-container">
    <table class="ds-table-compact ds-striped ds-hover">
    ';
    echo '<tr><th>Cores</th><th>CPW</th><th>rPerf ST</th><th>rPerf SMT2</th><th>rPerf SMT4</th><th>rPerf SMT8</th></tr>
    ';
    foreach($servers as $server) {
        drawLine($server);
    }
    echo '</table></div>
    ';
}

function renderDates($dates) {
    echo '<div class="ds-table-container">
    <table class="ds-table">
    ';
    echo '<tr><th>Announcement</th><th>General Availability</th><th>Withdrawn from Marketing</th><th>End of Support</th></tr>
    ';
    echo '<tr><td>' . $dates->announce . '</td><td>' . $dates->available . '</td><td>' . $dates->wdfm . '</td><td>' . $dates->eos . '</td></tr>
    ';
    echo '</table></div>';
}

?>