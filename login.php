<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="#"> <i class="fas fa-fw fa-user" style="font-size:70px;"></i></a><span class="splash-description">Veillez entrer vos informations !</span></div>
            <div class="card-body">
                <form action="controller/log.php" method="post">
                    <div class="input-group mb-3">
					<span class="input-group-text"><i class="fa fa-envelope"></i></span>
					<input class="form-control form-control-lg" name="emailconnect" type="text" placeholder="Email ou identifiant" autocomplete="off">
                    </div>
                    <div class="input-group mb-3">
					<span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input class="form-control form-control-lg" name="mdpconnect" id="password" type="password" placeholder="Password">
						<span class="input-group-text"><i class="fa fa-eye-slash" id="togglePassword" style="cursor: pointer"></i></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="rememberme"><span class="custom-control-label">Se souvenir de moi !</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">SE CONNECTER</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0" align="center">
			  <?php  if(isset($_SESSION['message_delete'])){?>
	<div class="alert alert-danger" <?=$_SESSION['msg_type_delete'] ?> align="center">
	<?php 
	echo $_SESSION['message_delete'];
	unset($_SESSION['message_delete']);
	?>
	</div>
	<?php }?>
                <div class="card-footer-item card-footer-item-bordered" >
                    <a href="email_recupe.php" class="footer-link">Mot de passe oublié ?</a>
                </div>
				 
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	<script language="JavaScript">
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener("click", function () {
   
  // toggle the type attribute
  const type = password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);
  // toggle the eye icon
  this.classList.toggle('fa-eye');
  this.classList.toggle('fa-eye-slash');
});
</script>
</body>
 
</html>