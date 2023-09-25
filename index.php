<?php
include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<link href="style.css" rel="stylesheet" type="text/css">

<?php
/* 
SELECT * FROM learnwellquestions
WHERE ID LIKE 'LP%'
ORDER BY RAND()
LIMIT 5;
*/
?>

<body>
    <form id="Survey" action="process_survey.php" method="post">
        <h2 style="">Group1213 Survey</h2>
        <div id="Surveyquestions"></div>
        <button id="submitButton" type="submit" name = "submit">Submit</button>
    </form>

    <script>
        const questions = [
            // Learning statements
            {
                surveyStatement: "I often have trouble making sense of the things I have to learn.",
                options: ["Strongly Disagree", "Disagree", "Neutral", "Agree", "Strongly Agree"],
                name: "q1"
            },
            {
                surveyStatement: "I put a lot of effort into my studying.",
                options: ["Strongly Disagree", "Disagree", "Neutral", "Agree", "Strongly Agree"],
                name: "q2"
            },
            {
                surveyStatement: "Much of what I've learned seems no more than unrelated bits and pieces.",
                options: ["Strongly Disagree", "Disagree", "Neutral", "Agree", "Strongly Agree"],
                name: "q3"
            }
            
        ];

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
                    <input type="radio" name="${question.name}" value="${optionIndex + 1}">
                    ${option}
                `;
                questionDiv.appendChild(label);
            });

            Surveyquestions.appendChild(questionDiv);
        });

    </script>
</body>


<?php include 'includes/footer.php'; ?>