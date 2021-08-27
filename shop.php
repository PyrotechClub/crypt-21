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
$lvlup = 1;
$skip_points = 350;

//getting user proceed value
$result = mysqli_query($link, "SELECT proceed FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$proceed = $result[0]??null;

//checking if hint card is active
$result = mysqli_query($link, "SELECT hintca FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$hintca = $result[0]??null;

//checking point balance
$result = mysqli_query($link, "SELECT points FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$points = $result[0]??null;

//getting user theme
$result = mysqli_query($link, "SELECT themeno FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$themeno = $result[0]??null;

//getting user level
$result = mysqli_query($link, "SELECT lvl FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$level = $result[0]??null;

//checking htmlno value
$result = mysqli_query($link, "SELECT htmlno FROM users WHERE id =$id");
$result = mysqli_fetch_row($result);
$htmlno = $result[0]??null;

// buy hint card function -->
    if(array_key_exists('hintt',$_POST)) {
    $sql = "UPDATE users SET hintca = 1, points= $points - 100 WHERE id=$id";
    // Prepare statement
    $stmt = $link->prepare($sql);
    // execute the query
    $stmt->execute();
    }

// Skip Level Function -->
    if($_POST && isset($_POST['ghk'])) {
        if($htmlno < 5){
            $sql = "UPDATE users SET lvl= lvl + 1 , htmlno = htmlno + 1, points= points- 350 WHERE id = $id";
            // Prepare statement
            $stmt = $link->prepare($sql);
            // execute the query
            $stmt->execute();

            header ('header-location: play');
        } 
        elseif($htmlno == 5 && $level%10 == 0){
                $sql = "UPDATE users SET lvl= lvl + 1 , points= points - 350, htmlno = 1, themeno = themeno + 1 WHERE id=$id";
                // Prepare statement
                $stmt = $link->prepare($sql);
                // execute the query
                $stmt->execute();

                header ('header-location: play');
        } 
        elseif($htmlno == 5 && $level%10 != 0){
                $sql = "UPDATE users SET lvl= lvl + 1 , points= points - 350, htmlno = 1 WHERE id=$id";
                // Prepare statement
                $stmt = $link->prepare($sql);
                // execute the query
                $stmt->execute();

                header ('header-location: play');
        }
} 
?>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<head>

    <title>Shop | Crypt@trix 21.0</title>

    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,400italic,500,100italic,700'
        rel='stylesheet' type='text/css'>
    <script src="js/fontawesome.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Dosis|Open+Sans" rel="stylesheet">
    <link href='css/main.css' rel='stylesheet' type='text/css'>
    <link href='css/shop.css' rel='stylesheet' type='text/css'>
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

    <!---  LOADER  -->

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

        <audio autoplay loop>
            <source src="audio/shop-ambience.mp3" type="audio/mpeg">
        </audio>

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
            <div class="col-md-8">

                <div class="writen center">
                    <h3>Welcome to the shop</h3>
                    <p>You can buy a hint card or a skip card here to aid you in your endeavours.</p>

                    <?php if($hintca != 0) :?>
                    <p class="inv"><b>Inventory:</b><span> 1x Hint Card</span></p>
                    <?php endif ?>
                    <div class="row">

                        <?php if($themeno == 0) : ?>

                        <div class="col-md-1"></div>
                        <!--HINT CARD-->
                        <?php if($hintca == 0 and $points >= 100) : ?>
                        <div class="col-md-4 center">
                            <div class="cards">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/hint-card-1.png">
                                    </div>
                                    <div class="card-back">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <form method="post" action="hint.php">
                                            <button type="button" class="btn btn-primary button"
                                                onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();"
                                                type="submit">
                                                Buy it
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($hintca != 0) : ?>
                        <div class="col-md-4 center">
                            <div class="cards">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/hint-card-1.png">
                                    </div>
                                    <div class="card-back invalid">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>You Already Have a Hint Card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($points < 100 and $hintca == 0 ) : ?>
                        <div class="col-md-4 center">
                            <div class="cards">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/hint-card-1.png">
                                    </div>
                                    <div class="card-back invalid">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2"></div>

                        <!--SKIP CARD-->
                        <?php if($points >= 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/skip-card-1.png">
                                    </div>
                                    <div class="card-back">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <button class="button" data-toggle="modal" id="skip-trigger"
                                            data-target="#yeet">Buy it</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php if($points < 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/skip-card-1.png">
                                    </div>
                                    <div class="card-back invalid">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <button class="button" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="col-md-1"></div>

                        <?php endif ?>
                        <?php if($themeno == 1) : ?>

                        <div class="col-md-1"></div>
                        <!--HINT CARD-->
                        <?php if($hintca == 0 and $points >= 100) : ?>
                        <div class="col-md-4 center">
                            <div class="cards scp">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/scp-hint-card.png">
                                    </div>
                                    <div class="card-back scp-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <form method="post" action="hint.php">
                                            <button type="button" class="btn btn-primary button"
                                                onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();"
                                                type="submit">
                                                Buy it
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($hintca != 0) : ?>
                        <div class="col-md-4 center">
                            <div class="cards scp">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/scp-hint-card.png">
                                    </div>
                                    <div class="card-back invalid scp-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>You Already Have a Hint Card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($points < 100 and $hintca == 0 ) : ?>
                        <div class="col-md-4 center">
                            <div class="cards scp">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/scp-hint-card.png">
                                    </div>
                                    <div class="card-back invalid scp-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2"></div>

                        <!--SKIP CARD-->
                        <?php if($points >= 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards scp">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/scp-skip-card.png">
                                    </div>
                                    <div class="card-back scp-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <form method="post">
                                            <button name="ghk" class="button" type="submit">Buy It</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php if($points < 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards scp">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/scp-skip-card.png">
                                    </div>
                                    <div class="card-back invalid scp-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <button class="button" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="col-md-1"></div>

                        <?php endif ?>
                        <?php if($themeno == 2) : ?>

                        <div class="col-md-1"></div>
                        <!--HINT CARD-->
                        <?php if($hintca == 0 and $points >= 100) : ?>
                        <div class="col-md-4 center">
                            <div class="cards fnaf">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/fnaf-hint-card.png">
                                    </div>
                                    <div class="card-back fnaf-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <form method="post" action="hint.php">
                                            <button type="button" class="btn btn-primary button"
                                                onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();"
                                                type="submit">
                                                Buy it
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($hintca != 0) : ?>
                        <div class="col-md-4 center">
                            <div class="cards fnaf">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/fnaf-hint-card.png">
                                    </div>
                                    <div class="card-back invalid fnaf-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>You Already Have a Hint Card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($points < 100 and $hintca == 0 ) : ?>
                        <div class="col-md-4 center">
                            <div class="cards fnaf">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/fnaf-hint-card.png">
                                    </div>
                                    <div class="card-back invalid fnaf-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2"></div>

                        <!--SKIP CARD-->
                        <?php if($points >= 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards fnaf">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/fnaf-skip-card.png">
                                    </div>
                                    <div class="card-back fnaf-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <form method="post">
                                            <button name="ghk" class="button" type="submit">Buy It</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php if($points < 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards fnaf">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/fnaf-skip-card.png">
                                    </div>
                                    <div class="card-back invalid fnaf-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <button class="button" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="col-md-1"></div>

                        <?php endif ?>
                        <?php if($themeno == 3) : ?>

                        <div class="col-md-1"></div>
                        <!--HINT CARD-->
                        <?php if($hintca == 0 and $points >= 100) : ?>
                        <div class="col-md-4 center">
                            <div class="cards slenderman">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/slenderman-hint-card.png">
                                    </div>
                                    <div class="card-back slenderman-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <form method="post" action="hint.php">
                                            <button type="button" class="btn btn-primary button"
                                                onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();"
                                                type="submit">
                                                Buy it
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($hintca != 0) : ?>
                        <div class="col-md-4 center">
                            <div class="cards slenderman">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/slenderman-hint-card.png">
                                    </div>
                                    <div class="card-back invalid slenderman-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>You Already Have a Hint Card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($points < 100 and $hintca == 0 ) : ?>
                        <div class="col-md-4 center">
                            <div class="cards slenderman">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/slenderman-hint-card.png">
                                    </div>
                                    <div class="card-back invalid slenderman-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2"></div>

                        <!--SKIP CARD-->
                        <?php if($points >= 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards slenderman">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/slenderman-skip-card.png">
                                    </div>
                                    <div class="card-back slenderman-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <form method="post">
                                            <button name="ghk" class="button" type="submit">Buy It</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php if($points < 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards slenderman">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/slenderman-skip-card.png">
                                    </div>
                                    <div class="card-back invalid slenderman-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <button class="button" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="col-md-1"></div>

                        <?php endif ?>
                        <?php if($themeno == 4) : ?>

                        <div class="col-md-1"></div>
                        <!--HINT CARD-->
                        <?php if($hintca == 0 and $points >= 100) : ?>
                        <div class="col-md-4 center">
                            <div class="cards undertale">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/undertale-hint-card.png">
                                    </div>
                                    <div class="card-back undertale-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <form method="post" action="hint.php">
                                            <button type="button" class="btn btn-primary button"
                                                onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();"
                                                type="submit">
                                                Buy it
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($hintca != 0) : ?>
                        <div class="col-md-4 center">
                            <div class="cards undertale">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/undertale-hint-card.png">
                                    </div>
                                    <div class="card-back invalid undertale-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>You Already Have a Hint Card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($points < 100 and $hintca == 0 ) : ?>
                        <div class="col-md-4 center">
                            <div class="cards undertale">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/undertale-hint-card.png">
                                    </div>
                                    <div class="card-back invalid undertale-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2"></div>

                        <!--SKIP CARD-->
                        <?php if($points >= 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards undertale">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/undertale-skip-card.png">
                                    </div>
                                    <div class="card-back undertale-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <form method="post">
                                            <button name="ghk" class="button" type="submit">Buy It</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php if($points < 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards undertale">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/undertale-skip-card.png">
                                    </div>
                                    <div class="card-back invalid undertale-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <button class="button" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="col-md-1"></div>

                        <?php endif ?>
                        <?php if($themeno >= 5) : ?>

                        <div class="col-md-1"></div>
                        <!--HINT CARD-->
                        <?php if($hintca == 0 and $points >= 100) : ?>
                        <div class="col-md-4 center">
                            <div class="cards petscop">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/petscop-hint-card.png">
                                    </div>
                                    <div class="card-back petscop-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <form method="post" action="hint.php">
                                            <button type="button" class="btn btn-primary button"
                                                onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();"
                                                type="submit">
                                                Buy it
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($hintca != 0) : ?>
                        <div class="col-md-4 center">
                            <div class="cards petscop">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/petscop-hint-card.png">
                                    </div>
                                    <div class="card-back invalid petscop-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>You Already Have a Hint Card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($points < 100 and $hintca == 0 ) : ?>
                        <div class="col-md-4 center">
                            <div class="cards petscop">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/petscop-hint-card.png">
                                    </div>
                                    <div class="card-back invalid petscop-bck">
                                        <h4>Buy a Hint Card</h4>
                                        <p><b>Price-</b> 100 points</p>
                                        <button class="button" data-toggle="modal" id="hint-trigger"
                                            data-target="#hints" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-2"></div>

                        <!--SKIP CARD-->
                        <?php if($points >= 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards petscop">
                                <div class="card-thing">
                                    <div class="card-front">
                                        <img src="images/petscop-skip-card.png">
                                    </div>
                                    <div class="card-back petscop-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <form method="post">
                                            <button name="ghk" class="button" type="submit">Buy It</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php if($points < 350) : ?>
                        <div class="col-md-4 center">
                            <div class="cards petscop">
                                <div class="card-thing">
                                    <div class="card-front invalid">
                                        <img src="images/petscop-skip-card.png">
                                    </div>
                                    <div class="card-back invalid petscop-bck">
                                        <h4>Buy a Skip Card</h4>
                                        <p><b>Price-</b> 350 points</p>
                                        <button class="button" disabled>Insufficiant Funds:(</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="col-md-1"></div>

                        <?php endif ?>

                    </div>
                </div>

            </div>
            <div class="col-md-2"></div>
        </div>
        <br>
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