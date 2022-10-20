<main>
	<div class="container">
		<section class="section">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css"
          type="text/css">
    <script src="//unpkg.com/leaflet-gesture-handling"></script>
<div class="container-fluid">
    <div class="container">
                <h3>Datum Transformation</h3><br>
        <h4><b>Survey List Available</b></h4><br>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th>Survey ID</th>
                        <th>Survey Name</th>
                        <th>Survey Date</th>
                        <th>Old Datum</th>
                        <th>New Datum</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
<?php
$data=$dbg->get_results("SELECT * FROM datums");$sv=array();foreach($data as $k => $v)$sv[$v->id_datum]=$v->datum_name;
$data=$dbg->get_results("SELECT survey_name,survey_date,id_old_datum,id_new_datum,description,id_survey FROM surveys");foreach($data as $k => $v){?>
                    <tr>
                        <td><?=$v->id_survey?></td>
                        <td><?=$v->survey_name?></td>
                        <td><?=$v->survey_date?></td>
                        <td><?=$sv[$v->id_old_datum]?></td>
                        <td><?=$sv[$v->id_new_datum]?></td>
                        <td><?=$v->description?></td>
                        <td><a href="/<?=D_PAGE.'/'.$v->id_survey?>"><span class="fa fa-edit tableButton" title="edit" style="cursor: pointer; font-size: 20px;"></span></a></td>
                    </tr>
<?php }?>
                </table>
            </div>
            <div class="col-12">
                <div style="text-align: right;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#Modal-addDatum"><span class="fa fa-plus"></span> New Datum</button>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div id="Modal-addDatum" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
        <!-- Modal content -->
        <div class="modal-content" style="border-radius: 7px;">
            <div class="modal-header">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 90%; border: none; padding: 0px;"><h3 style="">Add New Survey</h3></td>
                        <td style="width: 10%; border: none; padding: 0px; text-align: right;"><span class="close" onclick="cancel()" data-dismiss="modal">&times;</span></td>
                    </tr>
                </table>
            </div><br>
            <div class="modal-body">
                <form method="POST" action="/<?=D_PAGE?>">
                    <label>Survey Name</label>
                    <input type="text" name="survey_name" class="form-control" required><br>
                    <label>Survey Date</label>
                    <input type="date" name="survey_date" class="form-control" required><br>
                    <label>Old Datum</label>
                    <select name="old_datum" id="datum_lama" class="form-control" required>
<?php $data=$dbg->get_results("SELECT id_datum,datum_name FROM datums ");
foreach($data as $k => $v){?>
                        <option value="<?=$v->id_datum?>"><?=$v->datum_name?></option>
<?php }?>
                    </select><br><br>
                    <label>New Datum</label>
                    <select name="new_datum" id="datum_lama" class="form-control" required>
<?php foreach($data as $k => $v){?>
                        <option value="<?=$v->id_datum?>"><?=$v->datum_name?></option>
<?php }?>
                    </select><br><br>
                    <label>description</label>
                    <input name="description" type="text" class="form-control" required><br>
                    <button type="submit" class="btn btn-primary btn-md">Tambah</button>
                    <button type="button" class="btn btn-danger btn-md" onclick="cancel()" data-dismiss="modal">cancel</button>
                </form><br><br>
            </div>
        </div>
        </div>
    </div>
    <script type="text/javascript">
        // Get the modal
        var modal;

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function cancel(){
            modal.style.display = "none";
        }

    </script>
</div>
		</section>
	</div>
</main>

<div style="text-align: center;">
