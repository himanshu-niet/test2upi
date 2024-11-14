<?php
session_start();

// Check if the installation has been completed
if (file_exists('install.lock')) {
    header('Location: index.php');
    exit();
}

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['db_host'];
    $dbUser = $_POST['db_user'];
    $dbPass = $_POST['db_pass'];
    $dbName = $_POST['db_name'];

    // Attempt to connect to the database
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($mysqli->connect_error) {
        $error = "Connection failed: " . $mysqli->connect_error;
    } else {
        // Import the database
        $sql = file_get_contents('database.sql');
        if ($mysqli->multi_query($sql)) {
            do {
                // Store the results to free memory
                if ($result = $mysqli->store_result()) {
                    $result->free();
                }
            } while ($mysqli->more_results() && $mysqli->next_result());

            // Create config.php file
$configContent = "<?php\n";
$configContent .= "\$dbhost = '$dbHost';\n";
$configContent .= "\$dbname = '$dbName';\n";
$configContent .= "\$dbuser = '$dbUser';\n";
$configContent .= "\$dbpass = '$dbPass';\n";
$configContent .= "?>";

            file_put_contents('auth/components/config.php', $configContent);

            // Create a lock file to prevent re-execution
            file_put_contents('install.lock', 'Installation completed');

            // Redirect to index.php
            header('Location: index.php');
            exit();
        } else {
            $error = "Database import failed: " . $mysqli->error;
        }
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Install</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h1>Install</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="db_host">Database Host:</label>
            <input type="text" id="db_host" name="db_host" required>

            <label for="db_user">Database User:</label>
            <input type="text" id="db_user" name="db_user" required>

            <label for="db_pass">Database Password:</label>
            <input type="password" id="db_pass" name="db_pass" required>

            <label for="db_name">Database Name:</label>
            <input type="text" id="db_name" name="db_name" required>

            <button type="submit">Install</button>
        </form>
    </div>
</body>
</html>
