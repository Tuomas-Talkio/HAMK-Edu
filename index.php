<?php
include 'includes/header.php';

// Connect to database
include ('connect_to_loc_db.php');

// Query to get 5 random questions
$query = "SELECT ID, Statement, Best FROM learnwellquestions WHERE ID LIKE 'LP%' ORDER BY RAND() LIMIT 5;";
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    $questions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $question = array(
            'surveyStatement' => $row['Statement'],
            'options' => array('Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'),
            'name' => 'q' . $row['ID'],
            'best' => $row['Best']
        );
        array_push($questions, $question);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<link href="style.css" rel="stylesheet" type="text/css">

<body>
    <form id="Survey" action="process_survey.php" method="post">
        <h2>Group1213 Survey</h2>
        <div id="Surveyquestions"></div>
        <button  id="submitButton" type="submit" name = "submit">Submit</button>
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
                const label = document.createElement("label");
                label.innerHTML = `
                    <input type="radio" name="${question.name}" value="${(optionIndex + 1)}">
                    ${option}
                `;
                questionDiv.appendChild(label);
            });

            Surveyquestions.appendChild(questionDiv);
        });

    </script>
</body>


<?php include 'includes/footer.php'; ?>