<?php

session_start();


require_once "config.php";


?>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<head>

    <title>Leaderboard | Crypt@trix 21.0</title>

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
            <div class="col-md-8">
                <div class="writen center">
                    <h2>Leaderboard </h2>

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">

                            <button class="nav-link button active" id="schools-tab" data-bs-toggle="tab"
                                data-bs-target="#schools" type="button" role="tab" aria-controls="schools"
                                aria-selected="true">Schools</button>

                        </li>
                        <li class="nav-item" role="presentation">

                            <button class="nav-link button" id="students-tab" data-bs-toggle="tab"
                                data-bs-target="#students" type="button" role="tab" aria-controls="students"
                                aria-selected="false">Students</button>

                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="schools" role="tabpanel"
                            aria-labelledby="schools-tab">
                            <div class="table-responsive">

                                <?php 
                                $result = mysqli_query($link,"SELECT school, lvl, points, timest, MAX(points) AS school_score FROM users GROUP BY school ORDER BY school_score DESC, timest ASC");
                                
                                
                                echo "
                                <table class='table leaderboard table-borderless'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Rank</th>
                                            <th scope='col'>School Name</th>
                                            <th scope='col'>Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope='row'>0</td>
                                            <td>Pyrotech</td>
                                            <td>&infin;</td>
                                        </tr> "; 
                                    $rowNumber = 0;
                                    while($row = mysqli_fetch_array($result)){
                                        $rowNumber++;
                                    echo "<tr>";
                                        echo "<td scope='row'>" . $rowNumber . "</td>";
                                        echo "<td>" . $row['school'] . "</td>";
                                        echo "<td>". $row['school_score'] . "</td>";
                                    echo "</tr>";
                                } 
                                echo "
                                    </tbody>
                                </table>
                                ";
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">

                            <div class="table-responsive">

                                <?php 
                                $result = mysqli_query($link,"SELECT username, lvl, points, timest FROM users ORDER BY points DESC, timest ASC");
                                
                                
                                echo "
                                <table class='table leaderboard table-borderless'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Rank</th>
                                            <th scope='col'>Username</th>
                                            <th scope='col'>Level</th>
                                            <th scope='col'>Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope='row'>0</td>
                                            <td>Pyrotech</td>
                                            <td>69420</td>
                                            <td>&infin;</td>
                                        </tr> "; 
                                    $rowNumber = 0;
                                    while($row = mysqli_fetch_array($result)){
                                        $rowNumber++;
                                    echo "<tr>";
                                        echo "<td scope='row'>" . $rowNumber . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>". $row['lvl'] . "</td>";
                                        echo "<td>". $row['points'] . "</td>";
                                    echo "</tr>";
                                } 
                                echo "
                                    </tbody>
                                </table>
                                ";
                                ?>
                            </div>
                        </div>
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

    <script src="js/index.js"></script>
</body>

</html>