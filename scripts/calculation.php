<?php
require "db.php";
$DAY = 86400; //секунд в сутках
$new_array = array_slice($_POST, 0, -2, true);
foreach ($new_array as $key => $value) {
    if ($value != 'NaN' and $value > 0) {
        $algos[$key] = $value;
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
            <table class="table table-responsive-sm table-hover table-bordered text-center info ">
                <thead>
                <tr>
                    <th>Name of coin</th>
                    <th>Code</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Difficulty</th>
                    <th>Profit</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($algos as $algo => $value) {
                    $algo_info = $dbh->query("SELECT * FROM algos WHERE name='$algo'");
                    $result_algo = $algo_info->fetch(PDO::FETCH_LAZY);
                    $measure = $result_algo->measure;
                    if ($measure == 'MH') {
                        $measure = 1000000;
                    } elseif ($measure == 'GH') {
                        $measure = 1000000000;
                    } elseif ($measure == 'kh/s') {
                        $measure = 1000;
                    } else {
                        $measure = 1;
                    }
                    $coin_info = $dbh->query("SELECT * FROM coins WHERE algo='$algo'");
                    while ($result_coin = $coin_info->fetch(PDO::FETCH_LAZY)) {
                        $coin_name = $result_coin->name;
                        $coin_code = $result_coin->code;
                        $blocktime = $result_coin->blocktime;
                        $block_reward = $result_coin->block_reward;
                        $my_hashrate = $value * $measure;
                        $interval_diff = $_POST['interval_diff'];
                        if (isset($_POST['interval_profit'])) {
                            $interval_profit = $_POST['interval_profit'];
                        } else {
                            $interval_profit = 1;
                        }
                        if ($interval_diff == 'current') {
                            $net_info = $dbh->query("SELECT $coin_code as difficulty FROM difficulty WHERE $coin_code > 10 ORDER BY id DESC LIMIT 1");
                        } elseif ($interval_diff == '24h') {
                            $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE $coin_code > 10 AND datetime >= CURRENT_TIME - INTERVAL 1 DAY");
                        } elseif ($interval_diff == 'week') {
                            $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE $coin_code > 10 AND datetime >= CURRENT_TIME - INTERVAL 7 DAY");
                        } elseif ($interval_diff == 'month') {
                            $net_info = $dbh->query("SELECT AVG($coin_code) as difficulty FROM difficulty WHERE $coin_code > 10 AND datetime >= CURRENT_TIME - INTERVAL 30 DAY");
                        } else {
                            $net_info = $dbh->query("SELECT $coin_code as difficulty FROM difficulty WHERE $coin_code > 10 ORDER BY id DESC LIMIT 1");
                        }
                        $result_net = $net_info->fetch(PDO::FETCH_LAZY);
                        $difficulty = $result_net->difficulty;
                        if (!$difficulty) {
                            continue;
                        } else {
                            if ($algo == 'Ethash') {
                                $qty = ($my_hashrate * $block_reward * $DAY * $interval_profit) / ($difficulty);
                            } elseif ($algo == 'Equihash') {
                                $qty = ($my_hashrate * $block_reward * $DAY * $interval_profit) / ($difficulty * 8192);
                            } elseif ($algo == 'Cryptonight') {
                                $qty = ($my_hashrate * $block_reward * $DAY * $interval_profit) / ($difficulty);
                            } else {
                                $qty = ($my_hashrate * $block_reward * $DAY * $interval_profit) / ($difficulty * 4294967296);
                            }
                            $stmt = $dbh->prepare("SELECT price FROM price WHERE coin=?");
                            $stmt->execute(array($coin_name));
                            $result = $stmt->fetch(PDO::FETCH_LAZY);
                            $price = $result->price;
                            $profit = $qty * $price;
                            echo '<tr id="' . $coin_code . '" class="coin_row">
                    <td>' . $coin_name . '</td>
                    <td>' . $coin_code . '</td>
                    <td class="qty">' . number_format($qty, 5) . '</td>
                    <td>$ ' . number_format($price, 3) . '</td>
                    <td>' . number_format($difficulty, 3, ".", " ") . '</td>
                    <td class="profit">$ ' . number_format($profit, 2) . '</td>
                        </tr>';
                        }
                    }
                }
                ?>
                </tbody>
            </table>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('div.info').hide();
                    $('html, body').animate({
                        scrollTop: $('#coinsInfo').offset().top
                    }, 1000);
                    $('tr.coin_row').on("click", function () {
                        $('p.info').remove();
                        $('div.info').show();
                        $('html, body').animate({
                            scrollTop: $('#coinInfo').offset().top
                        }, 1000);
                        var coin = $(this).attr('id');
                        $.ajax({
                            url: '../scripts/coin_info.php',
                            type: 'POST',
                            dataType: "json",
                            data: {coin_code: coin},
                            success: function (data) {
                                var coin = data['coin'],
                                    algo = data['algo'],
                                    url = data['url'],
                                    pools = data['pool'][0],
                                    miner = data['miner'],
                                    pool_url = data['address'][0],
                                    port = data['port'][0];
                                var bat = '';
                                if (miner.match(/ccminer/i)) {
                                    bat = 'ccminer.exe -a ' + algo.toLowerCase() + ' -o stratum+tcp://' + pool_url + ':' + port + ' -u &ltusername>.&ltworker> -p &ltpassword>'
                                } else if (miner.match(/dstm/i)) {
                                    bat = 'zm --server ' + pool_url + ' --port ' + port + ' --user &ltusername>'
                                } else if (miner.match(/claymore/i)) {
                                    bat = 'EthDcrMiner64.exe -epool ' + pool_url + ':' + port + ' -ewal &ltwallet>/&ltworker> -epsw &ltpassword>'
                                }
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
                                    bat +
                                    '</p>'
                                );

                            }
                        });
                    });
                });
            </script>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-md-8 info" id="coinInfo">
        </div>

    </div>
</div>

