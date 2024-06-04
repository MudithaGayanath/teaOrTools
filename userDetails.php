<?php
session_start();
if (isset($_SESSION["a"])) {
    include("connection.php");
    if ($_GET["email"]) {
        $email = $_GET["email"];
        $userRs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON
        user.gender_gender_id=gender.gender_id INNER JOIN `status` ON
      user.status_status_id=status.status_id WHERE `email`='" . $email . "'");

        if ($userRs->num_rows > 0) {
            $userData = $userRs->fetch_assoc();
            $name = $userData["fname"] . " " . $userData["lname"];
            $status = $userData["status_status_id"];
?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="bootstrap.css">
                <title><?php echo ($name); ?></title>
            </head>

            <body>
                <nav class="navbar bg-body-tertiary navbar-expand-md  sticky-top">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="adminPanale.php">Tea or Tools </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tea or Tools</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link " aria-current="page" href="adminPanale.php">Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="manageUser.php">Manger Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manageProducts.php">Manger Products</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">History</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-danger" href="#" onclick="adminLogout();">LogOut</a>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                </nav>

                <div class=" container-fluid">
                    <h1 class=" text-center">User Details</h1>
                    <div class="row">
                        <!-- img -->
                        <div class="col-12 col-md-4 d-flex flex-column align-items-center text-center  p-3 py-0 py-md-5">
                            <?php
                            

                            $imgRs = Database::search("SELECT * FROM `user_img` WHERE `user_email`='" . $email . "'");

                            if ($imgRs->num_rows == 0) {
                            ?>
                                <img src="img/userProfile/user.svg" alt="default user profile image" id="userImg" class="rounded" width="200px" />
                            <?php
                            } else {
                                $imgData = $imgRs->fetch_assoc();
                            ?>
                                <img src="<?php echo ($imgData["path"]); ?>" alt="default user profile image" id="userImg" class="rounded" width="200px" />
                            <?php
                            }
                            ?>

                            <div class="d-flex mb-0 ms-2 lead">
                                <p class="mb-0"><?php echo ($userData["fname"]); ?></p>
                                <p class="ms-2 mb-0"><?php echo ($userData["lname"]); ?></p>
                            </div>
                            <p class=" ms-2 lead"><?php echo ($userData["email"]); ?></p>
                        </div>
                        <!-- img -->
                        <div class="col-12 col-md-8 mt-2 mt-md-0 border-start">
                            <div class="row mb-3">
                                <div class="col-12 col-sm-6">
                                    <label for="fName">First Name</label>
                                    <input type="text" class="form-control" id="fName" disabled value="<?php echo ($userData["fname"]); ?>" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="lName">Last Name</label>
                                    <input type="text" id="lName" class="form-control" disabled value="<?php echo ($userData["lname"]); ?>" />
                                </div>
                                <div class="col-12">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" id="mobile" class="form-control" value="<?php echo ($userData["mobile"]); ?>" disabled />
                                </div>
                                <div class="col-12">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" class="form-control" value="<?php echo ($userData["email"]); ?>" disabled />
                                </div>
                                <div class="col-12">
                                    <label for="myPassword" class="form-label mb-1">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" value="<?php echo ($userData["password"]); ?>" disabled aria-label="" aria-describedby="button-show" id="myPassword" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="joinDate">Joined Date</label>
                                    <input type="text" id="joinDate" class="form-control " value="<?php echo ($userData["joined_date"]); ?>" disabled />
                                </div>
                                <div class="col-12">
                                    <label for="gender">Gender</label>

                                    <input type="text" class="form-control " id="gender" value="<?php echo ($userData["gender_name"]); ?>" disabled />
                                </div>
                                <?php
                                $addressRs = Database::search("SELECT * FROM `user_has_address`  INNER JOIN `city` ON 
                        user_has_address.city_city_id=city.city_id INNER JOIN `district` ON 
                        city.district_id=district.district_id JOIN `province` ON 
                        district.province_id=province.province_id  WHERE `user_email`='" . $email . "'");

                                $line1 = "";
                                $line2 = "";
                                $postalCode = "";

                                if ($addressRs->num_rows == 1) {
                                    $addressData = $addressRs->fetch_assoc();
                                    $line1 = $addressData["line1"];
                                    $line2 = $addressData["line2"];
                                    $postalCode = $addressData["postcode"];
                                }
                                ?>

                                <?php
                                if ($addressRs->num_rows == 0) {
                                ?>
                                  <p class=" text-center mt-5 fs-4">Address not update</p>
                                <?php
                                } else {
                                ?>
                                    <div class="col-12">
                                        <label for="address1">Address Line 1</label>
                                        <input type="text" id="address1" class="form-control" value="<?php echo ($line1); ?>" readonly />
                                    </div>
                                    <div class="col-12">
                                        <label for="address2">Address Line 2</label>
                                        <input type="text" id="address2" class="form-control" value="<?php echo ($line2); ?>" readonly />
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <label for="form-label">Province</label>
                                        <select id="provinc" class="form-select" readonly>
                                            <option value="<?php echo ($addressData["province_id"]); ?>"><?php echo ($addressData["province_name"]); ?></option>

                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label for="form-label">District</label>
                                        <select id="distric" class="form-select" onclick="dtoc();" readonly>
                                            <option value="<?php echo ($addressData["district_id"]); ?>"><?php echo ($addressData["district_name"]); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label for="form-label">City</label>
                                        <select id="city" class="form-select" readonly>
                                            <option value="<?php echo ($addressData["city_id"]); ?>"><?php echo ($addressData["city_name"]); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label for="pCode">Postal Code</label>
                                        <input type="number" class="form-control" id="pCode" value="<?php echo ($postalCode); ?>" readonly />
                                    </div>
                                <?php
                                }
                                ?>

<div class="row">

              <?php
              if ($status == 1) {
              ?>
                <button class="btn btn-primary col-10 offset-1 mt-2" onclick="changeUserStatus('email')">Active</button>
              <?php
              } else {
              ?>
                <button class="btn btn-danger col-10 offset-1 mt-2" onclick="changeUserStatus('email')">Inactive</button>

              <?php
              }
              ?>
              </div>




                            </div>
                        </div>
                    </div>
                </div>
<script src="script.js"></script>
            </body>

            </html>
        <?php
        } else {
        ?>
            <script>
                alert("User not found");
                window.location = "manageUser.php";
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            window.location = "manageUser.php";
        </script>
    <?php
    }
} else {
    ?>
    <script>
        alert("Illegal Admin  Access Denied");
        window.location = "index.php";
    </script>
<?php
}
?>