<h2 class="text-center">Operations with DB</h2>
<div class="row justify-content-center">
    <div class="dropdown col-auto text-center">
        <button class="btn btn-style dropdown-toggle" type="button" id="add" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            Add
        </button>
        <div class="dropdown-menu" aria-labelledby="add">
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#addGpuModal">Videocard
            </button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#addASICModal">ASIC</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#addAlgoModal">Algo</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#addCoinModal">Coin</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#addPoolModal">Pool</button>
        </div>
    </div>
    <div class="dropdown col-auto text-center">
        <button class="btn btn-style dropdown-toggle" type="button" id="edit" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Edit
        </button>
        <div class="dropdown-menu" aria-labelledby="edit">
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#editGpuModal">Videocard
            </button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#editASICModal">ASIC</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#editAlgoModal">Algo</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#editCoinModal">Coin</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#editPoolModal">Pool</button>
        </div>
    </div>
    <div class="dropdown col-auto text-center">
        <button class="btn btn-style dropdown-toggle" type="button" id="remove" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Remove
        </button>
        <div class="dropdown-menu" aria-labelledby="remove">
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#removeGpuModal">Videocard
            </button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#removeASICModal">ASIC</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#removeAlgoModal">Algo</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#removeCoinModal">Coin</button>
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#removePoolModal">Pool</button>
        </div>
    </div>
</div>
<!-- Modal add GPU -->
<div class="modal fade bd-example-modal-lg" id="addGpuModal" tabindex="-1" role="dialog" aria-labelledby="add"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding new Videocard</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="addGpu" method="post">
                    <div class="form-group col-8 text-center mx-auto" id="add_gpu">
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Name of GPU:</h3>
                                <input type="text" class="form-control" name="gpu_name" placeholder="Name of GPU">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">TDP of GPU:</h5>
                                <div class="input-group" id="power">
                                    <input type="number" class="form-control" name="tdp" placeholder="TDP of GPU"
                                           min="0">
                                    <div class="input-group-append">
                                        <span class="input-group-text">W</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Algos:</h3>
                            </div>
                        </div>
                        <div class="row">
                            <? $css_grid = 'col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4';
                            include "../scripts/generate_algos_add.php";
                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addGpu">Add!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal edit GPU -->
<div class="modal fade bd-example-modal-lg" id="editGpuModal" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editing Videocard</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="editGpu" method="post">
                    <div class="form-group col-8 text-center mx-auto" id="edit_gpu">
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Name of GPU:</h3>
                                <select class="form-control selectize" id="gpu_name_edit" name="gpu_name">
                                    <option>Choose model...</option>
                                    <? $gpu = $dbh->query("SELECT name FROM GPU")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($gpu as $g) {
                                        echo '<option>' . $g . '</option>';
                                    }
                                    $gpu = null;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">TDP of GPU:</h5>
                                <div class="input-group" id="power">
                                    <input type="number" class="form-control" name="tdp" placeholder="TDP of GPU"
                                           min="0" id="tdp_gpu">
                                    <div class="input-group-append">
                                        <span class="input-group-text">W</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Algos:</h3>
                            </div>
                        </div>
                        <div class="row">
                            <? $css_grid = 'col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4';
                            include "../scripts/generate_algos_edit.php";
                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editGpu">Edit!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal remove GPU -->
<div class="modal fade bd-example-modal-lg" id="removeGpuModal" tabindex="-1" role="dialog" aria-labelledby="remove"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Removing Videocard</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="removeGpu" method="post">
                    <div class="form-group col-8 text-center mx-auto" id="remove_gpu">
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Name of GPU:</h3>
                                <select class="form-control selectize" id="gpu_name_remove" name="gpu_name">
                                    <option>Choose model...</option>
                                    <? $gpu = $dbh->query("SELECT name FROM GPU")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($gpu as $g) {
                                        echo '<option>' . $g . '</option>';
                                    }
                                    $gpu = null;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="removeGpu">Remove!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal add ASIC -->
<div class="modal fade bd-example-modal-lg" id="addASICModal" tabindex="-1" role="dialog" aria-labelledby="add"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding new ASIC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="addASIC" method="post">
                    <div class="form-group col-8 text-center mx-auto" id="add_algos">
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Name of ASIC:</h3>
                                <input type="text" class="form-control" name="asic_name" placeholder="Name of ASIC">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">TDP of ASIC:</h5>
                                <input type="number" class="form-control" name="tdp" placeholder="TDP of ASIC"
                                       min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Algos:</h3>
                            </div>
                        </div>
                        <div class="row">
                            <? $css_grid = 'col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4';
                            include "../scripts/generate_algos.php";
                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addASIC">Add!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal edit ASIC -->
