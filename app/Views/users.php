<?php if ($rolId == '2') { ?>
    <section class="content-header">
        <h1>
            Users
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
                <button id="users-button" class="float-right btn btn-primary">Add Users</button>
                <br>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table id="users-table" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Created At</th>
                            <th>Opeartions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allUser as $user) { ?>
                            <tr>
                                <td> <?php echo $user['id']; ?> </td>
                                <td> <?php echo $user['firstname']; ?> </td>
                                <td> <?php echo $user['lastname']; ?> </td>
                                <td> <?php echo $user['email']; ?> </td>
                                <td> <?php $key = array_search($user['user_role_id'], array_column($allRoles, 'id'));
                                        echo $allRoles[$key]['role_name'];  ?> </td>
                                <td><?php echo  date("d-m-Y H:i:s", strtotime($user['created_at'])); ?> </td>
                                <td>
                                    <?php if ($rolId != '1') { ?>
                                        <a data-original-title="Edit Users " class="edit-user-btn tip-bottom" data-ufname="<?php echo $user['firstname'] ?>" data-ulname="<?php echo $user['lastname'] ?>" data-uemail="<?php echo $user['email'] ?>" data-roleid="<?php echo  $user['user_role_id'] ?>" data-uid="<?php echo  $user['id'] ?>">
                                            <em class="fa fa-edit btn btn-primary btn-xs"></em>
                                        </a>
                                        <a data-original-title="Delete Users" class="delete-user-btn tip-bottom" data-uid="<?php echo  $user['id'] ?>">
                                            <em class="fa fa-trash btn btn-danger btn-xs"></em>
                                        </a>
                                </td>
                            <?php } else {
                                        echo "No access";
                                    } ?>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal right fade" id="users-modal" tabindex="-1" role="dialog" aria-labelledby="users-modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add/Edit users</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $attributes = ['class' => 'users-form', 'id' => 'users-form','enctype' => 'multipart/form-data'];
                            echo form_open(base_url() . '/register', $attributes);
                            $hidden = [
                                'type'  => 'hidden',
                                'name'  => 'user_id',
                                'id'    => 'users-id',
                                'value' => '',
                            ];
                            echo form_input($hidden);
                            ?>
                            <div class="form-group">
                                <label for="firstname">First Name: </label>
                                <?php
                                $attributes = ['class' => 'form-control', 'id' => 'firstname'];
                                echo form_input('firstname', '', $attributes);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="lastname ">Last Name: </label>
                                <?php
                                $attributes = ['class' => 'form-control', 'id' => 'lastname'];
                                echo form_input('lastname', '', $attributes);
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
                                <label for="ut_id">Select User Type: </label>
                                <select class="form-control" name="ut_id" id="ut-id">
                                    <option value="">Select User Type</option>
                                    <?php foreach ($allRoles as $role) { ?>
                                        <option value="<?php echo $role['id'] ?>"><?php echo $role['role_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Profile Picture</label>
                                <input type="file" name="profile_url" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <?php
                                $attributes = ['class' => 'form-control', 'id' => 'password', 'name' => 'password'];
                                echo form_password('password', '', $attributes);
                                ?>
                            </div>


                            <div class="form-group">
                                <label for="password_confirm">Confirm Password</label>
                                <?php
                                $attributes = ['class' => 'form-control', 'id' => 'password_confirm', 'name' => 'password_confirm'];
                                echo form_password('password_confirm', '', $attributes);
                                ?>
                            </div>

                            <hr>
                            <?php
                            $attributes = ['class' => 'btn btn-primary float-left', 'id' => 'add-users'];
                            echo form_submit('add-users', 'Save', $attributes);
                            echo form_close();
                            ?>

                        </div>
                    </div>

                </div>
            </div>
            <!-- modal -->

            <!-- Modal -->
            <div class="modal " id="users-delete-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete users</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">

                            <?php
                            $attributes = ['class' => 'users-delete-form', 'method' => 'post', 'id' => 'users-delete-form'];
                            echo form_open(base_url() . '/delete-users', $attributes);
                            $dhidden = [
                                'type'  => 'hidden',
                                'name'  => 'duser_id',
                                'id'    => 'duser-id',
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
                                    echo form_button('close-users', 'No', $attributes);
                                    ?>

                                </div>
                                <div class="col-2">
                                    <?php
                                    $attributes = ['class' => 'btn btn-danger', 'id' => 'delete-users'];
                                    echo form_submit('delete-users', 'Yes', $attributes);
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
            var table = $('#users-table').DataTable({
                responsive: true
            });
            //add users
            $("#users-button").click(function() {
                $('#email').prop('readonly', false);
                $('#password').rules('add', {
                    required: true
                });
                $('#password_confirm').rules('add', {
                    required: true
                });
                $('#users-id').val("");
                $("#users-form")[0].reset();
                $('#users-modal').modal('show');
            });
            //delete  users
            $(".delete-user-btn").click(function() {

                $('#duser-id').val($(this).attr('data-uid'));
                $('#users-delete-modal').modal('show');
            });
            //edit users
            $(".edit-user-btn").click(function() {
                $('#email').prop('readonly', true);
                $('#password').rules('add', {
                    required: false // overwrite an existing rule
                });
                $('#password_confirm').rules('add', {
                    required: false // overwrite an existing rule
                });
                $("#firstname").val($(this).attr('data-ufname'));
                $('#lastname').val($(this).attr('data-ulname'));
                $('#email').val($(this).attr('data-uemail'));
                $('#ut-id').val($(this).attr('data-roleid'));
                $('#users-id').val($(this).attr('data-uid'));
                $('#users-modal').modal('show');
            });
        });
    </script>
<?php } else {
    echo "No access";
} ?>