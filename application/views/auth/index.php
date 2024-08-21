<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/img/profile/logo.jpeg'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/style/style1.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap2/css/bootstrap.min.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #ffffff; /* White background for the entire page */
        }
        .container {
            background-color: #ffffff; /* White background for the container, if needed */
        }
    </style>
    <title>Login - SPKMIATTAUBAH</title>
</head>
<body>
<div class="container" style="margin-top: 40px;">
    <div class="row">
        <div class="col mt-5">
            <div>
                <h4 class="pt-1"><strong> SISTEM PENDUKUNG KEPUTUSAN <br> PENERIMAAN DANA BANTUAN PENDIDIKAN<br> MADRASAH IBTIDAIYAH AT-TAUBAH</strong> </h4>
            </div>
            <div class="img">
                <img src="<?= base_url('assets/img/home.png'); ?>" height="400">
            </div>
        </div>
        <div class="col-4" style="margin-top: 90px;">
					
            <div class="mt-3">
                <div>
                    <h6>Silahkan login untuk masuk kedalam sistem</h6>
                </div>
                <?php if ($this->session->flashdata('titleFlash')) : ?>
                <div class="alert alert-<?= $this->session->flashdata('colorFlash'); ?> alert-dismissible fade show m-3" role="alert">
                    <strong><?= $this->session->flashdata('titleFlash'); ?>!</strong> <?= $this->session->flashdata('captionFlash'); ?>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif ?>
                <div class="p-1">
                    <form class="user" action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="inputEmail" name="inputEmail" placeholder="Enter Email Address..." value="<?= set_value('inputEmail'); ?>">
                            <?= form_error('inputEmail', '<div class="small text-danger ml-3">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="inputPassword" name="inputPassword" placeholder="Password">
                            <?= form_error('inputPassword', '<div class="small text-danger ml-3">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="showPassword">
                                <label class="custom-control-label" for="showPassword">Show Password</label>
                            </div>
                        </div>
                        <button type="submit" id="btnLogin" name="btnLogin" class="btn btn-primary btn-user btn-block">Login</button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="<?= base_url('auth/forgot_password'); ?>">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: jQuery, Bootstrap JS, etc. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Your other scripts -->
<script>
    $(document).ready(function () {
        let no = 1;
        $('#showPassword').on('click', function () {
            if (no % 2 === 0) {
                $('#inputPassword').attr('type', 'password');
            } else {
                $('#inputPassword').attr('type', 'text');
            }
            no++;
        });
    });
</script>
</body>
</html>
