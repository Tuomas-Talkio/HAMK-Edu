<?php
include 'includes/header.php';

// Connect to database
include ('connect_to_loc_db.php');

// Query to get 5 random questions
$query1 = "SELECT ID, Statement, Best FROM learnwellquestions WHERE ID LIKE 'LP%' OR ID LIKE 'PR%' ORDER BY RAND() LIMIT 5;";
$query2 = "SELECT ID, Statement, Best FROM learnwellquestions WHERE ID LIKE 'LE%' ORDER BY RAND() LIMIT 5;";
$query3 = "SELECT ID, Statement, Best FROM learnwellquestions WHERE ID LIKE 'WB%' ORDER BY RAND() LIMIT 5;";
$query4 = "SELECT ID, Statement, Best FROM learnwellquestions WHERE ID LIKE 'IN%' OR ID LIKE 'DS%' OR ID LIKE 'CO%' OR ID LIKE 'SD%' OR ID LIKE 'EN%' OR ID LIKE 'CP%' OR ID LIKE 'CD%' ORDER BY RAND() LIMIT 5;";
$process = mysqli_query($conn, $query1);
$environemnt = mysqli_query($conn, $query2);
$skills = mysqli_query($conn, $query3);
$wellbeing = mysqli_query($conn, $query4);


$questions = array();

if ($process) {
    while ($row = mysqli_fetch_assoc($process)) {
        $question = array(
            'surveyStatement' => $row['Statement'],
            'options' => array('Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'),
            'name' => $row['ID'],
            'best' => $row['Best']
        );
        array_push($questions, $question);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

if ($environemnt) {
    while ($row = mysqli_fetch_assoc($environemnt)) {
        $question = array(
            'surveyStatement' => $row['Statement'],
            'options' => array('Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'),
            'name' => $row['ID'],
            'best' => $row['Best']
        );
        array_push($questions, $question);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

if ($skills) {
    while ($row = mysqli_fetch_assoc($skills)) {
        $question = array(
            'surveyStatement' => $row['Statement'],
            'options' => array('Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'),
            'name' => $row['ID'],
            'best' => $row['Best']
        );
        array_push($questions, $question);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

if ($wellbeing) {
    while ($row = mysqli_fetch_assoc($wellbeing)) {
        $question = array(
            'surveyStatement' => $row['Statement'],
            'options' => array('Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'),
            'name' => $row['ID'],
            'best' => $row['Best']
        );
        array_push($questions, $question);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}


mysqli_close($conn);
?>


<div class= 'contents'>
    <form id="Survey" action="process_survey.php" method="post">
        <div class= 'container'>
            <h1>LearnWell Questionaire</h1>
        </div>    
        <div id="Surveyquestions"></div>
        <div class= 'container'>
            <button  id="submitButton" type="submit" name = "submit">Submit</button>
        </div>
        <div class="gdpr">
            <p>Know about how we process your data</p>
            <span class="tooltip">We don't collect any personal data. The data is used and processed solely by HAMK.</span>
        </div>

    </form>

    <script>
        const questions = <?php echo json_encode($questions); ?>;

        const Surveyquestions = document.getElementById("Surveyquestions");
        questions.forEach((question, index) => {
            const questionDiv = document.createElement("div");
            questionDiv.classList.add("question");

            const questionParagraph = document.createElement("p");
            questionParagraph.classList.add("question-text");
            questionParagraph.textContent = question.surveyStatement;
            questionDiv.appendChild(questionParagraph);

            question.options.forEach((option, optionIndex) => {
                if(question.best == 5)
                    { $weight = optionIndex + 1; }
                else if(question.best == 1)
                    { $weight = ( (optionIndex - 5) * (-1) ) ;}
                const label = document.createElement("label");
                label.innerHTML = `
                    <input type="radio" name="${question.name}" value="${$weight}">
                    ${option}
                `;
                questionDiv.appendChild(label);
            });

            Surveyquestions.appendChild(questionDiv);
        });


    </script>
</div>


<?php include 'includes/footer.php'; ?>