<script>
    $(document).ready(function(){
        load_first("optionslist",DT,false,true,true,0,true);
    });
    function load_options(){
        load_data("optionslist",DT,false);
    }
    function new_option(){
        $('#name').val('');
        $('#value').val('');
        $('#modal-option').modal('show');
    }
    function save_option(){
        $.post(PT,{name:$('#name').val(),value:$('#value').val()},function(data){
            alert_ok(data,'<?=D_THEME_COLOR?>!');
            load_options();
            $('#modal-option').modal('hide');
        });
    }
    function change_option(n,v){
        $.post(PT,{name:n,value:v},function(data){
            alert_ok(data,'<?=D_THEME_COLOR?>!');
            load_options();
        });
    }
</script>
<div class="container my-5">
  <!-- Section: Block Content -->
  <section>
    <div class="row">
      <div class="col-12">
      	<div class="card card-list mt-4">
          <div class="card-header <?=D_THEME_COLOR?>-color d-flex justify-content-between align-items-center py-3">
            <p class="h5-responsive font-weight-bold mb-0">Options</p>
          </div>
          <div class="card-body">
              <div class="d-flex">
                  <button class="btn btn-<?=D_THEME_COLOR?> btn-sm" onclick="new_option()"><i class="fa fa-plus"></i> New</button>
              </div>
            <?php
                if($_SESSION['id']<=0)
                    echo add_table('optionslist',array('ID','Name','Values','History'),'',false);
                else
                    echo add_table('optionslist',array('ID','Name','Values'),'',false);
            ?>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Section: Block Content -->
</div>

<!-- Central Modal Small -->
<div class="modal fade" id="modal-option" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Default input -->
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control">
        <div class="form-group">
          <label for="value">Value</label>
          <textarea class="form-control rounded-0" id="value" rows="5"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="save_option()">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Central Modal Small -->