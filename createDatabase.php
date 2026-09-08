<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Database</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Database</h2>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $databaseName = trim($_POST["database_name"]);
            
            // Validate database name: allow only letters, numbers, and underscores
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $databaseName)) {
                echo '<div class="alert alert-danger">Invalid database name. Please use only letters, numbers, and underscores.</div>';
            } else {
                $conn = new mysqli("localhost", "root", "");
                
                // Check connection
                if ($conn->connect_error) {
                    echo '<div class="alert alert-danger">Connection failed: ' . $conn->connect_error . '</div>';
                } else {
                    // Build CREATE DATABASE SQL
                    $sql = "CREATE DATABASE $databaseName";
                    
                    // Execute query and display result
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alert alert-success">Database <strong>' . htmlspecialchars($databaseName) . '</strong> created successfully!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error creating database: ' . $conn->error . '</div>';
                    }
                    
                    // Close connection
                    $conn->close();
                }
            }
        }
        ?>
        
        <form method="POST" class="mt-4 border p-4 rounded bg-light">
            <div class="mb-3">
                <label for="database_name" class="form-label">Database Name</label>
                <input type="text" name="database_name" id="database_name" class="form-control" placeholder="e.g., wis_lab" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Database</button>
        </form>
    </div>
</body>
</html>
