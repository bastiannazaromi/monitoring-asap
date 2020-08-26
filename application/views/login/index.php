<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title ; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ; ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ; ?>assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ; ?>assets/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b><?= $title ; ?></b></a>
  </div>
  <!-- /.login-logo -->

  <div class="flash-sukses" data-flashdata="<?= $this->session->flashdata('flash-sukses') ; ?>"></div>
  <div class="flash-error" data-flashdata="<?= $this->session->flashdata('flash-error') ; ?>"></div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silahkan Login..</p>

      <form action="" onsubmit="ajax_login(); return false">
        <div class="input-group mb-3">
          <input type="email" id="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="social-auth-links text-center mb-3">
          <button type="submit" class="btn btn-success btn-block">Login</button>
        </div>
      </form>

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url() ; ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ; ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ; ?>assets/admin/dist/js/adminlte.min.js"></script>

<script src="<?= base_url('assets/sweetalert/sweetalert2.js') ; ?> "></script>
<script src="<?= base_url('assets/sweetalert/new_script.js') ; ?> "></script>

</body>
</html>

<script>

  function ajax_login(){
    let email = $("#email").val();
    let password = $("#password").val();
    $.ajax({
        url: "<?= base_url('Login/login') ; ?>",
        type: "POST",
        data: {
          email: email,
          password: password
        },
        success:function(result){
            if (result == 'Valid')
            {
              
              Swal.fire({
                title: 'Success',
                text: 'Login Sukses',
                icon: 'success'
              }).then((result) => {
                if (result.value) {
                  setTimeout(function ()
                  {
                    document.location.href = "<?= base_url('Dashboard') ; ?>";
                  }, 500)
                }
              });
            }
            else
            {
              Swal.fire({
                title: 'Sorry !!',
                text: result,
                icon: 'warning'
              });

              $('#email').val("");
              $('#password').val("");
            }
        }
    });
  }
  
</script>
