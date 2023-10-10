<?php
include 'includes/header.php'; ?>

<main>
    <?php
    //retrieve answers from session variable
    if (isset($_SESSION['survey_responses'])) {
        $surveyResponses = $_SESSION['survey_responses'];
    //    echo "Group 1 avg: " . $surveyResponses['avgProcess'] . "<br>";
    //    echo "Gr 2 avg: " . $surveyResponses['avgEnvironment'] . "<br>";
    //    echo "Gr 3 avg: " . $surveyResponses['avgSkills'] . "<br>";
    //    echo "Gr 4 avg: " . $surveyResponses['avgWellbeing'] . "<br>";
    } else {
        echo "No survey responses found.";
    }

    $customText = array('process'=>'You should prioritize working on your independent work at least a little each day until you complete, preferably if you work on your independent work until you get stuck on something complicated or something you are unsure of before the next class on that course and before the deadline for the tasks you can ask the teacher for advice on what you got stuck on. This also means you can spend the rest of your free time however you want knowing that you do not need to stress and that you will be able to do the tasks in time. 
     
    You should not feel like you need to make a rigid schedule when you do independent studies if you know it is too stressful for you it just makes organizing your studies unappealing and depending on your workload it might be completely unnecessary.',
    'environment'=>  'If you have not fully understood of what the learning goals are in the course or how the course is assessed, you should ask the teacher about it either in person or via email. Or read the material made by the teacher that talks about these things. You can also ask for more feedback on your completed tasks and mention to the teacher if you know the way you learn does not match the teacher’s teaching methods. 
     
    While everybody does not need to be a leader in a group, you should try to communicate more with your teammates, be actively involved and try to be present as much as possible. Remember you cannot do anything about when you get sick and you should stay home if that happens, but let your team know if you cannot be present during a group meeting or lesson. Do not be afraid to ask for help if you need it, do not be afraid to ask for tasks to do if you do not know what to do and do not be afraid to give suggestions or ideas about the project. ',
    'skills'=> 'If you feel like you do not have good communication skills, you first should think on what you can improve on. Starting a conversation and asking for clarification when somebody asks it both can go a long way on improving your communication skills. If you are an introvert, it might be worth it to practice talking with people you already know and pretending they are a group member or a customer for a project. This way you can practice your communication skills in a safe and less stressful environment 
    
     
    If you feel like you have poor problem-solving skills do note that if you feel like a problem is too hard for you solving it is usually the best way to improve your skills. Alternatively, you could look into exercises that would help you develop your problem-solving skills and start on a level you feel you can handle. When you are trying to develop your problem-solving skills there is usually no point in starting at a level that is extremely easy for you because you only learn when you need to use your brain. You could also play puzzle games because they usually introduce a few simple elements that are then used to test your problem-solving skills with harder and harder puzzles. This could help give you confidence in your own problem-solving abilities. 
      
    If you are having problems with analyzing and categorizing information, try asking for help until you get it. 
      
    If you are having problems describing what skills, you have learned from your studies try to think about everything that was new to you and that you understand those are all things you can now do and have the skills for.',
    'wellbeing'=> 'Have you told the teachers on your current courses, you are experiencing troubles in their studies? They might be able to help with something you are stuck on or do not understand. Asking your classmates for help could also be beneficial.  
     
    You could talk with your student counsellor and talk with them about reducing how many courses you do in one semester to lessen your workload if you feel overwhelmed by your studies. ');

    ?>

    <script src="speedometer.js"></script>
    <section>
        <h1>Results:</h1><br
        <?php
        include ('connect_to_loc_db.php');
        $result = mysqli_query($conn, "SHOW COLUMNS FROM results");

        $columnNames = array();
        while ($row = $result->fetch_assoc()) {
            if ($row['Field'] != 'id' && $row['Field'] != 'peergroup') {
                $columnNames[] = $row['Field'];
            }
        }


        $columnList = implode(', ', $columnNames);
        $result = mysqli_query($conn,"SELECT " . $columnList . " FROM results");

        if ($result->num_rows > 0) {
            $averages = array_fill_keys($columnNames, 0);
            $rowCount = 0;

            while ($row = $result->fetch_assoc()) {
                foreach ($columnNames as $columnName) {
                    $averages[$columnName] += $row[$columnName];
                }
                $rowCount++;
            }

            // Calculate the averages
            foreach ($averages as $columnName => $sum) {
                $averages[$columnName] /= $rowCount;
            }

            foreach ($averages as $columnName => $averageValue) {
                echo "<h2>study $columnName </h2>";
                $userValueCategory = "avg" . ucfirst($columnName);

                echo "<canvas id='$columnName' class='speedometer-canvas' data-result='$averageValue' data-user=" . $surveyResponses[$userValueCategory] . " width='300' height='300'></canvas>";

                $advice = 'TEXTTEXT';

                $responseQuery = "SELECT DISTINCT response FROM response WHERE average=round($averageValue) AND personal=round($surveyResponses[$userValueCategory]) AND type='$columnName'";
                $result1 = mysqli_query($conn, $responseQuery);
                if ($result1 && $result1->num_rows > 0) {
                    $row = $result1->fetch_assoc();
                    $response = $row['response'];
                    echo "<p>$response</p>";
                }
                
                echo "<p>$customText[$columnName]</p>";
            }
        }
        else {
                echo "No results found";
        }

        $conn->close();
        ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