<div class="modal fade bd-example-modal-lg" id="editASICModal" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editing ASIC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="editASIC" method="post">
                    <div class="form-group col-8 text-center mx-auto" id="edit_asics">
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Name of ASIC:</h3>
                                <select class="form-control selectize" id="asic_name_edit" name="asic_name">
                                    <option>Choose model...</option>
                                    <? $asic = $dbh->query("SELECT name FROM ASIC")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($asic as $a) {
                                        echo '<option>' . $a . '</option>';
                                    }
                                    $asic = null;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">TDP of ASIC:</h5>
                                <input type="number" class="form-control" name="tdp" placeholder="TDP of ASIC"
                                       min="0" id="tdp_asic">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Algos:</h3>
                            </div>
                        </div>
                        <div class="row">
                            <? $css_grid = 'col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4';
                            include "../scripts/generate_algos_edit.php";
                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editASIC">Edit!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal remove ASIC -->
<div class="modal fade bd-example-modal-lg" id="removeASICModal" tabindex="-1" role="dialog" aria-labelledby="remove"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Removing ASIC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="removeASIC" method="post">
                    <div class="form-group col-8 text-center mx-auto" id="remove_asics">
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Name of ASIC:</h3>
                                <select class="form-control selectize" id="asic_name_remove" name="asic_name">
                                    <option>Choose model...</option>
                                    <? $asic = $dbh->query("SELECT name FROM ASIC")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($asic as $a) {
                                        echo '<option>' . $a . '</option>';
                                    }
                                    $asic = null;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="removeASIC">Remove!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal add algo -->
<div class="modal fade bd-example-modal-lg" id="addAlgoModal" tabindex="-1" role="dialog" aria-labelledby="add"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding new Algo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="addAlgo" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <input type="text" class="form-control" name="algo_name" placeholder="Name of Algo">
                            </div>
                            <div class="col">
                                <h6 class="text-center">Measure:</h6>
                                <select class="form-control custom-select" name="measure">
                                    <option value="MH" selected>MH</option>
                                    <option value="Sol">Sol</option>
                                    <option value="h/s">h/s</option>
                                    <option value="kh/s">kh/s</option>
                                    <option value="GH">GH</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Miner:</h6>
                                <input type="text" class="form-control" name="miner" placeholder="Name of miner">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Power coefficient:</h6>
                                <input type="number" class="form-control" name="power_coef"
                                       placeholder="Coefficient" min="0" value="1" step="0.05">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addAlgo">Add!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal edit algo -->
<div class="modal fade bd-example-modal-lg" id="editAlgoModal" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editing Algo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="editAlgo" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <select class="form-control selectize" id="algo_name_edit" name="algo_name">
                                    <option>Choose algo...</option>
                                    <? $algo = $dbh->query("SELECT name FROM algos")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($algo as $a) {
                                        echo '<option>' . $a . '</option>';
                                    }
                                    $gpu = null;
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <h6 class="text-center">Measure:</h6>
                                <select class="form-control custom-select" name="measure" id="measure">
                                    <option value="MH" selected>MH</option>
                                    <option value="Sol">Sol</option>
                                    <option value="h/s">h/s</option>
                                    <option value="kh/s">kh/s</option>
                                    <option value="GH">GH</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Miner:</h6>
                                <input type="text" class="form-control" name="miner" placeholder="Name of miner"
                                       id="miner">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Power coefficient:</h6>
                                <input type="number" class="form-control" name="power_coef"
                                       placeholder="Coefficient" id="power_coef" min="0" step="0.05">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editAlgo">Edit!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal remove algo -->
<div class="modal fade bd-example-modal-lg" id="removeAlgoModal" tabindex="-1" role="dialog" aria-labelledby="remove"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Removing Algo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="removeAlgo" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <select class="form-control selectize" id="algo_name_remove" name="algo_name">
                                    <option>Choose algo...</option>
                                    <? $algo = $dbh->query("SELECT name FROM algos")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($algo as $a) {
                                        echo '<option>' . $a . '</option>';
                                    }
                                    $algo = null;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="removeAlgo">Remove!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal add coin -->
