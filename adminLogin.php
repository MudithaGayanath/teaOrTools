<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap.css" />
  <title>Admin Login | Tea or Tools</title>
</head>

<body>
 <div class=" container">
 <div class="row">
           <!-- l1 -->
           <div class="loader justify-content-center " id="loader">
                <div class=" text-center  sp ">
                    <div class="spinner-border position-absolute text-primary" style="width: 5rem; height: 5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <!-- l1 -->
            <!-- l2 -->
            <div class="loader d-none " id="loader-2">
                <div class=" text-center  sp ">
                    <div class="spinner-border position-absolute text-primary" style="width: 5rem; height: 5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <!-- l2 -->
    <div class="col-12 text-center">
      <h1>Admin Login</h1>
    </div>
    <div class="col-12 col-md-6">
      <img src="img/admin login.jpg" alt="" srcset="" class=" w-100">
    </div>
    <div class="col-12 col-md-6 mt-md-5">
      <div class="row">
        <div class="col-12">
          <label for="adminEmail">Email</label>
          <input type="email" id="adminEmail" class=" form-control" />
        </div>
        <div class="col-12">
          <label for="adminPassword">Password</label>
          <input type="password" id="adminPassword" class=" form-control" />
        </div>

        <button class="btn btn-primary col-10 offset-1 mt-2" onclick="adminLoginModel();">Login</button>
      </div>
    </div>
  </div>
 </div>
  <div class="modal" tabindex="-1" id="adminModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Admin Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <label for="adminVericode">Enter Verification code</label>
              <input type="text" id="adminVericode" class=" form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="adminLogin();">Login</button>
        </div>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
  <script src="bootstrap.bundle.js"></script>
  <script src="jqery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#loader").animate({
                        opacity: "0%"
                    }, 1000, function() {
                        $("#loader").hide();
                    })
                });
            </script>
</body>

</html>