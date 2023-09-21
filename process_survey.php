<?php
session_start();
if (isset($_POST['submit'])) {
    //retrieve responses
    $q1Response = $_POST['q1'];
    $q2Response = $_POST['q2'];
    $q3Response = $_POST['q3'];

    //store the responses in a session var
    $_SESSION['survey_responses'] = [
        'q1' => $q1Response,
        'q2' => $q2Response,
        'q3' => $q3Response
    ];

    header("Location: results.php");
    exit;
}
else {

}
?>

