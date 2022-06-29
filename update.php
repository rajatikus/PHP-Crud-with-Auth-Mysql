<?php


// Include config file
require_once "session.php";
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $lahir = $address = $telpon = $kepala = "";
$name_err = $lahir_err = $address_err = $telpon_err = $kepala_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
       // Validate address lahir
       $input_lahir = trim($_POST["lahir"]);
       if(empty($input_lahir)){
           $lahir_err = "Please enter an lahir.";     
       } else{
           $lahir = $input_lahir;
       }
       
    
    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate telpon
    $input_telpon = trim($_POST["telpon"]);
    if(empty($input_telpon)){
        $telpon_err = "Please enter the telpon amount.";     
    } elseif(!ctype_digit($input_telpon)){
        $telpon_err = "Please enter a positive integer value.";
    } else{
        $telpon = $input_telpon;
    }

        // Validate kepala
    $input_kepala = trim($_POST["kepala"]);
    if(empty($input_kepala)){
        $kepala_err = "Please enter a kepala.";
    } elseif(!filter_var($input_kepala, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $kepala_err = "Please enter a valid kepala.";
    } else{
        $kepala = $input_kepala;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($lahir_err) && empty($address_err) && empty($telpon_err) && empty($kepala_err)){
        // Prepare an update statement
        $sql = "UPDATE datawarga SET name=?, lahir=?, address=?, telpon=?, kepala=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssdsi", $param_name, $param_lahir, $param_address, $param_telpon, $param_kepala, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_lahir = $lahir;
            $param_address = $address;
            $param_telpon = $telpon;
            $param_kepala = $kepala;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index_admin.php");
                exit();
            } else{
                echo "Oops! fro here Something went wrong. Please try again later.";
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
        $sql = "SELECT * FROM datawarga WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $lahir = $row["lahir"];
                    $address = $row["address"];
                    $telpon = $row["telpon"];
                    $kepala = $row["kepala"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! updateSomething went wrong. Please try again later.";
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
    <title>Ubah Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Ubah Data Warga </h2>
                    <p>Isi ubahan data dengan lengkap.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Lahir</label>
                            <input type="date" name="lahir" class="form-control <?php echo (!empty($lahir_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lahir; ?>">
                            <span class="invalid-feedback"><?php echo $lahir_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Telpon</label>
                            <input type="text" maxlength="10" name="telpon" class="form-control <?php echo (!empty($telpon_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telpon; ?>">
                            <span class="invalid-feedback"><?php echo $telpon_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Kepala Keluarga</label>
                            <input type="text" name="kepala" class="form-control <?php echo (!empty($kepala_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $kepala; ?>">
                            <span class="invalid-feedback"><?php echo $kepala_err;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>