<div class="modal fade bd-example-modal-lg" id="addCoinModal" tabindex="-1" role="dialog" aria-labelledby="add"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding new Coin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="addCoin" method="post">
                    <div class="form-group col-8 mx-auto">
                        <div class="row justify-content-center">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <input type="text" class="form-control" name="coin_name" placeholder="Name of Coin">
                            </div>
                            <div class="col">
                                <h6 class="text-center">Code:</h6>
                                <input type="text" class="form-control" name="code" placeholder="Code">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col">
                                <h6 class="text-center">Algo:</h6>
                                <select class="form-control selectize" name="algo">
                                    <? $algo = $dbh->query("SELECT name FROM algos")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($algo as $a) {
                                        echo '<option value="' . $a . '">' . $a . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <h6 class="text-center">Block reward:</h6>
                                <input type="number" class="form-control" name="blockreward"
                                       placeholder="Block reward">
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-auto custom-control custom-checkbox">
                                <h6>
                                    <input type="checkbox" class="form-control custom-control-input" id="rpcCheck"
                                           name="rpc">
                                    <label class="custom-control-label" for="rpcCheck">RPC</label>
                                </h6>
                            </div>
                        </div>

                        <div id="api">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">URL:</h6>
                                    <input type="text" class="form-control" name="url" placeholder="url of api">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">Parameter:</h6>
                                    <input type="text" class="form-control" name="parameter"
                                           placeholder="parameter">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">Addition:</h6>
                                    <input type="text" class="form-control" name="addition" placeholder="addition">
                                </div>
                            </div>
                        </div>
                        <div id="rpc">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">RPC user:</h6>
                                    <input type="text" class="form-control" name="rpcuser" placeholder="RPC user">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">RPC password:</h6>
                                    <input type="text" class="form-control" name="rpcpassword"
                                           placeholder="RPC password">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">RPC port:</h6>
                                    <input type="number" class="form-control" name="rpcport" placeholder="RPC port">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">RPC method:</h6>
                                    <input type="text" class="form-control" name="rpc_method"
                                           placeholder="RPC method">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">RPC parameter:</h6>
                                    <input type="text" class="form-control" name="rpc_parameter"
                                           placeholder="RPC parameter">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto custom-control custom-checkbox">
                                <h6>
                                    <input type="checkbox" class="form-control custom-control-input"
                                           id="coinmarketcapCheck"
                                           name="coinmarketcap">
                                    <label class="custom-control-label"
                                           for="coinmarketcapCheck">Coinmarketcap</label>
                                </h6>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addCoin">Add!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal edit coin -->
<div class="modal fade bd-example-modal-lg" id="editCoinModal" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editing Coin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="editCoin" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <select class="form-control selectize" id="coin_name_edit" name="coin_name">
                                    <option>Choose coin...</option>
                                    <? $coin = $dbh->query("SELECT name FROM coins")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($coin as $c) {
                                        echo '<option>' . $c . '</option>';
                                    }
                                    $coin = null;
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <h6 class="text-center">Code:</h6>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Code">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Algo:</h6>
                                <select class="form-control selectize" name="algo" id="algo">
                                    <? $algo = $dbh->query("SELECT name FROM algos")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($algo as $a) {
                                        echo '<option value="' . $a . '">' . $a . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <h6 class="text-center">Block reward:</h6>
                                <input type="number" class="form-control" name="blockreward" id="blockreward"
                                       placeholder="Block reward">
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-auto custom-control custom-checkbox">
                                <h6>
                                    <input type="checkbox" class="form-control custom-control-input"
                                           id="rpcCheckEdit"
                                           name="rpc">
                                    <label class="custom-control-label" for="rpcCheckEdit">RPC</label>
                                </h6>
                            </div>
                        </div>
                        <div id="apiEdit">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">URL:</h6>
                                    <input type="text" class="form-control" name="url" id="url"
                                           placeholder="url of api">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">Parameter:</h6>
                                    <input type="text" class="form-control" name="parameter" id="parameter"
                                           placeholder="parameter">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">Addition:</h6>
                                    <input type="text" class="form-control" name="addition" id="addition"
                                           placeholder="addition">
                                </div>
                            </div>
                        </div>

                        <div id="rpcEdit">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">RPC user:</h6>
                                    <input type="text" class="form-control" name="rpcuser" id="rpcuserEdit"
                                           placeholder="RPC user">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">RPC password:</h6>
                                    <input type="text" class="form-control" name="rpcpassword" id="rpcpasswordEdit"
                                           placeholder="RPC password">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">RPC port:</h6>
                                    <input type="number" class="form-control" name="rpcport" id="rpcportEdit"
                                           placeholder="RPC port">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-center">RPC method:</h6>
                                    <input type="text" class="form-control" name="rpc_method" id="rpcmethodEdit"
                                           placeholder="RPC method">
                                </div>
                                <div class="col">
                                    <h6 class="text-center">RPC parameter:</h6>
                                    <input type="text" class="form-control" name="rpc_parameter"
                                           id="rpcparameterEdit"
                                           placeholder="RPC parameter">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto custom-control custom-checkbox">
                                <h6>
                                    <input type="checkbox" class="form-control custom-control-input"
                                           id="coinmarketcapEdit"
                                           name="coinmarketcap">
                                    <label class="custom-control-label"
                                           for="coinmarketcapEdit">Coinmarketcap</label>
                                </h6>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editCoin">Edit!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal remove coin -->
<div class="modal fade bd-example-modal-lg" id="removeCoinModal" tabindex="-1" role="dialog" aria-labelledby="remove"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Removing Coin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="removeCoin" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <select class="form-control selectize" id="coin_name_remove" name="coin_name">
                                    <option>Choose coin...</option>
                                    <? $coin = $dbh->query("SELECT name FROM coins")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($coin as $c) {
                                        echo '<option>' . $c . '</option>';
                                    }
                                    $coin = null;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="removeCoin">Remove!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal add pool -->
<div class="modal fade bd-example-modal-lg" id="addPoolModal" tabindex="-1" role="dialog" aria-labelledby="add"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding new Pool</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="addPool" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <select name="pool_name" id="" class="form-control selectize-add-item"
                                        placeholder="Name of Pool">
                                    <? $pool = $dbh->query("SELECT DISTINCT name FROM pools")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($pool as $p) {
                                        echo '<option value="' . $p . '">' . $p . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <h6 class="text-center">Coin:</h6>
                                <select class="form-control selectize" name="coin">
                                    <? $coin = $dbh->query("SELECT code FROM coins")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($coin as $c) {
                                        echo '<option value="' . $c . '">' . $c . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Address:</h6>
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>
                            <div class="col">
                                <h6 class="text-center">Port:</h6>
                                <input type="number" class="form-control" name="port" placeholder="Port">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addPool">Add!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal edit pool -->
<div class="modal fade bd-example-modal-lg" id="editPoolModal" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editing Pool</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="editPool" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <select class="form-control selectize" name="pool" id="pool_name_edit">
                                    <option disabled>Choose pool...</option>
                                    <? $pool = $dbh->query("SELECT DISTINCT name FROM pools")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($pool as $p) {
                                        echo '<option value="' . $p . '">' . $p . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <h6 class="text-center">Coin:</h6>
                                <select class="form-control selectize" name="coin" id="coin_pool_edit">
                                    <!--                                        <option selected disabled>Choose coin...</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Address:</h6>
                                <input type="text" class="form-control" name="address" placeholder="Address"
                                       id="pool_address_edit">
                            </div>
                            <div class="col">
                                <h6 class="text-center">Port:</h6>
                                <input type="number" class="form-control" name="port" placeholder="Port"
                                       id="pool_port_edit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editPool">Edit!</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal remove pool -->
<div class="modal fade bd-example-modal-lg" id="removePoolModal" tabindex="-1" role="dialog" aria-labelledby="remove"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Removing Pool</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" id="removePool" method="post">
                    <div class="form-group col-8 text-center mx-auto">
                        <div class="row">
                            <div class="col">
                                <h6 class="text-center">Name:</h6>
                                <select class="form-control" id="pool_name_remove" name="pool_name">
                                    <option>Choose pool...</option>
                                    <? $pool = $dbh->query("SELECT DISTINCT name FROM pools")->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($pool as $p) {
                                        echo '<option>' . $p . '</option>';
                                    }
                                    $pool = null;
                                    ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <h6 class="text-center">Coin:</h6>
                                <select class="form-control" id="pool_coin_remove" name="coin_name">
                                    <option disabled selected>Choose coin...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="removePoolCoin">Delete coin from pool!</button>
                <button type="button" class="btn btn-primary" id="removePool">Delete pool completely!</button>
            </div>
        </div>
    </div>
</div>