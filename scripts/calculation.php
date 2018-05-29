<?php
require "db.php";
require "numberAbbreviation.php";
$DAY=86400; //секунд в сутках
$new_array = array_slice($_POST, 0, -4, true);
foreach ($new_array as $key=>$value) {
    if ($value != 'NaN' and $value>0) {
        $algos[$key]=$value;
    }
}
?>
<div class="container-fluid" id="coinsInfo">
    <div class="row">
        <div class="col">
            <h3 class="text-center">You can mine <span class="blueSelect">these</span> coins:</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-xl-6">
            <table class="table table-responsive-sm table-hover table-bordered text-center info">
                <thead>
                <tr>
                    <th>Name of coin</th>
                    <th>Code</th>
                    <th>Algo</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Difficulty</th>
                    <th>Income</th>
                    <th>Power</th>
                    <th>Power cost</th>
                    <th>Profit</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($algos as $algo=>$value) {
                    $algo_info=$dbh->query("SELECT * FROM algos WHERE name='$algo'");
                    $result_algo=$algo_info->fetch(PDO::FETCH_LAZY);
                    $measure=$result_algo->measure;
                    $coef = $result_algo->power_coef;
                    $tdp = $_POST['power'];
                    $power = $tdp * $coef;
                    $power_cost = $_POST['power_cost'] / 1000;
                    if (isset($_POST['interval_profit'])) {
                        $interval_profit = $_POST['interval_profit'];
                    } else {
                        $interval_profit = 1;
                    }
                    $power_cost_in_dollars = $power_cost * $power * 24 * $interval_profit;
                    if ($measure=='MH') {
                        $measure=1000000;
                    } elseif ($measure=='GH') {
                        $measure=1000000000;
                    } elseif ($measure=='kh/s') {
                        $measure=1000;
                    } else {
                        $measure=1;
                    }
                    $coin_info=$dbh->query("SELECT * FROM coins WHERE algo='$algo'");
                    while ($result_coin=$coin_info->fetch(PDO::FETCH_LAZY)) {
                        $coin_name=$result_coin->name;
                        $coin_code=$result_coin->code;
                        $blocktime=$result_coin->blocktime;
                        $block_reward=$result_coin->block_reward;
                        $my_hashrate=$value*$measure;

                        $interval_diff=$_POST['interval_diff'];

                        if ($coin_code == 'LUX') {
                            if ($interval_diff == 'current') {
                                $net_info = $dbh->query("SELECT $coin_code as difficulty FROM difficulty WHERE $coin_code > 100 ORDER BY id DESC LIMIT 1");
                            } elseif ($interval_diff == '24h') {
                                $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE $coin_code > 100 AND datetime > DATE_SUB(NOW(), INTERVAL 1 DAY)");
                            } elseif ($interval_diff == 'week') {
                                $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE $coin_code > 100 AND datetime > DATE_SUB(NOW(), INTERVAL 7 DAY)");
                            } elseif ($interval_diff == 'month') {
                                $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE $coin_code > 100 AND datetime > DATE_SUB(NOW(), INTERVAL 30 DAY)");
                            } else {
                                $net_info = $dbh->query("SELECT $coin_code as difficulty FROM difficulty WHERE $coin_code > 100 ORDER BY id DESC LIMIT 1");
                            }
                        } else {
                            if ($interval_diff == 'current') {
                                $net_info = $dbh->query("SELECT $coin_code as difficulty FROM difficulty ORDER BY id DESC LIMIT 1");
                            } elseif ($interval_diff == '24h') {
                                $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE datetime > DATE_SUB(NOW(), INTERVAL 1 DAY)");
                            } elseif ($interval_diff == 'week') {
                                $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE datetime > DATE_SUB(NOW(), INTERVAL 7 DAY)");
                            } elseif ($interval_diff == 'month') {
                                $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE datetime > DATE_SUB(NOW(), INTERVAL 30 DAY)");
                            } else {
                                $net_info = $dbh->query("SELECT $coin_code as difficulty FROM difficulty ORDER BY id DESC LIMIT 1");
                            }
                        }

                        $result_net=$net_info->fetch(PDO::FETCH_LAZY);
                        $difficulty=$result_net->difficulty;
                        if (!$difficulty) {
                            continue;
                        } else {
                            if ($algo=='Ethash') {
                                $qty=($my_hashrate*$block_reward*$DAY*$interval_profit)/($difficulty);
                            } elseif ($algo=='Equihash') {
                                $qty=($my_hashrate*$block_reward*$DAY*$interval_profit)/($difficulty*8192);
                            } elseif ($algo == 'Cryptonight_v7') {
                                $qty=($my_hashrate*$block_reward*$DAY*$interval_profit)/($difficulty);
                            } elseif ($algo == 'SK1024') {
                                $qty = ($my_hashrate * $block_reward * $DAY * $interval_profit) / ($difficulty * 32288028000);
                            } else {
                                $qty=($my_hashrate*$block_reward*$DAY*$interval_profit)/($difficulty*4294967296);
                            }
                            $stmt=$dbh->prepare("SELECT price FROM price WHERE coin=?");
                            $stmt->execute(array($coin_name));
                            $result=$stmt->fetch(PDO::FETCH_LAZY);
                            $price=$result->price;
                            $profit=$qty*$price;
                            $pure_profit = $profit - $power_cost_in_dollars;
                            echo '<tr id="'.$coin_code.'" class="coin_row">
                    <td>'.$coin_name.'</td>
                    <td>'.$coin_code.'</td>
                    <td>' . $algo . '</td>
                    <td class="qty">'.number_format($qty, 5).'</td>
                    <td>$' . number_format($price, 3) . '</td>
                    <td>' . numberAbbreviation($difficulty) . '</td>
                    <td class="profit">$' . number_format($profit, 2) . '</td>
                    <td>' . $power . 'W</td>
                    <td>$' . $power_cost_in_dollars . '</td>
                    <td>$' . number_format($pure_profit, 2) . '</td>
                        </tr>';
                        }
                    }
                }
                ?>

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="10" class="ts-pager">
                        <div class="form-inline justify-content-center">
                            <div class="btn-group btn-group-sm mx-1" role="group">
                                <button type="button" class="btn btn-primary first" title="first">⇤</button>
                                <button type="button" class="btn btn-primary prev" title="previous">←</button>
                            </div>
                            <span class="pagedisplay"></span>
                            <div class="btn-group btn-group-sm mx-1" role="group">
                                <button type="button" class="btn btn-primary next" title="next">→</button>
                                <button type="button" class="btn btn-primary last" title="last">⇥</button>
                            </div>
                            <!--                            <select class="form-control-sm custom-select px-1 pagesize" title="Select page size">-->
                            <!--                                <option selected="selected" value="10">10</option>-->
                            <!--                                <option value="20">20</option>-->
                            <!--                                <option value="30">30</option>-->
                            <!--                                <option value="all">All Rows</option>-->
                            <!--                            </select>-->
                            <!--                            <select class="form-control-sm custom-select px-4 mx-1 pagenum" title="Select page number"></select>-->
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
            <script type="text/javascript">
                $(document).ready(function () {

                    $('div.info').hide();
//                    $('table.info')
//                        .tablesorter({
////                            theme: "bootstrap",
////                            sortList: [6, 0]
//                        })
//                        .tablesorterPager({
//                            container: $(".ts-pager"),
//                            cssGoto: ".pagenum",
//                            removeRows: false,
//                            output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
//                        });
                    $('html, body').animate({
                        scrollTop: $('#coinsInfo').offset().top
                    }, 1000);

                    $('tr.coin_row').on("click", function () {
                        $('p.info').remove();
                        $('div.info').show();
                        $('html, body').animate({
                            scrollTop: $('#coinInfo').offset().top
                        }, 1000);
                        var code = $(this).attr('id');
                        $.ajax({
                            url: '../scripts/coin_info.php',
                            type: 'POST',
                            dataType: "json",
                            data: {coin_code: code}
                        }).done(function (result) {
                            console.log(result);
                            var coin = result['coin'],
                                algo = result['algo'],
                                url = result['url'],
                                pools = result['pool'][0],
                                miner = result['miner'],
                                pool_url = result['address'][0],
                                port = result['port'][0],
                                bat = '';
                            if (miner.match(/ccminer/i)) {
                                bat = 'ccminer.exe -a ' + algo.toLowerCase() + ' -o stratum+tcp://' + pool_url + ':' + port + ' -u &ltusername>.&ltworker> -p &ltpassword>'
                            } else if (miner.match(/dstm/i)) {
                                bat = 'zm --server ' + pool_url + ' --port ' + port + ' --user &ltusername>'
                            } else if (miner.match(/claymore/i)) {
                                bat = 'EthDcrMiner64.exe -epool ' + pool_url + ':' + port + ' -ewal &ltwallet>/&ltworker> -epsw &ltpassword>'
                            } else if (miner.match(/lolminer/i)) {
                                bat = 'in cfg file: <br>' +
                                    '--server ' + pool_url + '<br>' +
                                    '--port ' + port + '<br>' +
                                    '--user &ltwallet>.&ltworker> <br>' +
                                    '--pass &ltpassword> '
                            } else if (miner.match(/tdxminer/i)) {
                                bat = './tdxminer -a lyra2z -o ' + pool_url + ':' + port + ' -u &ltusername> -p &ltpassword>'
                            }

                            $('div#container').remove();
                            $('div.info').append('<p class="text-center info">' +
                                'You choose <span class="blueSelect" id="selectedCoin">' + coin + '</span>! <br>' +
                                '<a class="blueSelect" href="' + url + '">Coinmarketcap</a><br>' +
                                '<b>Algo:</b><br>\n' +
                                algo + '<br>\n' +
                                '<b>Pools:</b><br>\n' +
                                pools + '<br>\n' +
                                '<b>Miner</b><br>\n' +
                                miner + '<br>\n' +
                                '<b>Miner cmd:</b><br>\n' +
                                bat + '<br>\n' +
                                '<b>Difficulty:</b><br>\n' +
                                '</p>' +
                                '<div id="container" style="height:400px;"></div>'
                            );
                        }).done(function () {
                            $.ajax({
                                url: '../scripts/data_graph.php',
                                type: 'POST',
                                data: {code: code}
                            }).done(function (ppp) {
                                $('div.info').append(ppp);
                            });

                        });
                    });
//                                var href='scripts/calculation.php?coin='+code;
//                                console.log(href);
//                                document.location.href=href;


                });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
            <script src="../js/highstock.js"></script>
            <!--            <script src="https://code.highcharts.com/highcharts.js"></script>-->

            <!--            <nav aria-label="Page navigation example">-->
            <!--                <ul class="pagination justify-content-center">-->
            <!--                    <li class="page-item">-->
            <!--                        <a class="page-link" href="#" aria-label="Previous">-->
            <!--                            <span aria-hidden="true">&laquo;</span>-->
            <!--                            <span class="sr-only">Previous</span>-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                    <li class="page-item active"><a class="page-link" href="#">1</a></li>-->
            <!--                    <li class="page-item"><a class="page-link" href="#">2</a></li>-->
            <!--                    <li class="page-item"><a class="page-link" href="#">3</a></li>-->
            <!--                    <li class="page-item">-->
            <!--                        <a class="page-link" href="#" aria-label="Next">-->
            <!--                            <span aria-hidden="true">&raquo;</span>-->
            <!--                            <span class="sr-only">Next</span>-->
            <!--                        </a>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </nav>-->
        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-xl-6 info" id="coinInfo">
        </div>

    </div>
</div>

