<?php 
//include config file
require_once "config.php";
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: dashboard");
  exit;
}

// Define variables and initialize with empty values
$name = $school = $username = $password = $confirm_password = $email = "";
$name_err = $school_err = $username_err = $password_err = $confirm_password_err =  $email_err = $captcha_err = "";

//processing form data when it is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Fullname -->
    if(empty($_POST["name"])){
        $name_err = "Please enter your Full Name";
    } else{
        $name = trim($_POST["name"]);
    }

    if (strpos($name, '<') !== false) {
        $name_err = "STOP TRYING TO BE HECCKERMEN";
        header('location: /images/index.html');
    }

    //Captcha -->

    $captchaUser = filter_var($_POST["captcha"], FILTER_SANITIZE_STRING);

    if(empty($_POST["captcha"])) {
      $captcha_err = "Please enter the captcha.";
    }
    else if($_SESSION['CAPTCHA_CODE'] == $captchaUser){
      $captcha_err = '';
      $captcha = trim($_POST["captcha"]);
    } 
    else {
      $captcha_err = "Captcha is invalid.";
    }
    
    //School -->
    if($_POST["school"] === "1"){
        $school_err = "Please select your school";
    } else{
        $school = trim($_POST["school"]);
    }

    if (strpos($school, '<') !== false) {
        $school_err = "STOP TRYING TO BE HECCKERMEN";
        header('location: /images/index.html');
    }
    //validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a Username.";
    } else{
        //prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // SSet parameters
            $param_username = trim($_POST["username"]);

            //Execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if usernamee alreday exists
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went Wrong. Please try again.";
            }
        
            //Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if (strpos($username, '<') !== false) {
        $username_err = "STOP TRYING TO BE HECCKERMEN";
        header('location: /images/index.html');
    }

    //validate Email Id
    if(empty(trim($_POST["email"]))){
        $email_err = "Email Id is required";
    }
    else{
        $email = trim($_POST["email"]);
    }

    if (strpos($email, '<') !== false) {
        $email_err = "STOP TRYING TO BE HECCKERMEN";
        header('location: /images/index.html');
    }

    // VALIDATE PASSWORD
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters";
    }
    else{
        $password = trim($_POST["password"]);
    }

    // VALIDATE CONFIRM PASSWORD
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords do not match.";
        }
    }


    //check input errors before inserting into database
    if(empty($username_err) && empty($name_err) && empty($school_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($captcha_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (name, school, username, password, email, hintca, proceed) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            //Bind variables to the prepared insert statementt as parameters
            mysqli_stmt_bind_param($stmt, "sssssii", $param_name, $param_school, $param_username, $param_password, $param_email, $param_hintca, $param_proceed);

            //set parameters
            $param_name = $name;
            $param_school = $school;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;
            $param_hintca = 1;
            $param_proceed = 0;


            // Execute the prepared statment
            if(mysqli_stmt_execute($stmt)){
                //redirect to login page
                header("location: login");
            } else{
                echo "Something went wrong. Please try again.";
            }
            
            //Close Statement
            mysqli_stmt_close($stmt);
        }
    }

    //close connection
    mysqli_close($link);
}
?>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<head>

    <title>Register | Crypt@trix 21.0</title>

    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,400italic,500,100italic,700'
        rel='stylesheet' type='text/css'>
    <script src="js/fontawesome.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Dosis|Open+Sans" rel="stylesheet">
    <link href='css/main.css' rel='stylesheet' type='text/css'>
    <link rel="icon" href="images/ordin.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/git/jquery-git.min.js" crossorigin="anonymous">
    </script>

</head>

