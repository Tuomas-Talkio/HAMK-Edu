<?php
include 'includes/header.php'; ?>

<main>
    <section>
        <h2>Results</h2>
        <?php
        include ('connect_to_loc_db.php');
        $result = mysqli_query($conn, "select * from results where id = '5'");

        echo "<table>";
        echo "<tr><th>ID</th><th>Process</th><th>Env</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['process'] . "</td>";
            echo "<td>" . $row['enviroment'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        ?>

    </section>
</main>

<?php include 'includes/footer.php'; ?>
