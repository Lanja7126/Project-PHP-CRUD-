<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $username = $row["username"];
                $gender = $row["gender"] ? 'M' : 'W';
                $age = $row["age"];
                $phone = $row["phone"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>

    <!-- Bootstrap 5 CSS -->
    <link href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    
    <style>
        .wrapper {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <h1>View Record</h1>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <p class="form-control-plaintext"><?php echo $row["name"]; ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <p class="form-control-plaintext"><?php echo $row["username"]; ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gender</label>
                        <p class="form-control-plaintext"><?php echo ($row["gender"] == 1) ? 'M' : 'W'; ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Age</label>
                        <p class="form-control-plaintext"><?php echo $row["age"]; ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Téléphone</label>
                        <p class="form-control-plaintext"><?php echo $row["phone"]; ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <p class="form-control-plaintext"><?php echo $row["address"]; ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Salary</label>
                        <p class="form-control-plaintext"><?php echo $row["salary"]; ?></p>
                    </div>

                    <a href="index.php" class="btn btn-primary">Back</a>
                </div>
            </div>        
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
