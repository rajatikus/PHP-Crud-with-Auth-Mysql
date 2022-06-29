<?php
// Include config file
require_once "config.php";
require_once "session.php";
 
// Define variables and initialize with empty values
$name = $lahir = $address = $salary = $kepala = "";
$name_err = $lahir_err = $address_err = $telpon_err = $kepala_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Masukan nama warga.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Masukan nama yang benar.";
    } else{
        $name = $input_name;
    }
    
    // Validate Lahir
   
    $input_lahir = date('Y-m-d', strtotime($_POST['lahir']));
    if(empty($input_lahir)){
        $lahir_err = "Masukan tanggal lahir.";     
    } else{
        $lahir = $input_lahir;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Isi alamatnya.";     
    } else{
        $address = $input_address;
    }
    
    // Validate telpon
    $input_telpon = trim($_POST["telpon"]);
    if(empty($input_telpon)){
        $telpon_err = "Harap isi nomer telp.";     
    } elseif(!ctype_digit($input_telpon)){
        $telpon_err = "Masukan nomor dengan benar.";
    } else{
        $telpon = $input_telpon;
    }

    $input_kepala = trim($_POST["kepala"]);
    if(empty($input_kepala)){
        $kepala_err = "Please enter a Kepala keluarga.";
    } elseif(!filter_var($input_kepala, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $kepala_err = "Please enter a valid kepala.";
    } else{
        $kepala = $input_kepala;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($lahir_err) && empty($address_err) && empty($telpon_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO datawarga (name, lahir, address, telpon, kepala) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_lahir, $param_address, $param_telpon, $param_kepala);
            
            // Set parameters
            $param_name = $name;
            $param_lahir = $lahir;
            $param_address = $address;
            $param_telpon = $telpon;
            $param_kepala = $kepala;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index_admin.php");
                exit();
            } else{
                echo "Oops! CREATE Something went wrong. Please try again later.";
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
                    <h2 class="mt-5">Buat Data Baru</h2>
                    <p>Isi data di bawah ini untuk menambah data warga baru.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                            <label>Alamat</label>
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index_admin.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>