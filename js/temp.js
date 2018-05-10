var maxRenderedPointsX = 800;
var chart = null;
var config = {
    type: 'line',
    data: {
        labels: result['date'],
        datasets: [{
            label: 'Difficulty',
            data: result['diff'],
            borderColor: 'rgba(41, 182, 246, 1)',
            backgroundColor: 'rgba(41, 182, 246, 0.2)',
            pointRadius: 1
        }]
    },
    options: {
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                boxWidth: 80,
                fontColor: 'black'
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        animation: {
            duration: 1500,
            easing: 'easeInOutSine'
        },
        pan: {
            enabled: true,
            mode: 'x',
            rangeMin: {
                x: null
            },
            rangeMax: {
                x: null
            }
        },
        zoom: {
            enabled: true,
            mode: 'x'
        }
    }
};
initChart();

function initChart() {
    config.plugins = [{
        beforeUpdate: function (chart, options) {
            filterData(chart);
        }
    }];
    if (chart)
        chart.destroy();
    var ctx = document.getElementById('canvas').getContext('2d');
    chart = new Chart.Line(ctx, config);
}

function filterData(chart) {
    var datasets = chart.data.datasets;
    if (!chart.data.origDatasetsData) {
        chart.data.origDatasetsData = [];
        for (var i in datasets) {
            chart.data.origDatasetsData.push(datasets[i].data);
        }
    }
    var originalDatasetsData = chart.data.origDatasetsData;
    var chartOptions = chart.options.scales.xAxes[0];
    var startX = chartOptions.time.min;
    var endX = chartOptions.time.max;

    if (startX && typeof startX === 'object')
        startX = startX._d.getTime();
    if (endX && typeof endX === 'object')
        endX = endX._d.getTime();

    for (var i = 0; i < originalDatasetsData.length; i++) {
        var originalData = originalDatasetsData[i];

        if (!originalData.length)
            continue;

        var firstElement = {
            index: 0,
            time: null
        };
        var lastElement = {
            index: originalData.length - 1,
            time: null
        };

        for (var j = 0; j < originalData.length; j++) {
            var time = originalData[j].x;
            if (time >= startX && (firstElement.time === null || time < firstElement.time)) {
                firstElement.index = j;
                firstElement.time = time;
            }
            if (time <= endX && (lastElement.time === null || time > lastElement.time)) {
                lastElement.index = j;
                lastElement.time = time;
            }
        }
        var startIndex = firstElement.index <= lastElement.index ? firstElement.index : lastElement.index;
        var endIndex = firstElement.index >= lastElement.index ? firstElement.index : lastElement.index;
        datasets[i].data = reduce(originalData.slice(startIndex, endIndex + 1), maxRenderedPointsX);
    }
}

// returns a reduced version of the data array, averaging x and y values
function reduce(data, maxCount) {
    if (data.length <= maxCount)
        return data;
    var blockSize = data.length / maxCount;
    var reduced = [];
    for (var i = 0; i < data.length;) {
        var chunk = data.slice(i, (i += blockSize) + 1);
        reduced.push(average(chunk));
    }
    return reduced;
}

function average(chunk) {
    var x = 0;
    var y = 0;
    for (var i = 0; i < chunk.length; i++) {
        x += chunk[i].x;
        y += chunk[i].y;
    }
    return {
        x: Math.round(x / chunk.length),
        y: y / chunk.length
    };
}
