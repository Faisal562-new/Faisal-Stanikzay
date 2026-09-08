<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Table</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Students Table</h2>
        
        <?php
        // Connect to the newly created database
        $conn = new mysqli("localhost", "root", "", "wis_lab");
        
        if ($conn->connect_error) {
            die('<div class="alert alert-danger">Connection failed: ' . $conn->connect_error . '</div>');
        }
        
        // CREATE TABLE students SQL
        $sql = "CREATE TABLE students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(120) NOT NULL,
            department VARCHAR(80) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        // Execute query and display result
        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success">Table <strong>students</strong> created successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Error creating table: ' . $conn->error . '</div>';
        }
        
        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
