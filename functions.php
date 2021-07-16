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
    echo '<div class="ds-table-container ds-col-10">
    <table class="ds-table ds-table-compact ds-striped ds-hover">
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
    echo '<div class="ds-table-container ds-col-10">
    <table class="ds-table ds-table-compact ds-striped">
    ';
    echo '<tr><th>Announcement</th><th>General Availability</th><th>Withdrawn from Marketing</th><th>End of Support</th></tr>
    ';
    echo '<tr><td>' . $dates->announce . '</td><td>' . $dates->available . '</td><td>' . $dates->wdfm . '</td><td>' . $dates->eos . '</td></tr>
    ';
    echo '</table></div>';
}

function parseGeneration($architecture) {
    switch($architecture) {
        case "p4_":
            return "POWER4";
            break;
        case "p4+":
            return "POWER4+";
            break;
        case "p5_":
            return "POWER5";
            break;
        case "p5+":
            return "POWER5+";
            break;
        case "p6_":
            return "POWER6";
            break;
        case "p6+":
            return "POWER6+";
            break;
        case "p7_":
            return "POWER7";
            break;
        case "p7+":
            return "POWER7+";
            break;
        case "p8":
            return "POWER8";
            break;
        case "p9":
            return "POWER9";
            break;
        case "p10":
            return "Power10";
            break;
    }
}

?>