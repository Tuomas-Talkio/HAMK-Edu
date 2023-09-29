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
        'avgProcess' => $avgProcess,
        'avgEnvironment' => $avgEnvironment,
        'avgSkills' => $avgSkills,
        'avgWellbeing' => $avgWellbeing,
    ];

    // Connect to the database
    include('connect_to_loc_db.php');

    // Get the data from the form
    $data = $_POST;

    // Prepare the query
    $query = "INSERT INTO data (";
    $values = "VALUES (";
    foreach ($data as $key => $value) {
        if (!empty($value)) {
            $query .= $key . ",";
            $values .= "'" . $value . "',";
        }
    }
    $query = rtrim($query, ",");
    $values = rtrim($values, ",");
    $query .= ") " . $values . ")";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Prepare the query to insert into results table
        $results_query = "INSERT INTO results (process, environment, skills, wellbeing) VALUES ('$avgProcess', '$avgEnvironment', '$avgSkills', '$avgWellbeing')";

        // Execute the results query
        if (mysqli_query($conn, $results_query)) {
            header("Location: results.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);

    exit;
    } else {
        // Handle the case where the form was not submitted
    }
    ?>

            

        // Close the connection
        mysqli_close($conn);

    exit;
}
else {

}
?>

