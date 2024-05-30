<?php
    include ("header.php");
    include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css" />
    <title>Register | Tea or Tools</title>
</head>
<body>
    <div class="container mb-3">
    
        <h1 class="text-center">Registration</h1>
        <div class="row">
            <div class="col-12  col-md-6 d-none d-lg-flex">
                <img src="img/registration.png" alt="" class=" img-fluid">
            </div>
            <div class="col-12 col-lg-6  ">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label for="fname">First Name</label>
                        <input type="text"  id="fname" class=" form-control" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="lname">Last Name</label>
                        <input type="text"  id="lname"  class=" form-control" />
                    </div>
                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="text"  id="email"  class=" form-control" />
                    </div>
                    <div class="col-12">
                        <label for="pw1">password</label>
                        <input type="password"  id="pw1"  class=" form-control" />
                    </div>
                    <div class="col-12">
                        <label for="pw2">Retype password</label>
                        <input type="password"  id="pw2"  class=" form-control" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="mobile">Mobile</label>
                        <input type="text"  id="mobile"  class=" form-control" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="gen">Gender</label>
                        <select  id="gen" class=" form-select">
                            <?php
                            $genRS = Database::search("SELECT * FROM `gender`");
                            for ($i=0; $i < $genRS -> num_rows; $i++) { 
                                $genData = $genRS -> fetch_assoc();
                                ?>
                                <option value="<?php echo($genData["gender_id"]);?>"><?php echo($genData["gender_name"]);?></option>
                                <?php
                            }
                            ?>
                            
                            
                        </select>
                    </div>
                    <button class="btn btn-success col-10 offset-1 mt-2" onclick="register();">Register</button>
                    <button class="btn btn-warning col-10 offset-1 mt-2" onclick="goToLogin();">Have Account</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("footer.php");
    ?>
<script src="script.js"></script>
</body>
</html>