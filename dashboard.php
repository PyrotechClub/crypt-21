<?php
session_start();

if (!isset($_SESSION['username'])) { 
    $_SESSION['msg'] = "You have to log in first"; 
    header('location: login'); 
} 

//setting variables
require_once "config.php";
$id = $_SESSION['id'];

//getting user proceed value
$result = mysqli_query($link, "SELECT proceed FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$proceed = $result[0]??null;
//checking if hint card is active
$result = mysqli_query($link, "SELECT hintca FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$hintca = $result[0]??null;
//getting user lvl
$result = mysqli_query($link, "SELECT lvl FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$level = $result[0]??null;
//getting user school
$result = mysqli_query($link, "SELECT school FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$school = $result[0]??null;
//getting user points
$result = mysqli_query($link, "SELECT points FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$points = $result[0]??null;
?>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<head>

    <title>Dashboard | Crypt@trix 21.0</title>

    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,400italic,500,100italic,700'
        rel='stylesheet' type='text/css'>
    <script src="js/fontawesome.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Dosis|Open+Sans" rel="stylesheet">
    <link href='css/main.css' rel='stylesheet' type='text/css'>
    <link href='css/dash.css' rel='stylesheet' type='text/css'>
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
                <div class="writen left">
                    <h3>Greetings <?php echo $_SESSION['username']; ?><a href="logout.php" class="logout"><i
                                class="fal fa-sign-out"></i></a></h3>
                    <p>Welcome to Crypt@trix 21.0</p>
                    <p><b>Your School: </b><span><?php echo $school ?></span></p>
                    <p><b>Your Level: </b><span><?php echo $level ?></span></p>
                    <p><b>Your Points: </b><span><?php echo $points ?></span></p>
                    <?php if($hintca != 0) :?>
                    <p class="inv"><b>Inventory:</b><span> 1x Hint Card</span></p>
                    <?php endif ?>
                    <?php if($hintca == 0) :?>
                    <p class="inv"><b>Inventory:</b><span> --</span></p>
                    <?php endif ?>
                    <p class="time-left">
                        <b>The Hunt Ends In:</b><br>
                        <span id="days"></span> :
                        <span id="hours"></span> :
                        <span id="mins"></span> :
                        <span id="secs"></span>
                    </p>
                    <br>
                    <a href="shop" class="button ">Shop</a>
                    <?php if($proceed == 0) :?>
                    <a class="button" href="warning">Play</a>
                    <?php endif; ?>
                    <?php if($proceed == 1) :?>
                    <a class="button" href="play">Play</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4">
                <center>
                    <img src="images/banda-vector.png" class="img-logo">
                </center>
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
                        <?php if($proceed == 0) :?>
                        <a href="warning">Play</a>
                        <?php endif; ?>
                        <?php if($proceed == 1) :?>
                        <a href="play">Play</a>
                        <?php endif; ?>
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
    <script src="js/index.js"></script>
    <script src="js/count.js"></script>
</body>

</html>