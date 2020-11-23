<style>
 
body{
    background-color: #e1e1e1;
  }
</style> 
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3>Login</h3>
                <hr>
                <?php
                $attributes = ['class' => 'login', 'id' => 'login'];
                echo form_open(base_url(), $attributes);
                ?>
                <div class="form-group">
                    <label for="email">Email address: </label>
                    <?php
                    $attributes = ['class' => 'form-control', 'id' => 'email', 'name' => 'email'];
                    echo form_input('email', '', $attributes);
                    ?>
                </div>
                <div class="form-group">
                    <label for="password">password: </label>
                    <?php
                    $attributes = ['type'=> 'text','class' => 'form-control', 'id' => 'password', 'name' => 'password'];
                    echo form_password('password', '', $attributes);
                    ?>
                </div>
                <?php if (isset($validation)) : ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <?php
                        $attributes = ['class' => 'btn btn-primary','id' => 'login-button'];
                        echo form_submit('login-button', 'Login', $attributes);
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

