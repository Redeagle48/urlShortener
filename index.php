<?php
$links = parse_ini_file('links.ini');

if(isset($_GET['link'], $links)) {
    header('Location: ' . $links[$_GET['link']]);
} else {
    header('HTTP/1.0 404 Not Found');
    echo 'Unknown link </br>';
    echo 'The link should be followed by ?link=<site acronym>';
}
