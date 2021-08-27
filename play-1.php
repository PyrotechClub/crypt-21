<?php
session_start();

if (!isset($_SESSION['username']))
{
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
if($htmlno == 2){
    header('location: play-2');
}
if($htmlno == 3){
    header('location: play-3');
}
if($htmlno == 4){
    header('location: play-4');
}
if($htmlno == 5){
    header('location: play-5');
}
if($htmlno !== 1){
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


        <?php if ($themeno < 6): ?>

        <!--- HOME --->
        <?php if ($level == 1): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 1</h2>
                    <p><img src="images/TYUBPU.png" class="question-image"></p>
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

        if ($answer == 'shyguy')
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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
        <?php
endif; ?>
        <?php if ($level == 6): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 6</h2>
                    <p>I guess god cant see there</p>
                    <!-- 1 -->
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

        if ($answer == "spikebrennan")
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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
        <?php
endif; ?>

        <?php if ($level == 11): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 11</h2>

                    <p><img src="images/human-form.png" class="question-image"></p>
                    <!-- https://imgur.com/OlaOTPw -->
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

        if ($answer == "todayisgonnabeagreatday")
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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


        <?php if ($level == 16): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 16</h2>

                    <p>
                        <embed src="images/video.mp4">
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

        if ($answer == "voughtinternational")
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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

        <?php if ($level == 21): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 21</h2>

                    <p>maybe checkout the shop ;)</p>
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

        if ($answer == "noah")
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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

        <?php if ($level == 26): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 26</h2>

                    <p>507 67 16</p>
                    <!-- welcome, ZIP IT -->
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

        if ($answer == "railroadspike")
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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

        <?php if ($level == 31): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 31</h2>

                    <p>Hey man isn't it poetic?</p>
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

        if ($answer == "menthon")
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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

        <?php if ($level == 36): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 36</h2>

                    <p><embed src="cn.rar"></p>
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

        if ($answer == "dakota")
        {
            $sql = "UPDATE users SET lvl= lvl + $lvlup , points= points + $points_lvl, htmlno = 2 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: play-2');
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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

        <?php if ($level == 41): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Level 41</h2>

                    <p><img src="images/Last.png" class="question-image"></p>
                    <!-- BACKLINK OR DIG DEEPER -->
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

        if ($answer == "tiara")
        {
            $sql = "UPDATE users SET  points= points + 200, htmlno = 1, themeno = themeno + 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: end-a');
        }
        elseif ($answer == "rebirth")
        {
            $sql = "UPDATE users SET points= points + 200, htmlno = 1, themeno = themeno + 1 WHERE id=$id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header('location: end-e');
        }
        else
        {
            $answer_err = "Wrong Answer! Please try again.";
        }
    }
?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row question">
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

        <?php endif; ?>

        <?php if ($themeno==6): ?>
        <div class="row home">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="writen center">
                    <img src="images/bruh1.png" class="img-logo">
                    <h2>Crypt<span class="at">@</span>trix 21.0</h2>
                    <hr class="section-hr">
                    <h4>You have finished the hunt</h4>
                    <h5>ggwp</h5>
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