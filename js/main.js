(function () {
    $('div.preloader').hide();
    var clicks = 0;
    var winHeight = $(window).height();
    $('div#content').css('min-height', winHeight - 240);
    $(".showingData").click(function () {
        clicks++;
        if (clicks % 2 != 0) {
            $(".fa-chevron-circle-down").rotate({
                angle: 0,
                animateTo: 180
            });
            $('div#content').height('auto');
        }
        else {
            $(".fa-chevron-circle-down").rotate({
                angle: 180,
                animateTo: 360
            });
            // $('div#content').animate({
            //     height: winHeight-320
            // });
        }
    });
    $('p#headerText').on('click', function () {
        location.reload();
    });
})();
$(document).ready(function () {
    $('body').height($(window).height());
//        $('div#content').height($(window).height()-330);
    $('body').keyup(function (event) {
        if (event.keyCode === 13) {
            $("button#calc").click();
        }
    });

    $('i#spinner').hide();
    $('i#spinner_gpu').hide();
    $('i#spinner_asic').hide();
    $('div.info').hide();
    // function Calculation() {
    $('button#calc').click(function (e) {
        e.preventDefault();
        if (($('input#qtyVideocards').val() > 0 && $('select#gpu_select').val() !== 0) || ($('input#qtyASICs').val() > 0 && $('select#asic_select').val() !== 0)) {
            $('i#spinner').show();
            var algos = $('form#hashes').serialize();
            $.ajax({
                url: calculation,
                type: 'POST',
                data: algos,
                success: function (data) {
                    $('div#content').css('min-height', 0).height('auto');
                    $('div#calculation').html(data);
                    $('table.info')
                        .tablesorter({
                            theme: "bootstrap",
                            sortList: [[9, 1]]
                        })
                        .tablesorterPager({
                            container: $(".ts-pager"),
                            cssGoto: ".pagenum",
                            removeRows: false,
                            output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
                        });
                    $('i#spinner').hide();
                }
            })
        } else {
            alert('Select hardware and quantity!');
        }
    });
    // }
    // Calculation();


    $('input#qtyVideocards, select#gpu_select').on("keyup change", function () {
        $('i#spinner_gpu').show();
        $('input#qtyASICs, select#asic_select').val('');
        var qtyGpu = $('input#qtyVideocards').val();
        var gpuName = $('select#gpu_select').val();
        $.ajax({
            type: 'POST',
            url: fetch_data_algos_gpu,
            dataType: "json",
            data: {
                get_gpu: gpuName
            }
        }).done(function (data) {
            var hashrate = data.hashrate;
            var tdp = data.tdp;
            Object.keys(hashrate).forEach(function (key) {
                var newValue = hashrate[key] * qtyGpu;
                $('#' + key + '.hashes').val(newValue);
            });
            $('input#power').val(tdp * qtyGpu);
            $('i#spinner_gpu').hide();
            // Calculation();
        })
    });
    $('input#qtyASICs, select#asic_select').on("keyup change", function () {
        $('i#spinner_asic').show();
        $('input#qtyVideocards, select#gpu_select').val('');
        var qtyASIC = $('input#qtyASICs').val();
        var asicName = $('select#asic_select').val();
        $.ajax({
            type: 'POST',
            url: fetch_data_algos_asics,
            dataType: "json",
            data: {
                get_asic: asicName
            }
        }).done(function (data) {
            console.log(data);
            var hashrate = data.hashrate;
            var tdp = data.tdp;
            Object.keys(hashrate).forEach(function (key) {
                var newValue = hashrate[key] * qtyASIC;
                $('#' + key + '.hashes').val(newValue);
            });
            $('input#power').val(tdp * qtyASIC);
            $('i#spinner_asic').hide();
            // Calculation();
        })
    });
});

// $('table.info').on('load', function () {
//     $('table.info')
//     .tablesorter({
//         theme : "bootstrap",
//         sortList: [5,0]
//     })
//     .tablesorterPager({
//         container: $(".ts-pager"),
//         cssGoto  : ".pagenum",
//         removeRows: false,
//         output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
//     })
//
// });

function inputDiff() {
    $('button#calc').click();
}

function profit(kek) {
    var interval_profit = kek.value;
    $.ajax({
        type: 'POST',
        url: calculation,
        data: interval_profit,
        success: function (data) {
            $('div#calculation').html(data);
        }
    })
}