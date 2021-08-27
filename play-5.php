<?php
session_start();

if (!isset($_SESSION['username'])) { 
    $_SESSION['msg'] = "You have to log in first"; 
    header('location: login'); 
} 

// settinng variables
require_once "config.php";
clearstatcache();
$loggedInUsername = $_SESSION['username'];
$id = $_SESSION['id'];
$points_lvl = 200;
$points_dare = 100;
$lvlup = 1;
$answer_err = "";

//getting htmlno
$result = mysqli_query($link, "SELECT htmlno FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$htmlno = $result[0]??null;
if($htmlno == 0){
    header('location: play');
}
if($htmlno == 1){
    header('location: play-1');
}
if($htmlno == 2){
    header('location: play-2');
}
if($htmlno == 3){
    header('location: play-3');
}
if($htmlno == 4){
    header('location: play-4');
}
if($htmlno !== 5){
    header('404.html');
}

//getting user lvl
$result = mysqli_query($link, "SELECT lvl FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$level = $result[0]??null;

//getting user theme
$result = mysqli_query($link, "SELECT themeno FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$themeno = $result[0]??null;


?>

<html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<head>

    <title>Play | Crypt@trix 21.0</title>

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
    <script src="https://code.jquery.com/git/jquery-git.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>
    <script src="js/index.js"></script>

</head>

<body onload="load()">

    <!---  LOADER   -->

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

        <?php if ($themeno == 1): ?>
        <link href='css/1.css' rel='stylesheet' type='text/css'>

        <audio id="ambience" autoplay loop>
            <source src="audio/scp-ambience.mp3" type="audio/mpeg">
        </audio>
        <?php endif; ?>
        <?php if ($themeno == 2): ?>
        <link href='css/2.css' rel='stylesheet' type='text/css'>

        <audio id="ambience" autoplay loop>
            <source src="audio/fnaf-ambience.mp3" type="audio/mpeg">
        </audio>

        <audio id="freddy-jmp">
            <source src="audio/freddy.mp3" type="audio/mpeg">
        </audio>

        <audio id="foxy-jmp">
            <source src="audio/foxy.mp3" type="audio/mpeg">
        </audio>

        <audio id="chica-jmp">
            <source src="audio/chica.mp3" type="audio/mpeg">
        </audio>

        <audio id="bonnie-jmp">
            <source src="audio/bonnie.mp3" type="audio/mpeg">
        </audio>
        <?php endif; ?>
        <?php if ($themeno == 3): ?>
        <link href='css/3.css' rel='stylesheet' type='text/css'>

        <audio id="ambience" autoplay loop>
            <source src="audio/slender-ambience.mp3" type="audio/mpeg">
        </audio>

        <script src="js/slender-bg.js"></script>
        <?php endif; ?>
        <?php if ($themeno == 4): ?>
        <link href='css/4.css' rel='stylesheet' type='text/css'>

        <audio id="ambience" autoplay loop>
            <source src="audio/under-ambience.mp3" type="audio/mpeg">
        </audio>
        <?php endif; ?>
        <?php if ($themeno == 5): ?>
        <link href='css/5.css' rel='stylesheet' type='text/css'>

        <audio id="ambience" autoplay loop>
            <source src="audio/petscop-ambience.mp3" type="audio/mpeg">
        </audio>
        <?php endif; ?>
        <?php if ($themeno == 6): ?>
        <link href='css/6.css' rel='stylesheet' type='text/css'>
        <?php endif; ?>
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

        <?php if ($level == 5): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 5</h2>
                    <p>Maybe you should stalk BEN</p>
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "pestilence")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + $points_lvl, htmlno = 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-1');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>

        <?php if ($level == 10): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 10</h2>
                    <p>
                        <img src="images/dollsteg.jpg" class="question-image">
                    </p>
                    <!-- futureboy.us/stegano -->
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "bladeoftheruinedking")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + $points_lvl, htmlno = 1, themeno = themeno + 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: lvlup');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>

        <?php if ($level == 15): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 15</h2>
                    <p>41 33219706 392806 55020932 43182322 1897 13419614601655 0502171496029717 0660855514 274820
                        48210239 271234 146026360516393908 1536414817 40 26402496 6005 27 24282360399455381897 55143196
                        2945 2618100255412336</p>
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "adrianholmes")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + $points_lvl, htmlno = 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-1');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>


        <?php if ($level == 20): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 20</h2>
                    <p>
                        <audio controls>
                            <source src="audio/c-b.mp3" type="audio/mpeg">
                        </audio>
                    </p>
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "moltenfreddy")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + 200, htmlno = 1, themeno = themeno + 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: lvlup');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>

        <?php if ($level == 25): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 25</h2>
                    <p>29 Sept 2012 17 Sept 2010 28 Feb 2016 20 May 2017</p>
                    <!-- VHJpYmVUd2VsdmUgIEZpcnN0IGxldHRlcg== -->
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "jeff")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + $points_lvl, htmlno = 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-1');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>



        <?php if ($level == 30): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 30</h2>
                    <p>HappyPasta</p>
                    <!-- Splendy alias -->
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "neilcicierega")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + 200, htmlno = 1, themeno = themeno + 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: lvlup');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>

        <?php if ($level == 35): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 35</h2>
                    <p><button id="clickme" class="btn btn-primary" onclick="console.log('https%3A%2F%2Fimgur.com%2Fa%2FMz7y2kd')">CLICKME</button></p>
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "hyperdeath")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + $points_lvl, htmlno = 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-1');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>

        <?php if ($level == 40): ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 40</h2>
                    <p>eeeeeeeeeepaeaeeeaeeeeeeeaeeeeeeeeeeccccisaaaaeeeejeeeeeeeeeeeejjiiiijeeejciiiiiiiiiiiijiiiiiiiiiiijjaiiijiiiiiiiiiiiiiiijeeeeeeeeeeeeeeeeeejejiiiiiiiiiiiiiiijiiijeeeeeeejeeeeejcijaiiiiiiiiiiijeeeeeeeeeeeejiijcejeeeeeeeeeejaeeeeeejciiiiiiijaiiiiiiiiiiiiiiiiijeeeeeeeeeeejceeeeeeeeeeeeeeeeeeeeeejaeeeeeeejceeeeeeeeeeeeeeeeeej</p>
                    <?php
    //Answer check -->
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $answer = "";

        if (empty($_POST["answer"]))
        {
            $answer_err = "Please enter an answer";
        }
        else
        {
            $answer = trim($_POST["answer"]);
        }

        if ($answer == "thefallenhuman")
        {
            $sql = "UPDATE users SET lvl = lvl + $lvlup , points= points + 200, htmlno = 1, themeno = themeno + 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: lvlup');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="answer" placeholder="Answer" required autofocus autocomplete="false"
                                    name="answer" type="text"><br>
                                <span class="red"><?php echo $answer_err ?><br></span>
                                <input id="submitb" type="submit" value="Submit">
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php endif; ?>
        
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
                        <a href="shop">Shop</a>
                        |
                        <a href="play">Play</a>
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
    <script src="js/logs.js"></script>


    <?php if ($themeno == 2): ?>

    <script src="js/scare.js"></script>
    <script src="js/fnaf-scare.js"></script>

    <?php endif;?>

</body>

</html>