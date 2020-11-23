<section class="content-header">
    <h1>
        Score
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
            <button id="score-button" class="float-right btn btn-primary">Add Score</button>
            <br>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="score-table" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Subject Name</th>
                        <th>Max Marks</th>
                        <th>Marks</th>
                        <th>Created At</th>
                        <th>Opeartions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($scores as $score) { ?>
                        <tr>
                            <td> <?php echo $score->student_name ?> </td>
                            <td> <?php echo $score->subject_name; ?> </td>
                            <td> <?php echo $score->max_marks; ?> </td>
                            <td> <?php echo $score->marks; ?> </td>
                            <td><?php echo  date("d-m-Y H:i:s", strtotime($score->created_at)); ?> </td>
                            <td>
                            <?php if($rolId == '2' || $userId == $score->user_id ){ ?>
                                <a data-original-title="Edit Category Details" class="edit-std-btn tip-bottom" data-marks="<?php echo  $score->marks ?>" data-subid="<?php echo  $score->subject_id ?>" data-max="<?php echo $score->max_marks ?>" data-stdid="<?php echo  $score->student_id ?>"   data-sid="<?php echo  $score->id ?>">
                                    <em class="fa fa-edit btn btn-primary btn-xs"></em>
                                </a>
                                <a data-original-title="Delete Category Details" class="delete-std-btn tip-bottom" data-sid="<?php echo  $score->id ?>">
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
        <div class="modal right fade" id="score-modal" tabindex="-1" role="dialog" aria-labelledby="score-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Edit Score</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $attributes = ['class' => 'score-form', 'id' => 'score-form'];
                        echo form_open(base_url() . '/score', $attributes);
                        $hidden = [
                            'type'  => 'hidden',
                            'name'  => 'score_id',
                            'id'    => 'score-id',
                            'value' => '',
                        ];
                        echo form_input($hidden);
                        ?>
                        <div class="form-group">
                            <label for="student_id">Select Student: </label>
                            <select class="form-control" name="student_id" id="student-id">
                                <option value="">Select Student</option>
                                <?php foreach ($students as $student) { ?>
                                    <option value="<?php echo $student['id'] ?>"><?php echo $student['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject_id">Select Subject: </label>
                            <select class="form-control" name="subject_id" id="subject-id">
                                <option value="">Select Subject</option>
                                <?php foreach ($subjects as $subject) { ?>
                                    <option data-max="<?php echo $subject['max_marks'] ?>" value="<?php echo $subject['id'] ?>"><?php echo $subject['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="max-marks">Max Marks: </label>
                            <?php
                            $attributes = ['class' => 'form-control datepicker ', 'id' => 'max-marks', 'disabled' => ''];
                            echo form_input('max_marks', '', $attributes);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="marks">Marks: </label>
                            <?php
                            $attributes = ['class' => 'form-control', 'id' => 'marks'];
                            echo form_input('marks', '', $attributes);
                            ?>
                        </div>
                        <hr>
                        <?php
                        $attributes = ['class' => 'btn btn-primary float-left', 'id' => 'add-score'];
                        echo form_submit('add-score', 'Save', $attributes);
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
        <div class="modal " id="score-delete-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Score</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">

                        <?php
                        $attributes = ['class' => 'score-delete-form', 'method' => 'post', 'id' => 'score-delete-form'];
                        echo form_open(base_url() . '/delete-score', $attributes);
                        $dhidden = [
                            'type'  => 'hidden',
                            'name'  => 'dscore_id',
                            'id'    => 'dscore-id',
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
                                echo form_button('closr-score', 'No', $attributes);
                                ?>

                            </div>
                            <div class="col-2">
                                <?php
                                $attributes = ['class' => 'btn btn-danger', 'id' => 'delete-score'];
                                echo form_submit('delete-score', 'Yes', $attributes);
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
        var table = $('#score-table').DataTable({
            responsive: true
        });
        $('#subject-id').on('change', function() {
            var max_marks = $('#subject-id option:selected').data('max');
            $('#max-marks').val(max_marks);
        });
        //add score
        $("#score-button").click(function() {
            $('#score-id').val("");
            $("#score-form")[0].reset();
            $('#score-modal').modal('show');
        });
        //delete  score
        $(".delete-std-btn").click(function() {

            $('#dscore-id').val($(this).attr('data-sid'));
            $('#score-delete-modal').modal('show');
        });
        //edit score
        $(".edit-std-btn").click(function() {
            $("#score-id").val($(this).attr('data-sid'));
            $("#student-id").val($(this).attr('data-stdid'));
            $("#subject-id").val($(this).attr('data-subid'));
            $('#max-marks').val($(this).attr('data-max'));
            $('#marks').val($(this).attr('data-marks'));
            $('#score-modal').modal('show');
        });
    });
</script>