<body onload="load()">

    <!---  LOADER   --->

    <div class="load" id="load">
        <center>
            <div class="loader">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </center>
    </div>


    <div class="mainBod" id="mainBod">

        <!---  NAVBAR   --->

        <div class="navb">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <a href="index" class="logo-nav"><img src="images/ordin.png"></a>
                    <a class="button" href="https://discord.gg/jCvpEsCwCD" target="_blank">Join the Discord</a>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

        <!--- HOME --->

        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <center>
                    <img src="images/banda-vector.png" class="img-logo">
                </center>
            </div>
            <div class="col-md-4">
                <div class="writen right">
                    <h1>Register</h1>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <input autocomplete="false" required name="name" type="text" placeholder="Full Name" value="<?php echo $name ; ?>"><br>
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>

                        <div class="form-group">
                            <select name="school" value="<?php echo $school ; ?>">
                                <option value="1">Select School</option>
                                <option value="Tagore International School, Vasant Vihar">Tagore International School,
                                    Vasant Vihar</option>
                                <option value="Mount Carmel School">Mount Carmel School</option>
                                <option value="St. Columbas School">St. Columbas School</option>
                                <option value="DPS RK Puram">DPS RK Puram</option>
                                <option value="Birla Vidya Niketan">Birla Vidya Niketan</option>
                                <option value="Chinmaya Vidyalaya">Chinmaya Vidyalaya</option>
                                <option value="Air Force Bal Bharati School">Air Force Bal Bharati School</option>
                                <option value="DPS Sushant Lok">DPS Sushant Lok</option>
                                <option value="The Mother's International School">The Mother's International School
                                </option>
                                <option value="Air Force Golden Jubilee Institute">Air Force Golden Jubilee Institute
                                </option>
                                <option value="Mount St.Mary's School">Mount St.Mary's School</option>
                                <option value="Gyan Bharati School">Gyan Bharati School</option>
                                <option value="Scottish High International School, Gurgaon">Scottish High International School, Gurgaon</option>
                                <option value="Lotus Valley International School, Gurugram">Lotus Valley International School, Gurugram</option>
                                <option value="G.D. GOENKA PUBLIC SCHOOL, VASANT KUNJ">G.D. GOENKA PUBLIC SCHOOL, VASANT KUNJ</option>
                                <option value="Sanskriti School">Sanskriti School</option>
                                <option value="Lotus Valley International School, Noida">Lotus Valley International School, Noida</option>
                                <option value="Tagore International School, EOK">Tagore International School, EOK</option>
                                <option value="Sunbeam School Annapurna">Sunbeam School Annapurna</option>
                                <option value="The Indian School">The Indian School</option>
                                <option value="Delhi Public School Noida">Delhi Public School Noida</option>
                                <option value="Apeejay School Saket">Apeejay School Saket</option>
                                <option value="SUMMER FIELDS SCHOOL">SUMMER FIELDS SCHOOL</option>
                                <option value="Maharaja Agarsain Public School ">Maharaja Agarsain Public School </option>
                                <option value="S. R. D. A. V Public School">S. R. D. A. V Public School</option>
                                <option value="Amity International School, Sector-46, Gurgaon">Amity International School, Sector-46, Gurgaon</option>
                                <option value="THE FOUNDATION SCHOOL">THE FOUNDATION SCHOOL</option>
                                <option value="CHINMAYA VIDYALAYA">CHINMAYA VIDYALAYA</option>
                                <option value="Ryan International School, Vasant Kunj">Ryan International School, Vasant Kunj</option>
                            </select>
                            <span class="help-block"><?php echo $school_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <input autocomplete="false" required name="username" type="text" placeholder="Username" value="<?php echo $username ; ?>"
                                id="username"><br>
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <input autocomplete="false" required name="email" type="email" placeholder="Email" value="<?php echo $email ; ?>"
                                id="email"><br>
                            <span class="help-block"><?php echo $email_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <input autocomplete="false" required placeholder="Password" name="password" type="password"
                                value="<?php echo $password; ?>" id="password"> <br>
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <input autocomplete="false" required placeholder="Confirm Password" name="confirm_password" type="password"
                                value="<?php echo $confirm_password; ?>"><br>
                            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($captcha_err)) ? 'has-error' : ''; ?>">
                            <img src="captcha.php" alt="PHP Captcha">
                            <input autocomplete="false" required id="captcha" placeholder="Enter Captcha Code" name="captcha" type="text">
                            <span class="help-block"><?php echo $captcha_err; ?></span>
                        </div>

                        <p>Already have an account? <a class="blue" href="login">Login.</a></p>

                        <div class="form-group">
                            <input type="submit" name="reg_user" value="Submit" id="submitb">
                        </div>

                    </form>

                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <!---  FOOTER   --->

        <div id="footer">
            <center>
                <div class="footer-text">
                    <a href="https://discord.gg/jCvpEsCwCD" class="page-links discord" target="_blank"><i
                            class="fab fa-discord"></i></a>
                    <a href="https://www.facebook.com/Ordinatrix21.0/" class="page-links facebook" target="_blank"><i
                            class="fab fa-facebook-square"></i></a>
                    <a href="https://github.com/pyrotechclub/" class="page-links github" target="_blank"><i
                            class="fab fa-github"></i></a>
                    <a href="https://www.instagram.com/ordinatrix21.0/" class="page-links instagram" target="_blank"><i
                            class="fab fa-instagram"></i></a>
                    <a href="mailto:cryptatrix@gmail.com" class="page-links email" target="_blank"><i
                            class="fas fa-envelope"></i></a>
                    <div class="footer-copy font-alt">
                        <a href="index">Home</a>
                        |
                        <a href="leaderboard">Leaderboard</a>
                        |
                        <a href="login">Login</a>
                        |
                        <a href="register">Register</a>
                        |
                        <a href="rules">Rules</a>
                        |
                        <a href="play">Play</a>
                        |
                        <a href="shop">Shop</a>
                    </div>
                    <div class="footer-copy font-alt">
                        © Pyrotech Club 2021
                    </div>
                </div>
            </center>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-storage.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-analytics.js"></script>
    <script src="js/init.js"></script>
    <script src="js/index.js"></script>
    <script src="js/register.js"></script>
</body>

</html>