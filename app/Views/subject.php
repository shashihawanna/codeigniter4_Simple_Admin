<section class="content-header">
  <h1>
    Subject
    <small>Hello, <?= session()->get('firstname') ?></small>
  </h1>
</section>

<div class="container">
  <div class="row">
    <div class="col-12">
      <?php if (isset($validation)) : ?>
        <div class="col-12">
          <div class="alert alert-danger" role="alert">
            <?= $validation->listErrors() ?>
          </div>
        </div>
      <?php endif; ?>
      <button id="subject-button" class="float-right btn btn-primary">Add Subject</button>
      <br>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <table id="subject-table" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Max Marks</th>
            <th>Created At</th>
            <th>Opeartions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($subjects as $subject) { ?>
            <tr>
              <td> <?php echo $subject['name']; ?> </td>
              <td> <?php echo $subject['max_marks']; ?> </td>
              <td><?php echo  date("d-m-Y H:i:s", strtotime($subject['created_at'])); ?> </td>
              <td>
                <?php if($rolId != '1'){ ?>
                <a data-original-title="Edit Subject " class="edit-sub-btn tip-bottom"  data-sname="<?php echo $subject['name'] ?>" data-smark="<?php echo $subject['max_marks'] ?>" data-sid="<?php echo  $subject['id'] ?>">
                  <em class="fa fa-edit btn btn-primary btn-xs"></em>
                </a>
                <a data-original-title="Delete Subject" class="delete-sub-btn tip-bottom" data-sid="<?php echo  $subject['id'] ?>">
                  <em class="fa fa-trash btn btn-danger btn-xs"></em>
                </a>
              </td>
                <?php }else{ echo "No access"; } ?>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div class="modal right fade" id="subject-modal" tabindex="-1" role="dialog" aria-labelledby="subject-modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add/Edit subject</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php
            $attributes = ['class' => 'subject-form', 'id' => 'subject-form'];
            echo form_open(base_url() . '/subject', $attributes);
            $hidden = [
              'type'  => 'hidden',
              'name'  => 'subject_id',
              'id'    => 'subject-id',
              'value' => '',
            ];
            echo form_input($hidden);
            ?>
            <div class="form-group">
              <label for="name">Name: </label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'name'];
              echo form_input('name', '', $attributes);
              ?>
            </div>
            
            <div class="form-group">
              <label for="max_marks">Max Marks: </label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'max-marks'];
              echo form_input('max_marks', '', $attributes);
              ?>
            </div>
            <hr>
            <?php
            $attributes = ['class' => 'btn btn-primary float-left', 'id' => 'add-subject'];
            echo form_submit('add-subject', 'Save', $attributes);
            echo form_close();
            ?>

            <div class="modal-footer-fixed">

            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- modal -->

    <!-- Modal -->
    <div class="modal " id="subject-delete-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete subject</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">

            <?php
            $attributes = ['class' => 'subject-delete-form','method' => 'post', 'id' => 'subject-delete-form'];
            echo form_open(base_url() . '/delete-subject', $attributes);
            $dhidden = [
              'type'  => 'hidden',
              'name'  => 'dsubject_id',
              'id'    => 'dsubject-id',
              'value' => '',
            ];
            echo form_input($dhidden);
            ?>
            <p>Are you sure to delete this Record ?</p>
            <hr>
            <div class="row">
              <div class="col-2">
              <?php
                $attributes = ['class' => 'btn btn-primary', 'data-dismiss' => 'modal'];
                echo form_button('close-subject', 'No', $attributes);
                ?>

              </div>
              <div class="col-2">
                <?php
                $attributes = ['class' => 'btn btn-danger', 'id' => 'delete-subject'];
                echo form_submit('delete-subject', 'Yes', $attributes);
                echo form_close();
                ?>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
    <!-- modal -->


  </div>
</div>
</div>

<script>
  $(document).ready(function() {

    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
      endDate: '+0d',
      autoclose: true
    });
    var table = $('#subject-table').DataTable({
      responsive: true
    });
    //add subject
    $("#subject-button").click(function() {
      $('#subject-id').val("");
      $("#subject-form")[0].reset();
      $('#subject-modal').modal('show');
    });
    //delete  subject
    $(".delete-sub-btn").click(function() {

      $('#dsubject-id').val($(this).attr('data-sid'));
      $('#subject-delete-modal').modal('show');
    });
    //edit subject
    $(".edit-sub-btn").click(function() {
      $("#name").val($(this).attr('data-sname'));
      $('#max-marks').val($(this).attr('data-smark'));
      $('#subject-id').val($(this).attr('data-sid'));
      $('#subject-modal').modal('show');
    });
  });
</script>