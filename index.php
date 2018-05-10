<?php
require "scripts/db.php"; ?>
<!doctype html>
<html lang="ru">
<head>
    <title>Minercalc</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">

    <!-- Bootstrap CSS -->
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/theme.bootstrap_4.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.6/css/highcharts.css" />-->
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.6/js/highstock.js"></script>-->
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

<div class="container-fluid">
    <div class="row align-items-center" id="header">
        <div class="col">
            <p class="text-center text-white" id="headerText">Minercalc</p>
        </div>
    </div>
</div>
<div class="container-fluid" id="content">
    <div class="form-group" id="devices">
        <div class="row">
            <div class="col">
                <h2 class="text-center">Your Hardware:</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-3">
                <h4 class="text-center">Videocards:</h4>
                <div class="form-row">
                    <div class="col-xl-2">
                        <input type="number" class="form-control qty" placeholder="Qty" id="qtyVideocards" min="1"
                               oninput="validity.valid||(value='');">
                    </div>
                    <div class="col-xl-10">
                        <select class="form-control" id="gpu_select">
                            <option disabled selected>Choose model...</option>
                            <? $gpu = $dbh->query("SELECT name FROM GPU")->fetchAll(PDO::FETCH_COLUMN);
                            foreach ($gpu as $g) {
                                echo '<option>' . $g . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <h4 class="text-center">ASICs:</h4>
                <div class="form-row">
                    <div class="col-xl-2">
                        <input type="number" class="form-control qty" placeholder="Qty" id="qtyASICs" min="1"
                               oninput="validity.valid||(value='');">
                    </div>
                    <div class="col-xl-10">
                        <select class="form-control" id="asic_select">
                            <option disabled selected>Choose model...</option>
                            <? $asic = $dbh->query("SELECT name FROM ASIC")->fetchAll(PDO::FETCH_COLUMN);
                            foreach ($asic as $a) {
                                echo '<option>' . $a . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-xl-4">
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <h2 data-toggle="collapse" data-target="#algos" aria-expanded="false" aria-controls="algos" class="showingData">
            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Show Data
        </h2>
    </div>
    <form action="" id="hashes" method="post">
        <div class="form-group col-8 text-center mx-auto collapse" id="algos">
            <div class="row">
                <div class="col">
                    <h3 class="text-center">Algos:</h3>
                </div>
            </div>
            <div class="row">
                <? $css_grid = 'col-6 col-sm-4 col-md-3 col-xl-2';
                include "scripts/generate_algos.php";
                ?>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-xl-4">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h4 class="text-center">Options: Difficult by
                    <select class="custom-select" name="interval_diff" onchange="inputDiff()">
                        <option selected>current</option>
                        <option>24h</option>
                        <option>week</option>
                        <option>month</option>
                    </select>
                    , Profit in
                    <select class="custom-select" name="interval_profit" onchange="inputDiff()">
                        <option selected value="1">24h</option>
                        <option value="7">week</option>
                        <option value="30">month</option>
                        <option value="365">year</option>
                    </select>
                </h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto text-center">
                <button type="button" class="btn btn-primary btn-lg btn-style" id="calc"><i
                            class="fa fa-spinner fa-pulse fa-lg fa-fw" id="spinner" aria-hidden="true"></i>Calc It!
                </button>
            </div>
            <div class="col-auto text-center">
                <button type="button" class="btn btn-primary btn-lg btn-style">Save</button>
            </div>
        </div>

    </form>
</div>
<div id="calculation">
</div>

<div class="container-fluid">
    <div class="row justify-content-center" id="footer">
        <div class="col-xl-2 text-center">
            <p class="size32">Minercalc.com</p>
        </div>
        <div class="col-xl-2 text-center">
            <p class="size32">My Contacts:</p>
            <p class="size24"><i class="fa fa-envelope-o" aria-hidden="true"></i> legat88@gmail.com</p>
            <p class="size24"><i class="fa fa-vk" aria-hidden="true"></i> vk.com/legat88</p>
            <p class="size24"><i class="fa fa-twitter" aria-hidden="true"></i> @Legat88</p>
        </div>
        <div class="col-xl-4 text-center">
            <p class="size32">Donate:</p>
            <p class="size24">BTC: 1CD75dQy3X7YfCXdHuVReKHUCLWBudNCFY</p>
            <p class="size24">LTC: LUPZRB7pohLZNzYyGevmKXnBvT9UpmAH78</p>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/jQueryRotate.js"></script>
<script src="https://use.fontawesome.com/bc14f147cb.js"></script>
<script src="js/urls.js"></script>
<script src="js/main.js"></script>
<!--<script src="https://cdnjs.com/libraries/jquery.tablesorter.js"></script>-->
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.metadata.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.widgets.js"></script>
</body>
</html>