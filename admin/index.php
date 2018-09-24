<?php
require "../scripts/db.php"; ?>
<!doctype html>
<html lang="ru">
<head>
    <title>Minercalc</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/main.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/theme.bootstrap_4.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="mask-icon" href="../safari-pinned-tab.svg" color="#5bbad5">
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
    <?php include "operations_db.php"; ?>
    <br>
    <div class="row justify-content-center">
        <div class="col-auto text-center">
            <button class="btn btn-style" type="button" data-toggle="collapse" data-target="#logs" aria-expanded="false"
                    aria-controls="logs">
                Open logs
            </button>
            <button class="btn btn-style" type="button" id="clearLogs">
                Clear logs
            </button>

        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="collapse col-auto text-left" id="logs">
            <div class="card card-body">
                <? $messages = $dbh->query("SELECT datetime, message FROM logs ORDER BY datetime DESC");
                if ($messages->rowCount() > 0) {
                    while ($message = $messages->fetch(PDO::FETCH_LAZY)) {
                        echo $message['datetime'] . ' --- ' . $message['message'] . "<br>";
                    }
                } else {
                    echo 'No API Errors yet';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="form-group" id="devices">
        <div class="row">
            <div class="col">
                <h2 class="text-center">Your Hardware:</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-5 col-lg-4 col-xl-3">
                <h4 class="text-center">Videocards:</h4>
                <div class="form-row justify-content-center">
                    <div class="col-2 col-md-3 col-lg-2">
                        <input type="number" class="form-control qty" placeholder="Qty" id="qtyVideocards" min="1"
                               oninput="validity.valid||(value='');">
                        <i class="fa fa-spinner fa-pulse fa-lg fa-fw" id="spinner_gpu" aria-hidden="true"></i>
                    </div>
                    <div class="col-10 col-md-9 col-lg-10">
                        <select class="form-control" id="gpu_select">
                            <option disabled selected value="0">Choose model...</option>
                            <? $gpu = $dbh->query("SELECT name FROM GPU ORDER BY name ASC")->fetchAll(PDO::FETCH_COLUMN);
                            foreach ($gpu as $g) {
                                echo '<option>' . $g . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-md-5 col-lg-4 col-xl-3">
                <h4 class="text-center">ASICs:</h4>
                <div class="form-row justify-content-center">
                    <div class="col-2 col-md-3 col-lg-2">
                        <input type="number" class="form-control qty" placeholder="Qty" id="qtyASICs" min="1"
                               oninput="validity.valid||(value='');">
                        <i class="fa fa-spinner fa-pulse fa-lg fa-fw" id="spinner_asic" aria-hidden="true"></i>
                    </div>
                    <div class="col-10 col-md-9 col-lg-10">
                        <select class="form-control" id="asic_select">
                            <option disabled selected value="0">Choose model...</option>
                            <? $asic = $dbh->query("SELECT name FROM ASIC ORDER BY name ASC")->fetchAll(PDO::FETCH_COLUMN);
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
        <div class="form-group col-xl-8 col-md-10 text-center mx-auto collapse" id="algos">
            <div class="row">
                <div class="col">
                    <h3 class="text-center">Algos:</h3>
                </div>
            </div>
            <div class="row">
                <? $css_grid = 'col-6 col-sm-4 col-md-3 col-xl-2';
                include "../scripts/generate_algos.php";
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
                <h4 class="text-center" id="options">Options:
                    <div class="row justify-content-center">
                        <div class="col col-sm-8 col-md-6 col-xl-4">
                            <div class="row justify-content-center">
                                <div class="col-6 col-xl-6">
                                    Difficulty by
                                </div>
                                <div class="col-6 col-xl-6">
                                    Profit in
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6 col-xl-6">
                                    <select class="custom-select" name="interval_diff" onchange="inputDiff()">
                                        <option selected>current</option>
                                        <option>24h</option>
                                        <option>week</option>
                                        <option>month</option>
                                    </select>
                                </div>
                                <div class="col-6 col-xl-6">
                                    <select class="custom-select" name="interval_profit" onchange="inputDiff()">
                                        <option selected value="1">24h</option>
                                        <option value="7">week</option>
                                        <option value="30">month</option>
                                        <option value="365">year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-6 col-xl-6 mx-auto">
                                    Electricity cost
                                </div>
                                <div class="col-6 col-xl-6 mx-auto">
                                    Power consumption
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6 col-xl-6">
                                    <div class="input-group" id="power_cost">
                                        <input type="number" class="form-control" step="0.05" name="power_cost"
                                               id="power_cost" min="0"
                                               value="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text">$/kWh</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-xl-6">
                                    <div class="input-group" id="power">
                                        <input type="number" class="form-control" name="power" id="power">
                                        <div class="input-group-append">
                                            <span class="input-group-text">W</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto text-center">
                <button class="btn btn-primary btn-lg btn-style" id="calc"><i class="fa fa-spinner fa-pulse fa-lg fa-fw"
                                                                              id="spinner" aria-hidden="true"></i>Calc
                    It!
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
            <h2>Minercalc.com</h2>
        </div>
        <div class="col-xl-2 text-center">
            <h2>My Contacts:</h2>
            <h6><i class="fa fa-envelope-o" aria-hidden="true"></i> legat88@gmail.com</h6>
            <h6><i class="fa fa-vk" aria-hidden="true"></i> vk.com/legat88</h6>
            <h6><i class="fa fa-twitter" aria-hidden="true"></i> @Legat88</h6>
        </div>
        <div class="col-xl-4 text-center">
            <h2>Donate:</h2>
            <h6>BTC: 1CD75dQy3X7YfCXdHuVReKHUCLWBudNCFY</h6>
            <h6>LTC: LUPZRB7pohLZNzYyGevmKXnBvT9UpmAH78</h6>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../js/jQueryRotate.js"></script>
<script src="https://use.fontawesome.com/bc14f147cb.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>-->
<script type="text/javascript" src="../js/selectize.js"></script>
<link rel="stylesheet" type="text/css" href="../css/selectize.css"/>
<script src="urls.js"></script>
<script src="../js/main.js"></script>
<script src="../js/admin.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../js/jquery.metadata.min.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.pager.min.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.widgets.js"></script>
</body>
</html>