<div class="container marketing">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    <h2>Subscribe Your Box</h2>
    <div class="table-responsive small">
      <table class="table table-sm table-hover text-center">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Time Zone</th>
            <th scope="col">Azan</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($boxSubscriptions->allData() as $key => $value) { ?>
            <tr>
              <td><?php echo $value->name ?></td>
              <td><?php echo $value->time_zone ?></td>
              <td><audio controls> <source src="<?php echo $value->path ?>" type="audio/mpeg"></audio></td>
              <td><a class="btn btn-success" href='<?php echo Config::get()."?id=".$value->box_id ?>' id="subscribeBoxBtn"><?php echo ($value->user_id == $user->data()->id ) ? 'Subscribed' : 'Subscribe' ?> </a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal" id="subscribeBoxModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <h4 class="modal-title text-center">Are You Sure</h4>
        <form action="" method="post">
          <!-- Modal body -->
          <div class="modal-body">
            <div class="container-fluid text-center" style="padding-top: 5%; padding-bottom: 5%;">
              <div class="form-group p-1">
                <input type="hidden" class="form-control" name="box_id" value="<?php echo isset($boxData['id']) ? $boxData['id'] :  '';  ?>">
              </div>
              <div class="form-group p-1">
                <button type="submit" class="btn btn-success">Confirm</button>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>

  <hr class="featurette-divider">
</div>


<script type="text/javascript">
  $(document).ready(function(){
    var id = 0;

    if("<?php echo isset($_GET['id']); ?>"){

      $("#subscribeBoxModal").modal('show');

    }

    $('#add-new-btn').click(function(){
      $("#subscribeBoxModal").modal('show');      
    });

    $('#subscribeBoxModal').on('hidden.bs.modal', function () {
      if("<?php echo isset($_GET['id']); ?>"){
        window.history.back();
      }
    })

  });


</script>
