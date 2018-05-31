<?php
require "db.php";
$code = $_POST['code'];
$stmt = $dbh->query("SELECT datetime, $code FROM difficulty WHERE datetime > DATE_SUB(NOW(), INTERVAL 30 DAY)");
$data = [];
while ($diff_info = $stmt->fetch(PDO::FETCH_LAZY)) {
    if ($code != 'LUX') {
        $date = strtotime($diff_info['datetime']) * 1000;
        $diff = $diff_info[$code];
        if ($diff != NULL) {
            $data[] = array($date, $diff);
        }

    } else {
        if ($diff_info[$code] > 100) {
            $date = strtotime($diff_info['datetime']) * 1000;
            $diff = $diff_info[$code];
            if ($diff != NULL) {
                $data[] = array($date, $diff);
            }
        }
    }
}
$graph_data = '';
for ($i = 0; $i < count($data); $i++) {
    $key = $data[$i][0];
    $value = $data[$i][1];
    if ($i != count($data) - 1) {
        $graph_data .= '[' . $key . ', ' . $value . '], ';
    } else {
        $graph_data .= '[' . $key . ', ' . $value . ']';
    }
}
echo '<script type="text/javascript">
        Highcharts.setOptions({
            time: {
                timezoneOffset: -5 * 60
            }
        });
        Highcharts.stockChart(\'container\', {
            rangeSelector: {
                allButtonsEnabled: true,
                buttons: [{
                    type: \'day\',
                    count: 1,
                    text: \'Day\'
                }, {
                    type: \'week\',
                    count: 1,
                    text: \'Week\'
                }, {
                    type: \'month\',
                    count: 1,
                    text: \'Month\'
                }],
                selected: 2
            },

            title: {
                text: \'Difficulty\'
            },
//            
//            yAxis : {
//                min: 0
//            },

            series: [{
                name: \'Difficulty\',
                data: [' . $graph_data . '],
                type: \'areaspline\',
                threshold: null,
                tooltip: {
                    valueDecimals: 2
                },
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get(\'rgba\')]
                    ]
                }
            }]
        });
        </script>
';
