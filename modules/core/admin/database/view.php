<script>
    $(document).ready(function () {
        load_first("databaselist",DT+'?dbl=-',false,true,true,0,true);
    });
	// DATABASE
	var querydbname='';
	var querytbname='';
	function new_database(){
		$('#nama-database').val('');
		$('#variable-database').val('');
	}
	var dbex_=0;
	function save_database(){
		var apl=$('#apl_db').val();
		$.post(PT,{newdatabase:apl,nama:$('#nama-database').val(),variable:$('#variable-database').val(),act:dbex_},function(data){
			alert_ok(data,'OK');
			$('#modal-new-database').modal('hide');
        	/*setTimeout(function(){
            	load_database_list();
            },3000);//*/
		});
	}
	function load_database_list(){
		load_data("databaselist",DT+'?dbl='+$('#apl_db').val(),false);
		if($('#apl_db').val()!=null){
			$('#btn-new-database').show();
		}
	}
	function load_db_structure(db,tb){
		querydbname=db;
		querytbname=tb;
		$('#rtsss').attr('class','col-lg-9 col-md-8');
		$.get(DT,{dbs:db,struct:tb},function(data){
			$('#db-structure').val(data);
			$('#strrr').show();
		})
	}
	function go_query(){
		var q=$('#db-query').val();
		$.post(PT,{query:q,db:querydbname},function(data){
			$('#db-query-result').html(data);
		});
	}
    function dwnload(v){
        document.location=DT+'?exportdb='+v;
    }
    function force_query(v){
        querydbname=v;
        $('#strrr').hide();
        $('#rtsss').attr('class','col-12');
    }
</script>

              <div class="tab-pane fade" id="panel3" role="tabpanel">
              	<div class="row">
              		<div class="col-lg-6">
						<select class="mdb-select colorful-select dropdown-<?=$ath?> md-form" id="apl_db" onchange="load_database_list()" searchable="Search here..">
							<option disabled selected>Select</option>
						</select>
						<label class="mdb-main-label">Application</label>
					</div>
					<div class="col-lg-3" style="display: none;" id="btn-new-database">
						<!--Blue select-->
						<select class="mdb-select md-form colorful-select dropdown-primary" id="select-dbe" onchange="exec_db_(this.value)">
							<option value="1">Create Database</option>
							<option value="2">Add Database</option>
							<option value="3">Export Database</option>
						</select>
						<label class="mdb-main-label">Actions</label>
						<!--/Blue select-->
              		</div>
              	</div>
              	<div class="row">
              		<div class="col-12">
              			<?=add_table('databaselist',array('Database name','Variable','Tables','Example','Download'),'',false);?>
              		</div>
              	</div>
              </div>

        <div class="modal fade" id="modal-new-database" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog cascading-modal modal-sm" role="document">
            <!-- Content -->
            <div class="modal-content">

              <!-- Modal cascading tabs -->
              <div class="modal-c-tabs">

                <!-- Tab panels -->
                <div class="tab-content">
                  <!-- Panel 17 -->
                  <div class="tab-pane fade in show active" role="tabpanel">
                    <!-- Body -->
                    <div class="modal-body mb-1 dbname-1">
                    	<h5>New Database</h5>
                      <div class="md-form form-sm">
                        <input type="text" class="form-control form-control-sm" id="nama-database">
                        <label for="nama-database">Name</label>
                      </div>
                      <div class="md-form form-sm">
                        <input type="text" class="form-control form-control-sm" id="variable-database">
                        <label for="variable-database">Variable</label>
                      </div>
                      <div class="text-center mt-2">
                        <button class="btn btn-info btn-sm" onclick="save_database()">Add <i class="fa fa-plus"></i></button>
                        <button class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- Content -->
          </div>
        </div>


<script>
	function exec_db_(v){
    	dbex_=v;
		if(v=='1'||v=='2'){
        	if(v=='1')
            	var titel='Create Database';
        	else
            	var titel='Add Database';
        	$('.dbname-1 h5').html(titel);
			$('#modal-new-database').modal('show');
		}else
		    document.location=DT+'?exportdbs='+$('#apl_db').val();
	}
</script>


              					<div id="tmpct" style="display:none">
