<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fullname = $profession = $email = $cellphone = $address = $city = "";
$fullname_err = $profession_err = $email_err = $cellphone_err = $city_err = $address_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate fullname
    $input_fullname = trim($_POST["fullname"]);
    if(empty($input_fullnname)){
        $name_err = "Please enter full name.";
    } elseif(!filter_var($input_fullname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid fullname.";
    } else{
        $fullname = $input_fullname;
    }

    // Validate profession
    $input_profession = trim($_POST["profession"]);
    if(empty($input_profession)){
        $name_err = "Please enter profession.";
    } elseif(!filter_var($input_profession, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid profession.";
    } else{
        $profession = $input_profession;
    }
    

 // Validate email
 $input_email = trim($_POST["email"]);
 if(empty($input_email)){
     $name_err = "Please enter email.";
 } elseif(!filter_var($input_fullname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
     $name_err = "Please enter a valid email.";
 } else{
     $email = $input_email;
 }

 // Validate cellphone
 $input_cellphone = trim($_POST["cellphone"]);
 if(empty($input_cellphone)){
     $name_err = "Please enter cellphone.";
 } elseif(!filter_var($input_cellphone, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
     $name_err = "Please enter a valid cellphone number.";
 } else{
     $cellphone = $input_cellphone;
 }


 // Validate address city
 $input_city = trim($_POST["city"]);
 if(empty($input_city)){
     $address_err = "Please enter a city.";     
 } else{
     $city = $input_city;
 }

    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Check input errors before inserting in database
    if(empty($fullname_err) && empty($address_err) && empty($city_err) && empty($cellphone_err) && empty($email_err) && empty($profession_err)){
        // Prepare an update statement
       // $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";

        $sql = "UPDATE contacts SET fullname=?, profession=?, cellphone=?, email=?, city=?, address=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_fullname, $param_address, $param_email, $param_profession, $param_cellphone, $param_city, $param_id);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_address = $address;
            $param_salary = $profession;
            $param_city = $city;
            $param_cellphone = $cellphone;
            $param_email = $email;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM contacts WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $fullname = $row["fullname"];
                    $profession = $row["profession"];
                    $cellphone = $row["cellphone"];
                    $email = $row["email"];
                    $city = $row["city"];
                    $address = $row["address"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Update Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper {
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
                            <h2>Update Record</h2>
                        </div>
                        <p>Please edit the input values and submit to update the record.</p>
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                            <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                                <label>FullName</label>
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
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                                <span class="help-block"><?php echo $email_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                                <span class="help-block"><?php echo $city_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                                <label>Address</label>
                                <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                                <span class="help-block"><?php echo $address_err;?></span>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>