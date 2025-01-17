<!DOCTYPE html>
<html lang="en">

<head>
    <title>Signup</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- Material Kit CSS -->
    <link href="assets/css/material-kit.min.css?v=2.2.0" rel="stylesheet" />
</head>

<body class="login-page sidebar-collapse">



   <?php
    include 'navigation.php';

//Form submitted
if (isset($_POST['submit'])) {
    $error = [];

    // Validate password
    if (strcmp($_POST['password'], $_POST['confirm_password']) != 0) {
        $error['password'] = "Passwords Don't match";
    } else {
        $password = $_POST['password'];
        // Check password complexity
        if (!preg_match('/[A-Za-z]/', $password) || 
            !preg_match('/[0-9]/', $password) || 
            !preg_match('/[\W_]/', $password)) {
            $error['password_complexity'] = "Password must contain at least one letter, one number, and one special character.";
        }
    }

    // Validate phone number
    $phno = $_POST['phno'];
    if (!preg_match('/^(97|98)[0-9]{8}$/', $phno)) {
        $error['phone'] = "Phone number must start with 97 or 98 and contain 10 digits.";
    }

    // Validate email
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Invalid email format.";
    }

    // Check for errors
    if (empty($error)) {
        $conn = new mysqli("localhost", "root", "", "OnlineShopping");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO Users (user_name, user_email, user_phno, password, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phno, $password_hash, $address);

        $name = $_POST['name'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $address = "address"; // Replace with actual input if needed

        // Execute the statement
        $stmt->execute();
        echo "<p>Signed Up!</p>\n";

        $stmt->close();
        $conn->close();
    } else {
        // Display error messages
        foreach ($error as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
    }
}
?>

    <div class="page-header header-filter"
        style="background-image: url('assets/img/bg7.jpg'); background-size: cover; background-position: top center;">
        <div class="container">
            <br><br>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                    <form class="form" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                        <div class="card card-login card-hidden">
                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Signup</h4>
                            </div>
                            <div class="card-body ">
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">face</i>
                                            </span>
                                        </div>
                                        <input type="text"  name="name" class="form-control" pattern="[a-z A-Z]{2,}" placeholder="Name..." required>
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">phone</i>
                                            </span>
                                        </div>
                                        <input type="tel" pattern="[0-9]{10}" name="phno" class="form-control" placeholder="Phone No..." required>
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">email</i>
                                            </span>
                                        </div>
                                        <input name="email" type="email" class="form-control" placeholder="Email..." required>
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input name="password"  type="password" class="form-control" placeholder="Password..." required>
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input name="confirm_password" type="password" class="form-control" placeholder="Confirm Password..." required>

                                    </div>
                                    <span class="error"></span>
                                </span>
                            </div>
                            <p></p>
                            <div class="card-footer flex-column">
                                <input type="submit" name="submit" value="Submit" class="btn btn-rose btn-round"></input>

                                <a href="login.php" class="btn btn-rose btn-link btn-lg">Already have an account ?<div
                                        class="ripple-container"></div></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php
        include 'footer.php'
        ?>
    </div>

    <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
    <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/material-kit.js?v=2.2.0" type="text/javascript"></script>
</body>

</html>