CREATE TABLE `contoh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field1` varchar(100) NOT NULL,
  `field2` text DEFAULT NULL,
  `field3` date NOT NULL,
  `field4` tinyint(4) NOT NULL,
  `field5` smallint(6) NOT NULL,
  `field6` mediumint(9) NOT NULL,
  `field7` bigint(20) NOT NULL,
  `field8` decimal(10,0) NOT NULL,
  `field9` float NOT NULL,
  `field10` double NOT NULL,
  `field11` blob NOT NULL,
  `field12` multipoint NOT NULL,
  `field13` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `field14` binary(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4
              					</div>


        <div class="modal fade bottom" id="db_query" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true" data-backdrop="false">
          <div class="modal-dialog modal-fluid modal-notify modal-<?=$ath?>" role="document">
            <!-- Content -->
            <div class="modal-content">
              <!-- Header -->
              <div class="modal-header white-text">
                Query
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="white-text">&times;</span>
                </button>
              </div>

              <!-- Body -->
              <div class="modal-body">
              	<div class="row">
              		<div class="col-lg-3 col-md-4" id="strrr">
              			<div class="card card-cascade">
              				<div class="card-body">
              					<textarea class="md-textarea form-control" rows="8" id="db-structure" wrap="off"></textarea>
              					<span class="badge badge-info" onclick="select_copy('db-structure')">Copy to clipboard</span>
              				</div>
              			</div>
              		</div>
              		<div class="col-lg-9 col-md-8" id="rtsss">
              			<div class="row">
              				<div class="col-12">
		              			<div class="card card-cascade">
		              				<div class="card-body">
<script>
    function exec_db_tb(v){
        switch(v){
            case '10':
                $('#db-query').val('SELECT * FROM '+querytbname+' WHERE 1=1 ORDER BY id ASC LIMIT 0,10;');
                break;
            case '11':
                $('#db-query').val('INSERT INTO '+querytbname+' () VALUES ();');
                break;
            case '12':
                $('#db-query').val('UPDATE '+querytbname+' SET email=\'\' WHERE id=0;');
                break;
            case '1':
                $('#db-query').val('');
                break;
            case '2':
                $('#db-query').val('DROP TABLE '+querytbname+';'); 
                break;
            case '3':
                $('#db-query').val('TRUNCATE TABLE '+querytbname+';'); 
                break;
            case '4':
                $('#db-query').val('ALTER TABLE '+querytbname+' RENAME TO new_'+querytbname+';'); 
                break;
            case '5':
                $('#db-query').val('ALTER TABLE '+querytbname+' ADD Email varchar(255);'); 
                break;
            case '6':
                $('#db-query').val('ALTER TABLE '+querytbname+' DROP COLUMN Email;'); 
                break;
            case '7':
                $('#db-query').val('ALTER TABLE '+querytbname+' MODIFY COLUMN Email varchar(255);'); 
                break;
            case '8':
                $('#db-query').val($('#tmpct').html()); 
                break;
            case '9':
                document.location=DT+'?exporttb='+querytbname+'&db='+querydbname;
                break;
            case '13':
                $('#db-query').val('ALTER TABLE '+querytbname+' CHANGE original_column_name new_column_name VARCHAR(100) NOT NULL; '); 
                break;
        }
    }
</script>
                						<select class="browser-default custom-select" onchange="exec_db_tb(this.value)">
                							<option value="1">Query</option>
                							<option value="10">SELECT</option>
                							<option value="11">INSERT</option>
                							<option value="12">UPDATE</option>
                							<option value="8">Create Table</option>
                							<option value="9">Export Table</option>
                							<option value="2">Drop Table</option>
                							<option value="3">Empty Table</option>
                							<option value="4">Modify Tablename</option>
                							<option value="5">Add Column</option>
                							<option value="6">Drop Column</option>
                							<option value="7">Modify Column</option>
                							<option value="13">Change Column</option>
                						</select>
		              					<div class="md-form form-sm" style="margin-bottom: 0;">
		              						<textarea class="md-textarea form-control" id="db-query"></textarea>
		              						<label class="active">Query</label>
		              					<button class="btn btn-sm btn-<?=$ath?> float-right" style="margin-bottom: -10px" onclick="go_query()">Go</button>
		              					</div>
		              				</div>
		              			</div>
		              		</div>
              			</div>
              			<div class="row mt-2">
	              			<div class="col-12">
		              			<div class="card card-cascade">
		              				<div class="card-body">
		              					<pre id="db-query-result"></pre>
		              				</div>
		              			</div>
		              		</div>
		              	</div>
              		</div>
              	</div>
              </div>

            </div>
            <!-- Content -->
          </div>
        </div>
