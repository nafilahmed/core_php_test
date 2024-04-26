<div class="container marketing">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="d-flex justify-content-between">
      <h2>Azans</h2>
      <button id="add-new-btn" class="btn btn-success" >Add New</button>
      
    </div>
    <div class="table-responsive small">
      <table class="table table-sm table-hover text-center">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Audio</th>
            <th scope="col">Edit</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($azan->allData() as $key => $value) { ?>
            <tr>
              <td><?php echo $value->name ?></td>
              <td> <audio controls> <source src="<?php echo $value->path ?>" type="audio/mpeg"></audio></td>
              <td><a href='<?php echo Config::get()."?id=".$value->id ?>' data-id="<?php echo $value->id ?>" id="editBoxBtn"><i class="fa-solid fa-pencil"></i></a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal" id="editBoxModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Box</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form action="" method="post" enctype="multipart/form-data">
          <!-- Modal body -->
          <div class="modal-body">
            <div class="container-fluid" style="padding-top: 5%; padding-bottom: 5%;">
              <div class="form-group p-1">
                <label for="name">Name :</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo isset($azanData['name']) ? $azanData['name'] :  '';  ?>">
                <input type="hidden" class="form-control" name="id" value="<?php echo isset($azanData['id']) ? $azanData['id'] :  '';  ?>">
              </div>
              <div class="form-group p-1">
                <label for="path">Audio :</label>
                <input type="file" class="form-control" name="path" >
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Save</button>
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

      $("#editBoxModal").modal('show');

    }

    $('#add-new-btn').click(function(){
      $("#editBoxModal").modal('show');      
    });

    $('#editBoxModal').on('hidden.bs.modal', function () {
      if("<?php echo isset($_GET['id']); ?>"){
        window.history.back();
      }
    })

  });


</script>
