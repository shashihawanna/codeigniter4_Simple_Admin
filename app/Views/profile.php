<div class="container">
  <div class="row">
    <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3><?= $user['firstname'] . ' ' . $user['lastname'] ?></h3>
        <hr>
        <?php if (session()->get('success')) : ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php
        endif;
        if (!empty($user['profile_url'])) :
        ?>
          <img src="<?php  echo base_url().'/uploads/'.$user['profile_url'] ?>" alt="Avatar" class="avatar">
        <?php
        endif;
        $attributes = ['class' => 'profile-form', 'method' => 'post', 'id' => 'profile-form', 'enctype' => 'multipart/form-data'];
        echo form_open(base_url() . '/profile', $attributes);
        $dhidden = [
          'type'  => 'hidden',
          'name'  => 'duser_id',
          'id'    => 'duser-id',
          'value' => '',
        ];
        echo form_input($dhidden);
        ?>
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label for="firstname">First Name</label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'firstname'];
              echo form_input('firstname', $user['firstname'], $attributes);
              ?>

            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label for="lastname">Last Name</label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'lastname'];
              echo form_input('lastname', $user['lastname'], $attributes);
              ?>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <label for="email">Email address</label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'email', 'name' => 'email', 'readonly' => ''];
              echo form_input('email', $user['email'], $attributes);
              ?>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <label>Profile Picture</label>
              <input type="file" name="profile_url" class="form-control">
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label for="password">Password</label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'password', 'name' => 'password'];
              echo form_password('password', '', $attributes);
              ?>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label for="password_confirm">Confirm Password</label>
              <?php
              $attributes = ['class' => 'form-control', 'id' => 'password_confirm', 'name' => 'password_confirm'];
              echo form_password('password_confirm', '', $attributes);
              ?>
            </div>
          </div>
          <?php if (isset($validation)) : ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <div class="row">
          <div class="col-12 col-sm-4">
            <?php
            $attributes = ['class' => 'btn btn-primary', 'id' => 'update-users'];
            echo form_submit('delete-users', 'Update', $attributes);
            echo form_close();
            ?>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>