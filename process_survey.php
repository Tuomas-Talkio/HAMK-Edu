<?php
session_start();
if (isset($_POST['submit'])) {

    $avgProcess = 0;
    $avgEnvironment = 0;
    $avgSkills = 0;
    $avgWellbeing = 0;
    $countProcess = 0;
    $countEnvironment = 0;
    $countSkills = 0;  
    $countWellbeing = 0;

    $counter = 0;
    foreach ($_POST as $value) {
        if($counter == 0)
        {
            $counter++;
            continue;
        }
        if (empty($value)) { $value = 0; }
            if ($counter < 5) {
                $avgProcess += $value;
                $countProcess ++;
            } else if ($counter < 10 and $counter > 4) {
                $avgEnvironment += $value;
                $countEnvironment++;
            } else if ($counter < 15 and $counter > 9) {
                $avgSkills += $value;
                $countSkills++;
            } else if ($counter < 20 and $counter > 14) {
                $avgWellbeing += $value;
                $countWellbeing++;
            }
            $counter++;
        
    }

    if($countProcess != 0)
    {
        $avgProcess = $avgProcess / $countProcess;
    }
    if($countEnvironment != 0)
    {
        $avgEnvironment = $avgEnvironment / $countEnvironment;
    }
    if($countSkills != 0)
    {
        $avgSkills = $avgSkills / $countSkills;
    }
    if($countWellbeing != 0)
    {
        $avgWellbeing = $avgWellbeing / $countWellbeing;
    }

    //store the responses in a session var
    $_SESSION['survey_responses'] = [
        'avgProcess' => 1,
        'avgEnvironment' => 2,
        'avgSkills' => 3,
        'avgWellbeing' => 4,
    ];

    header("Location: results.php");
    exit;
}
else {

}
?>

