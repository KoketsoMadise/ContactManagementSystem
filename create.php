<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fullname = $address = $city = $email = $profession = $cellphone = "";
$fullname_err = $address_err = $cellphone_err = $profession_err = $email_err = $city_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate fullname
    $input_fullname = trim($_POST["fullname"]);
    if(empty($input_fullname)){
        $fullname_err = "Please enter a fullname.";
    } elseif(!filter_var($input_fullname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fullname_err = "Please enter a valid fullname.";
    } else{
        $fullname = $input_fullname;
    }
    
    // Validate profession
    $input_profession = trim($_POST["profession"]);
    if(empty($input_profession)){
        $profession_err = "Please enter profession.";     
    } elseif(!filter_var($input_profession, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $profession_err = "Please enter a positive integer value.";
    } else{
        $profession = $input_profession;
    }

// Validate cellphone
$input_cellphone = trim($_POST["cellphone"]);
if(empty($input_cellphone)){
    $cellphone_err = "Please enter the cellphone.";     
} elseif(empty($input_cellphone)){
    $cellphone_err = "Please enter a positive integer value.";
} else{
    $cellphone = $input_cellphone;
}

// Validate email
$input_email = trim($_POST["email"]);
if(empty($input_email)){
    $email_err = "Please enter the correct email.";     
} elseif(empty($input_email)){
    $email_err = "Please enter a positive integer value.";
} else{
    $email = $input_email;
}

// Validate city
$input_city = trim($_POST["city"]);
if(empty($input_city)){
    $city_err = "Please enter the city.";     
} elseif(!filter_var($input_city, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    $city_err = "Please enter a positive integer value.";
} else{
    $city = $input_city;
}
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    
    // Check input errors before inserting in database
    if(empty($fullname_err) && empty($profession_err) && empty($address_err) && empty($city_err) && empty($email_err) && empty($cellphone_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO contacts (fullname, profession, cellphone, email, city, address) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_fullname, $param_profession, $param_cellphone, $param_email, $param_city, $param_address);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_profession = $profession;
            $param_cellphone = $cellphone;  
            $param_email = $email;
            $param_city = $city;
            $param_address = $address;
            
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add contact record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
                            <span class="help-block"><?php echo $fullname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($profession_err)) ? 'has-error' : ''; ?>">
                            <label>Profession</label>
                            <input type="text" name="profession" class="form-control" value="<?php echo $profession; ?>">
                            <span class="help-block"><?php echo $profession_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cellphone_err)) ? 'has-error' : ''; ?>">
                            <label>Cellphone</label>
                            <input type="text" name="cellphone" class="form-control" value="<?php echo $cellphone; ?>">
                            <span class="help-block"><?php echo $cellphone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email Address</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                            <span class="help-block"><?php echo $city;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>