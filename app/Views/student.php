<section class="content-header">
  <h1>
    Student
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
      <button id="student-button" class="float-right btn btn-primary">Add Student</button>
      <br>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <table id="student-table" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Dob</th>
            <th>Address</th>
            <th>Created At</th>
            <th>Opeartions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student) { ?>
            <tr>
              <td> <?php echo $student['name']; ?> </td>
              <td> <?php echo $student['email']; ?> </td>
              <td> <?php echo  date("d-m-Y", strtotime($student['dob'])); ?> </td>
              <td> <?php echo $student['address']; ?> </td>
              <td><?php echo  date("d-m-Y H:i:s", strtotime($student['created_at'])); ?> </td>
              <td>
              <?php if($rolId == '2' || $userId == $student['user_id'] ){ ?>
                <a data-original-title="Edit Category Details" class="edit-std-btn tip-bottom" data-sdob="<?php echo  date("d-m-Y", strtotime($student['dob'])); ?>" data-saddress="<?php echo $student['address'] ?>" data-sname="<?php echo $student['name'] ?>" data-semail="<?php echo  $student['email']; ?>" data-sid="<?php echo  $student['id'] ?>">
                  <em class="fa fa-edit btn btn-primary btn-xs"></em>
                </a>
                <a data-original-title="Delete Category Details" class="delete-std-btn tip-bottom" data-sid="<?php echo  $student['id'] ?>">
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
    <div class="modal right fade" id="student-modal" tabindex="-1" role="dialog" aria-labelledby="student-modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add/Edit Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php
            $attributes = ['class' => 'student-form', 'id' => 'student-form'];
            echo form_open(base_url() . '/student', $attributes);
            $hidden = [
              'type'  => 'hidden',
              'name'  => 'student_id',
              'id'    => 'student-id',
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
              <label for="email">Email: </label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'email', 'name' => 'email'];
              echo form_input('email', '', $attributes);
              ?>
            </div>
            <div class="form-group">
              <label for="dob">Dob: </label>
              <?php
              $attributes = ['class' => 'form-control datepicker', 'id' => 'dob'];
              echo form_input('dob', '', $attributes);
              ?>
            </div>
            <div class="form-group">
              <label for="address">Address: </label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'address'];
              echo form_input('address', '', $attributes);
              ?>
            </div>
            <hr>
            <?php
            $attributes = ['class' => 'btn btn-primary float-left', 'id' => 'add-student'];
            echo form_submit('add-student', 'Save', $attributes);
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
    <div class="modal " id="student-delete-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">

            <?php
            $attributes = ['class' => 'student-delete-form','method' => 'post', 'id' => 'student-delete-form'];
            echo form_open(base_url() . '/delete-student', $attributes);
            $dhidden = [
              'type'  => 'hidden',
              'name'  => 'dstudent_id',
              'id'    => 'dstudent-id',
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
                echo form_button('closr-student', 'No', $attributes);
                ?>

              </div>
              <div class="col-2">
                <?php
                $attributes = ['class' => 'btn btn-danger', 'id' => 'delete-student'];
                echo form_submit('delete-student', 'Yes', $attributes);
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
    var table = $('#student-table').DataTable({
      responsive: true
    });
    //add student
    $("#student-button").click(function() {
      $('#student-id').val("");
      $("#student-form")[0].reset();
      $('#student-modal').modal('show');
    });
    //delete  student
    $(".delete-std-btn").click(function() {

      $('#dstudent-id').val($(this).attr('data-sid'));
      $('#student-delete-modal').modal('show');
    });
    //edit student
    $(".edit-std-btn").click(function() {
      $("#name").val($(this).attr('data-sname'));
      $("#email").val($(this).attr('data-semail'));
      $('#dob').val($(this).attr('data-sdob'));
      $('#address').val($(this).attr('data-saddress'));
      $('#student-id').val($(this).attr('data-sid'));
      $('#student-modal').modal('show');
    });
  });
</script>