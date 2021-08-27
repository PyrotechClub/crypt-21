<?php 
session_start();

if (!isset($_SESSION['username']))
{
    $_SESSION['msg'] = "You have to log in first";
    header('location: login');
}

//setting variables 
require_once "config.php";
$loggedInUsername = $_SESSION['username'];
$id = $_SESSION['id'];

//getting user theme
$result = mysqli_query($link, "SELECT themeno FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$themeno = $result[0]??null;

?>

<html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<head>

    <title>Crypt@trix 21.0</title>

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

<body style="overflow: hidden;">


    <div id="lvlup">
        <center>
            <a href="play.php" class="proceed-vid">

                <?php if($themeno == 1) : ?>
                    <video autoplay nocontrols loop>
                        <source src="images/scp-lvlup.mp4" type="video/mp4">
                    </video>
                <?php endif; ?>

                <?php if($themeno == 2) : ?>
                    <video autoplay nocontrols loop>
                        <source src="images/fnaf-lvlup.mp4" type="video/mp4">
                    </video>
                <?php endif; ?>

                <?php if($themeno == 3) : ?>
                    <video autoplay nocontrols loop>
                        <source src="images/slender-lvlup.mp4" type="video/mp4">
                    </video>
                <?php endif; ?>

                <?php if($themeno == 4) : ?>
                    <video autoplay nocontrols loop>
                        <source src="images/undertale-lvlup.mp4" type="video/mp4">
                    </video>
                <?php endif; ?>

                <?php if($themeno == 5) : ?>
                    <video autoplay nocontrols loop style="transform: translateY(-100px); -webkit-transform: translateY(-100px); height: 120vh">
                        <source src="images/petscop-lvlup.mp4" type="video/mp4">
                    </video>
                <?php endif; ?>

            </a>
        </center>
    </div>


    <script src="js/index.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-storage.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-analytics.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="js/init.js"></script>
</body>

</html>