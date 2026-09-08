<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Student</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Student</h2>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullName = trim($_POST["full_name"]);
            $email = trim($_POST["email"]);
            $department = trim($_POST["department"]);
            
            // Create mysqli connection to wis_lab
            $conn = new mysqli("localhost", "root", "", "wis_lab");
            
            if ($conn->connect_error) {
                echo '<div class="alert alert-danger">Connection failed: ' . $conn->connect_error . '</div>';
            } else {
                // Validate that fields are not empty
                if (empty($fullName) || empty($email) || empty($department)) {
                    echo '<div class="alert alert-warning">All fields are required.</div>';
                } else {
                    // Challenge Task: Using Prepared Statements for better security
                    $stmt = $conn->prepare("INSERT INTO students (full_name, email, department) VALUES (?, ?, ?)");
                    
                    if ($stmt) {
                        // "sss" means three string variables
                        $stmt->bind_param("sss", $fullName, $email, $department);
                        
                        // Execute and display Bootstrap success/error alert
                        if ($stmt->execute()) {
                            echo '<div class="alert alert-success">Student added successfully.</div>';
                        } else {
                            echo '<div class="alert alert-danger">Error inserting record: ' . $stmt->error . '</div>';
                        }
                        $stmt->close();
                    } else {
                        echo '<div class="alert alert-danger">Error preparing statement: ' . $conn->error . '</div>';
                    }
                }
                // Close connection
                $conn->close();
            }
        }
        ?>
        
        <form method="POST" class="mt-4 border p-4 rounded bg-light">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" name="full_name" id="full_name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <!-- Browser validation via type="email" -->
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" name="department" id="department" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Student</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
        </form>
    </div>
</body>
</html>
