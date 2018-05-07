(function () {
    var clicks = 0;
    var winHeight = $(window).height();
    $('div#content').css('min-height', winHeight - 320);
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
    $('div.info').hide();
    $('button#calc').click(function (e) {
        e.preventDefault();
        $('i#spinner').show();
        var algos = $('form#hashes').serialize();
        $.ajax({
            url: calculation,
            type: 'POST',
            data: algos,
            success: function (data) {
                $('div#content').css('min-height', 0);
                $('div#content').height('auto');
                $('div#calculation').html(data);
                $('table.info').tablesorter({
                    theme: "bootstrap",
                    sortList: [[5, 1]]
                });
                $('i#spinner').hide();
            }
        })
    });
    $('input#qtyVideocards, select#gpu_select').on("keyup change", function () {
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
            Object.keys(data).forEach(function (key) {
                var newValue = data[key] * qtyGpu;
                $('#' + key + '.hashes').val(newValue);
            });
        })
    });
    $('input#qtyASICs, select#asic_select').on("keyup change", function () {
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
            Object.keys(data).forEach(function (key) {
                var newValue = data[key] * qtyASIC;
                $('#' + key + '.hashes').val(newValue);
            });
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