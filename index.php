<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .wrapper {
            box-shadow: 8px 8px 8px rgba(0, 0, 0, 0.1);
            border-radius: 25px;
            padding: 20px;
            width: 90%;
            border: 1px solid #f3f3f3;
            margin: 100px auto;
        }
    </style>

    <script>
        $(document).ready(function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2>Employees Details</h2>
                            <a href="create.php" class="btn btn-success">
                                <i class="fas fa-user-plus"></i> Add New Employee
                            </a>
                        </div>

                        <?php
                        // Include config file
                        require_once "config.php";

                        // Attempt select query execution
                        $sql = "SELECT * FROM employees";
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo "<div class='table-responsive'>";
                                echo "<table class='table table-bordered table-striped table-hover'>";
                                echo "<thead class='table-light'>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Name</th>";
                                echo "<th>Username</th>";
                                echo "<th>Gender</th>";
                                echo "<th>Age</th>";
                                echo "<th>Phone</th>";
                                echo "<th>Address</th>";
                                echo "<th>Salary</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . ($row['gender'] ? 'M' : 'W') . "</td>";
                                    echo "<td>" . $row['age'] . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['address'] . "</td>";
                                    echo "<td>" . $row['salary'] . "</td>";
                                    echo "<td>";
                                    echo "<a href='read.php?id=" . $row['id'] . "' title='View Record' data-bs-toggle='tooltip'><i class='fas fa-eye text-primary'></i></a> ";
                                    echo "<a href='update.php?id=" . $row['id'] . "' title='Update Record' data-bs-toggle='tooltip'><i class='fas fa-edit text-warning'></i></a> ";
                                    echo "<a href='delete.php?id=" . $row['id'] . "' title='Delete Record' data-bs-toggle='tooltip'><i class='fas fa-trash-alt text-danger'></i></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>";
                                //Free result set
                                mysqli_free_result($result);
                            } else {
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else {
                            echo "ERROR: Could not execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
