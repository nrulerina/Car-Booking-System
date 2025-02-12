<?php
// Parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_cbs";

// Connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Verify connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$phpMailerHost = 'smtp.gmail.com';
$phpMailerUsername = 'nrulerina@gmail.com';
$phpMailerPassword = 'bmul xsry ueiz ekfz';

function base_url($url = null)
{
    global $baseUrl;
    return $baseUrl . $url;
}

$baseUrl = 'http://localhost/sdt/rental/';

function alert($message, $type = 'info')
{
    // bootsrap 4 alert
    $text = '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
    $text .= $message;
    $text .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    $text .= '<span aria-hidden="true">&times;</span>';
    $text .= '</button>';
    $text .= '</div>';
    return $text;
}

?>
