<?php
/* ==========================================================
   TASK 2, TASK 3 & TASK 4: ADMISSION APPLICATION
   File: admission.php
   ========================================================== */

// Include the database connection
require_once "db.php";

$message = "";
$messageType = "success";

/* ==========================================================
   TASK 3: SAVE APPLICATIONS
   ========================================================== */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Read submitted values and remove surrounding spaces
    $fullName = trim($_POST["full_name"] ?? "");
    $fatherName = trim($_POST["father_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $program = trim($_POST["program"] ?? "");

    // Check that all required fields contain values
    if (
        empty($fullName) ||
        empty($fatherName) ||
        empty($email) ||
        empty($phone) ||
        empty($program)
    ) {
        $message = "Please fill in all required fields.";
        $messageType = "danger";

    // Validate email in PHP
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "danger";

    } else {

        // Insert the application using a prepared statement
        $sql = "
            INSERT INTO applications
            (full_name, father_name, email, phone, program)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $conn->prepare($sql);

        if ($stmt) {

            // Bind all five values as strings
            $stmt->bind_param(
                "sssss",
                $fullName,
                $fatherName,
                $email,
                $phone,
                $program
            );

            if ($stmt->execute()) {

                /*
                 * Redirect after successful submission.
                 * This prevents the same application from being
                 * inserted again when the page is refreshed.
                 */
                header("Location: admission.php");
                exit;

            } else {
                $message = "Error saving application: " . $stmt->error;
                $messageType = "danger";
            }

            $stmt->close();

        } else {
            $message = "Could not prepare the SQL statement: " . $conn->error;
            $messageType = "danger";
        }
    }
}


/* ==========================================================
   TASK 4: DISPLAY ALL APPLICANTS
   ========================================================== */

/*
 * The SELECT query is outside the POST check so saved
 * applications are displayed whenever the page opens.
 *
 * Newest application first.
 */
$result = $conn->query("
    SELECT id, full_name, father_name, email, phone, program
    FROM applications
    ORDER BY id DESC
");

if (!$result) {
    die("Could not retrieve applications: " . $conn->error);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Admission Application</title>

    <!-- ======================================================
         TASK 2: BOOTSTRAP CSS
         ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- ======================================================
         TASK 2: DESIGN THE ADMISSION FORM
         ====================================================== -->

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm mb-5">

                <div class="card-header bg-primary text-white">
                    <h1 class="h3 text-center mb-0">
                        Student Admission Application
                    </h1>
                </div>

                <div class="card-body">

                    <!-- Display validation/error messages -->
                    <?php if (!empty($message)): ?>

                        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>

                    <?php endif; ?>


                    <!-- Admission Form -->
                    <form method="post" action="">

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="full_name"
                                name="full_name"
                                maxlength="100"
                                required
                            >
                        </div>


                        <!-- Father's Name -->
                        <div class="mb-3">
                            <label for="father_name" class="form-label">
                                Father's Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="father_name"
                                name="father_name"
                                maxlength="100"
                                required
                            >
                        </div>


                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                maxlength="100"
                                required
                            >
                        </div>


                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                Phone
                            </label>

                            <input
                                type="tel"
                                class="form-control"
                                id="phone"
                                name="phone"
                                maxlength="20"
                                required
                            >
                        </div>


                        <!-- Program Dropdown -->
                        <div class="mb-4">
                            <label for="program" class="form-label">
                                Program
                            </label>

                            <select
                                class="form-select"
                                id="program"
                                name="program"
                                required
                            >
                                <option value="" selected disabled>
                                    Select a program
                                </option>

                                <option value="Information Systems">
                                    Information Systems
                                </option>

                                <option value="Software Engineering">
                                    Software Engineering
                                </option>

                                <option value="Computer Science">
                                    Computer Science
                                </option>
                            </select>
                        </div>


                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Submit Application
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>


    <!-- ======================================================
         TASK 4: DISPLAY ALL APPLICANTS
         ====================================================== -->

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h2 class="h4 mb-0">
                Submitted Applications
            </h2>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Father's Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Program</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($row["id"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["full_name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["father_name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["email"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["phone"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row["program"]); ?>
                                </td>
                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No applications submitted yet.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>


    <!-- ======================================================
         TASK 5: TEST THE APPLICATION
         ====================================================== -->

    <!--
    1. Start Apache and MySQL in XAMPP.

    2. Create this folder:
       C:\xampp\htdocs\admission_lab

    3. Put BOTH files inside that folder:
       - db.php
       - admission.php

    4. Open:
       http://localhost/admission_lab/admission.php

    5. Test using fictional applicant information.

    6. Save at least three applications with different programs.

    7. Test empty required fields.
       They must not be saved.

    8. Test an invalid email.
       It must not be saved.

    9. Refresh after a successful submission.
       The same application must not be inserted again.

    10. Check the admission_db database and applications
        table in MySQL/phpMyAdmin.

    EXPECTED OUTCOME:
    A working admission page with a Bootstrap form and a
    table showing all saved applications.
    -->

</div>

</body>
</html>

<?php
/* ==========================================================
   CLOSE DATABASE CONNECTION
   ========================================================== */

$conn->close();
?>
