<?php
include 'includes/header.php'; ?>

<main>
    <script src="speedometer.js"></script>
    <section>
        <h2>Results</h2>
        <?php
        include ('connect_to_db.php');
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
                echo "<p>$columnName</p>";
                echo "<canvas id='$columnName' class='speedometer-canvas' data-result='$averageValue' width='300' height='300'></canvas>";
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
