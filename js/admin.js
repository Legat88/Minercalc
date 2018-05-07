$(document).ready(function () {

    $('.selectize-add-item').selectize({
        create: true
    });
//        $('.selectize').selectize();

    $('button#addGpu').click(function () {
        var add_gpu = $('form#addGpu').serialize();
        $.ajax({
            url: '../scripts/add_gpu.php',
            type: 'POST',
            data: add_gpu,
            success: function (result) {
                alert("Adding complete!");
                location.reload();
            }
        })
    });
    $('button#editGpu').click(function () {
        var edit_gpu = $('form#editGpu').serialize();
        $.ajax({
            url: '../scripts/edit_gpu.php',
            type: 'POST',
            data: edit_gpu,
            success: function (result) {
                alert("Editing complete!");
                location.reload();
            }
        })
    });
    $('button#removeGpu').click(function () {
        var remove_gpu = $('form#removeGpu').serialize();
        $.ajax({
            url: '../scripts/remove_gpu.php',
            type: 'POST',
            data: remove_gpu,
            success: function (result) {
                alert("Removing complete!");
                location.reload();
            }
        })
    });
    $('button#addASIC').click(function () {
        var add_asic = $('form#addASIC').serialize();
        $.ajax({
            url: '../scripts/add_asic.php',
            type: 'POST',
            data: add_asic,
            success: function (result) {
                alert("Adding complete!");
                location.reload();
            }
        })
    });
    $('button#editASIC').click(function () {
        var edit_asic = $('form#editGpu').serialize();
        $.ajax({
            url: '../scripts/edit_asic.php',
            type: 'POST',
            data: edit_asic,
            success: function (result) {
                alert("Editing complete!");
                location.reload();
            }
        })
    });
    $('button#removeASIC').click(function () {
        var remove_asic = $('form#removeGpu').serialize();
        $.ajax({
            url: '../scripts/remove_asic.php',
            type: 'POST',
            data: remove_asic,
            success: function (result) {
                alert("Removing complete!");
                location.reload();
            }
        })
    });
    $('button#addAlgo').click(function () {
        var add_algo = $('form#addAlgo').serialize();
        $.ajax({
            url: '../scripts/add_algo.php',
            type: 'POST',
            data: add_algo,
            success: function (result) {
                alert("Adding complete!");
                location.reload();
            }
        })
    });
    $('button#editAlgo').click(function () {
        var edit_algo = $('form#editAlgo').serialize();
        $.ajax({
            url: '../scripts/edit_algo.php',
            type: 'POST',
            data: edit_algo,
            success: function (result) {
                alert("Editing complete!");
                location.reload();
            }
        })
    });
    $('button#removeAlgo').click(function () {
        var remove_algo = $('form#removeAlgo').serialize();
        $.ajax({
            url: '../scripts/remove_algo.php',
            type: 'POST',
            data: remove_algo,
            success: function (result) {
                alert("Removing complete!");
                location.reload();
            }
        })
    });
    $('button#addCoin').click(function () {
        var add_coin = $('form#addCoin').serialize();
        $.ajax({
            url: '../scripts/add_coin.php',
            type: 'POST',
            data: add_coin,
            success: function (result) {
                alert("Adding complete!");
                location.reload();
            }
        })
    });
    $('button#editCoin').click(function () {
        var edit_coin = $('form#editCoin').serialize();
        $.ajax({
            url: '../scripts/edit_coin.php',
            type: 'POST',
            data: edit_coin,
            success: function (result) {
                alert("Editing complete!");
                location.reload();
            }
        })
    });
    $('button#removeCoin').click(function () {
        var remove_coin = $('form#removeCoin').serialize();
        $.ajax({
            url: '../scripts/remove_coin.php',
            type: 'POST',
            data: remove_coin,
            success: function (result) {
                alert("Removing complete!");
                location.reload();
            }
        })
    });
    $('button#addPool').click(function () {
        var add_pool = $('form#addPool').serialize();
        $.ajax({
            url: '../scripts/add_pool.php',
            type: 'POST',
            data: add_pool,
            success: function (result) {
                alert("Adding complete!");
                location.reload();
            }
        })
    });
    $('button#editPool').click(function () {
        var edit_pool = $('form#editPool').serialize();
        $.ajax({
            url: '../scripts/edit_pool.php',
            type: 'POST',
            data: edit_pool,
            success: function (result) {
                alert("Editing complete!");
                location.reload();
            }
        })
    });
    $('button#removePoolCoin').click(function () {
        var remove_pool_coin = $('form#removePool').serialize();
        $.ajax({
            url: '../scripts/remove_pool_coin.php',
            type: 'POST',
            data: remove_pool_coin,
            success: function (result) {
                alert("Removing complete!");
                location.reload();
            }
        })
    });
    $('button#removePool').click(function () {
        var remove_pool = $('form#removePool').serialize();
        $.ajax({
            url: '../scripts/remove_pool.php',
            type: 'POST',
            data: remove_pool,
            success: function (result) {
                alert("Removing complete!");
                location.reload();
            }
        })
    });

    $('select#gpu_name_edit').change(function () {
        var gpuName = $('select#gpu_name_edit').val();
        $.ajax({
            type: 'POST',
            url: '../scripts/fetch_data_algos_gpu.php',
            dataType: "json",
            data: {
                get_gpu: gpuName
            }
        }).done(function(data) {
            Object.keys(data).forEach(function (key) {
                $('input#'+key+'.edit').val(data[key]);
            });
        });
    });
    $('select#asic_name_edit').change(function () {
        var asicName = $('select#asic_name_edit').val();
        $.ajax({
            type: 'POST',
            url: '../scripts/fetch_data_algos_asics.php',
            dataType: "json",
            data: {
                get_asic: asicName
            }
        }).done(function(data) {
            Object.keys(data).forEach(function (key) {
                $('input#'+key+'.edit').val(data[key]);
            });
        });
    });
    $('select#algo_name_edit').change(function () {
        var algoName = $('select#algo_name_edit').val();
        $.ajax({
            type: 'POST',
            url: '../scripts/fetch_data_algo.php',
            dataType: "json",
            data: {
                get_algo: algoName
            }
        }).done(function(data) {
            var miner=data.miner;
            $('input#miner').val(miner);
            var measure=data.measure;
            $('select#measure').val(measure);
        });
    });
    // $(function RpcToggleEdit(api, rpc) {
    //     api.show();
    //     rpc.hide();
    //     var rpcEdit=$("input#rpcCheckEdit").is(':checked');
    //     console.log(rpcEdit);
    //     if (rpcEdit === true) {
    //         api.hide();
    //         rpc.show();
    //     } else {
    //         api.show();
    //         rpc.hide();
    //     }
    // $("input#rpcCheckEdit").click(function () {
    //     var rpcEdit = $(this).is(':checked');
    //     console.log(rpc);
    //
    // });
    // });

    $('select#coin_name_edit').change(function () {

        $('form#editCoin').find("input").val("");
        var coinName = $('select#coin_name_edit').val();
        $.ajax({
            type: 'POST',
            url: '../scripts/fetch_data_coin.php',
            dataType: "json",
            data: {
                get_coin: coinName
            }
        }).done(function(data) {
            var code=data.code;
            $('input#code').val(code);
            var algo=data.algo;
            $('select#algo').val(algo);
            var blockreward=data.block_reward;
            $('input#blockreward').val(blockreward);
            var rpc_mode = data.rpc;
            console.log(rpc_mode);
            if (rpc_mode === 0) {
                $('input#rpcCheckEdit').prop('checked', false);
                var url = data.url;
                $('input#url').val(url);
                var parameter = data.parameter;
                $('input#parameter').val(parameter);
                var addition = data.addition;
                $('input#addition').val(addition);
            } else {
                $('input#rpcCheckEdit').prop('checked', true);
                var rpcuser = data.rpcuser;
                $('input#rpcuserEdit').val(rpcuser);
                var rpcpassword = data.rpcpassword;
                $('input#rpcpasswordEdit').val(rpcpassword);
                var rpcport = data.rpcport;
                $('input#rpcportEdit').val(rpcport);
            }

        });
    });
    $('select#pool_name_remove').change(function () {
        var poolName=$('select#pool_name_remove').val();
        $.ajax({
            type: 'POST',
            url: '../scripts/fetch_pool_coins.php',
            dataType: "json",
            data: {pool_name: poolName},
            success: function (data) {
                $('select#pool_coin_remove option').remove();
                data.forEach(function (item, i, data) {
                    $('select#pool_coin_remove').append('<option>' + data[i] + '</option>');
                });
            }
        })
    });
    $('select#pool_name_edit').change(function () {
        var poolName=$('select#pool_name_edit').val();
        $.ajax({
            type: 'POST',
            url: '../scripts/fetch_pool_coins.php',
            dataType: "json",
            data: {pool_name: poolName},
            success: function (data) {
                $('select#coin_pool_edit option').remove();
                $('select#coin_pool_edit').append('<option selected disabled>Choose coin...</option>');
                data.forEach(function (item, i, data) {
                    $('select#coin_pool_edit').append('<option>' + data[i] + '</option>');
                });
            }
        })
    });
    $('select#coin_pool_edit, select#pool_name_edit').on("change", function () {
        var poolName=$('select#pool_name_edit').val();
        var coinName=$('select#coin_pool_edit').val();
        $.ajax({
            type: 'POST',
            url: '../scripts/fetch_pool_addresses.php',
            dataType: 'json',
            data: {
                pool_name: poolName,
                coin_name: coinName
            },
            success: function (data) {
                console.log(data);
                var address=data.address;
                $('input#pool_address_edit').val(address);
                var port=data.port;
                $('input#pool_port_edit').val(port);
            }
        })
    });
    $(function RpcToggle() {
        $('div#api').show();
        $('div#rpc').hide();
        $("input#rpcCheck").click(function () {
            var rpc = $(this).is(':checked');
            console.log(rpc);
            if (rpc === true) {
                $('div#api').hide();
                $('div#rpc').show();
            } else {
                $('div#api').show();
                $('div#rpc').hide();
            }
        });
    });
    (function RpcToggleEdit() {
        $('div#apiEdit').show();
        $('div#rpcEdit').hide();
        $("input#rpcCheckEdit").click(function () {
            var rpc_check_edit = $(this).is(':checked');
            if (rpc_check_edit === true) {
                $('div#apiEdit').hide();
                $('div#rpcEdit').show();
            } else {
                $('div#apiEdit').show();
                $('div#rpcEdit').hide();
                $('input#rpcCheckEdit').prop('checked', false);
            }
        });
    })();

});