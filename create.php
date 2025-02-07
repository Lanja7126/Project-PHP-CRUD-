<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $username = $age = $phone = $address = $salary = "";
$gender = "";
$name_err = $username_err = $gender_err = $phone_err = $age_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/",$input_name)){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
     // Validate username
     $input_username = trim($_POST["username"]);
     if(empty($input_username)){
         $username_err = "Please enter a username.";
     } elseif(!preg_match("/^[a-zA-Z\s]+$/",$input_username)){
         $username_err = "Please enter a valid username.";
     } else{
         $username = $input_username;
     }
     
    
    // Validate gender
    if(!isset($_POST["gender"])){
        $gender_err = "Please select a gender.";
    } else{
        $gender = ($_POST["gender"] == "1") ? 1 : 0;
    }

    // Validate age
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter an age.";     
    } else{
        $age = $input_age;
    }

    // Validate phone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter an phone.";     
    } else{
        $phone = $input_phone;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($username_err) &&  empty($gender_err) &&  empty($age_err) &&  empty($phone_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name,username, gender, age, phone,address, salary) VALUES (?, ?, ?, ?,?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_username,$param_gender, $param_age,$param_phone,$param_address, $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_username = $username;
            $param_gender = $gender;
            $param_age = $age;
            $param_phone = $phone;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>

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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <div class="invalid-feedback"><?php echo $name_err;?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <div class="invalid-feedback"><?php echo $username_err;?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>">
                                <option value="">Sélectionner</option>
                                <option value="1" <?php echo ($gender == 1) ? "selected" : ""; ?>>M</option>
                                <option value="0" <?php echo ($gender == 0) ? "selected" : ""; ?>>W</option>
                            </select>
                            <div class="invalid-feedback"><?php echo $gender_err;?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <div class="invalid-feedback"><?php echo $age_err;?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="number" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                            <div class="invalid-feedback"><?php echo $phone_err;?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <div class="invalid-feedback"><?php echo $address_err;?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <div class="invalid-feedback"><?php echo $salary_err;?></div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
