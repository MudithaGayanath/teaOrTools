<?php
    include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="bootstrap.css" />
    <title>Login | Tea or Tools</title>
</head>
<body onload="active(4);">

    <div class="container">
      
    <div class=" text-center sticky-top sp d-none" id="spin">
          <div class="spinner-border position-absolute text-primary" style="width: 8rem; height: 8rem;"  role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
        <h1 class=" text-center">Login</h1>
        <?php
        $email ="";
        $pass = "";

        if ( isset($_COOKIE["email"]) && isset($_COOKIE["pass"]) ) {
          $email = $_COOKIE["email"] ;
          $pass = $_COOKIE["pass"];
        }
        ?>
        <div class="row">
            <div class="col-12  col-lg-6">
                <img src="img/login.jpg" alt="" class="w-100" ondblclick="goToAdminLogin();" />
            </div>
            <div class="col-12 col-lg-6 mt-lg-5">
                <div class="row">
                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="<?php echo($email);?>"  class=" form-control"/>
                    </div>
                    <div class="col-12">
                        <label for="pw">Password</label>
                        <input type="password" id="pw" value="<?php echo($pass);?>"  class=" form-control"/>
                    </div>
                    <div class="col-6 mt-2">
                        <input type="checkbox" id="rme"  class=" form-check-input"  />
                        <label for="rme">Remember Me</label>
                    </div>
                    <div class="col-6 mt-2 text-end">
                       <a onclick="forget();">Forgot Passowrd?</a>
                    </div>
                    <button class="btn btn-primary col-10 offset-1 mt-2" onclick="login();"  >Login</button>
                    <button class="btn btn-warning col-10 offset-1 mt-2" onclick="regiter();">New to here</button>
                    
                </div>
            </div>
        </div>
        
    </div>
    <div class="modal" tabindex="-1" id="npm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reset Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label for="vc">Verification Code</label>
            <input type="text" class=" form-control" id="vc" />
          </div>
          <div class="col-6">
          <label for="np">New Password</label>
          <input type="password" name="" id="np" class=" form-control" />
          </div>
          <div class="col-6">
          <label for="rnp">Retype Password</label>
          <input type="password" name="" id="rnp" class=" form-control" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="chnagePassword();">Changes Password</button>
      </div>
    </div>
  </div>
</div>
    <script src="script.js"></script>
</body>
</html>