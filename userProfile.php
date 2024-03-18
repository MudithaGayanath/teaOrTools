<?php
    include("header.php");
    include("connection.php");

    if ( isset($_SESSION["u"])){
        $email = $_SESSION["u"]["email"];
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <title>Profile | Tea or Tools</title>
</head>
<body onload="active(2);">
    <div class="container-fluid">
        <div class="row">
            <!-- img -->
            <div class="col-12 col-md-4 d-flex flex-column align-items-center text-center  p-3 py-0 py-md-5">
                <?php
                    $userRs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON
                    user.gender_gender_id=gender.gender_id  WHERE `email`='".$email."'");
                    $userData = $userRs ->fetch_assoc();

                    $imgRs = Database::search("SELECT * FROM `user_img` WHERE `user_email`='".$email."'");

                    if ( $imgRs -> num_rows == 0){
                        ?>
                        <img src="img/userProfile/user.svg" alt="default user profile image" id="userImg" class="rounded" width="200px" />
                        <?php
                    }else {
                        $imgData = $imgRs -> fetch_assoc();
                        ?>
                        <img src="<?php echo($imgData["path"]);?>" alt="default user profile image" id="userImg" class="rounded" width="200px" />
                        <?php
                    }
                ?>
                
                <div class="d-flex mb-0 ms-2 lead">
                    <p class="mb-0"><?php echo($userData["fname"]);?></p>
                    <p class="ms-2 mb-0"><?php echo($userData["lname"]);?></p>
                </div>
                <p class=" ms-2 lead"><?php echo($userData["email"]);?></p>
                <input type="file" class="d-none" id="profileimageInput" />
                <label for="profileimageInput" onclick="updateProfileImg();" class="btn btn-primary">Change Profile Image</label>
            </div>
            <!-- img -->
            <div class="col-12 col-md-8 mt-2 mt-md-0 border-start">
                <div class="row mb-3">
                    <h3 class="col-12 text-center display-4">Profile Details</h3>
                    <div class="col-12 col-sm-6">
                        <label for="fName">First Name</label>
                        <input type="text" class="form-control" id="fName" disabled value="<?php echo($userData["fname"]);?>" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="lName">Last Name</label>
                        <input type="text" id="lName" class="form-control" disabled value="<?php echo($userData["lname"]);?>" />
                    </div>
                    <div class="col-12">
                        <label for="mobile">Mobile</label>
                        <input type="text" id="mobile" class="form-control" value="<?php echo($userData["mobile"]);?>" disabled />
                    </div>
                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" value="<?php echo($userData["email"]);?>" disabled />
                    </div>
                    <div class="col-12">
                        <label for="myPassword" class="form-label mb-1">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" value="<?php echo($userData["password"]);?>" disabled aria-label="" aria-describedby="button-show" id="myPassword"  />
                            <button class="btn btn-outline-secondary" type="button" id="myPasswordShowBtn" onclick="show();">Show</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="joinDate">Joined Date</label>
                        <input type="text" id="joinDate" class="form-control " value="<?php echo($userData["joined_date"]);?>" disabled />
                    </div>
                    <div class="col-12">
                        <label for="gender">Gender</label>
                        
                        <input type="text" class="form-control " id="gender" value="<?php echo($userData["gender_name"]);?>" disabled />
                    </div>
                    <?php
                        $addressRs = Database::search("SELECT * FROM `user_has_address`  INNER JOIN `city` ON 
                        user_has_address.city_city_id=city.city_id INNER JOIN `district` ON 
                        city.district_id=district.district_id JOIN `province` ON 
                        district.province_id=province.province_id  WHERE `user_email`='".$email."'");

                        $line1 = "";
                        $line2 = "";
                        $postalCode = "";

                        if ( $addressRs -> num_rows == 1 ){
                            $addressData = $addressRs -> fetch_assoc();
                            $line1 = $addressData["line1"];
                            $line2 = $addressData["line2"];
                            $postalCode = $addressData["postcode"];
                        }
                    ?>
                    
                    <?php
                        if ( $addressRs -> num_rows == 0 ){
                            ?>
                            <div class="col-12">
                                <label for="address1">Address Line 1</label>
                                <input type="text" id="address1" class="form-control"  />
                            </div>
                            <div class="col-12">
                                <label for="address2">Address Line 2</label>
                                <input type="text" id="address2" class="form-control"  />
                            </div>
                            
                            <div class="col-12 col-sm-6">
                                <label for="form-label">Province</label>
                                <select id="provinc" class="form-select" onclick="ptod();">
                                    <option value="0">Select Province</option>
                                    <?php
                                    $proRs= Database::search("SELECT * FROM `province` ORDER BY `province_name` ASC ");
                                    for ($i=0; $i < $proRs -> num_rows; $i++) { 
                                        $proData = $proRs -> fetch_assoc();
                                        ?>
                                        <option value="<?php echo($proData["province_id"]);?>" ><?php echo($proData["province_name"]);?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="form-label">District</label>
                                <select id="distric" class="form-select" onclick="dtoc();">
                                <option value="0">Select District</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="form-label">City</label>
                                <select id="city" class="form-select" onclick="postalcode2();">
                                <option value="0">Select City</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                            <label for="pCode">Postal Code</label>
                            <input type="number" class="form-control" id="pCode" readonly/>
                        </div>
                        <button class="col-10 offset-1 mt-3 mb-1 btn btn-success" onclick="addAddress();">Save</button>
                            <?php
                        }else {
                            ?>
                                <div class="col-12">
                                    <label for="address1">Address Line 1</label>
                                    <input type="text" id="address1" class="form-control" value="<?php echo($line1);?>" readonly />
                                </div>
                                <div class="col-12">
                                    <label for="address2">Address Line 2</label>
                                    <input type="text" id="address2" class="form-control" value="<?php echo($line2);?>" readonly />
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label for="form-label">Province</label>
                                    <select id="provinc" class="form-select" readonly>
                                    <option value="<?php echo($addressData["province_id"]);?>" ><?php echo($addressData["province_name"]);?></option>
                                           
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="form-label">District</label>
                                    <select id="distric" class="form-select" onclick="dtoc();" readonly>
                                    <option value="<?php echo($addressData["district_id"]);?>"><?php echo($addressData["district_name"]);?></option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="form-label">City</label>
                                    <select id="city" class="form-select" readonly>
                                    <option value="<?php echo($addressData["city_id"]);?>"><?php echo($addressData["city_name"]);?></option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="pCode">Postal Code</label>
                                    <input type="number" class="form-control" id="pCode" value="<?php echo($postalCode);?>" readonly/>
                                </div>
                                <button class="col-10 offset-1 mt-1 mb-1 btn btn-success" onclick="changeAddressOpenModal();">Change Address</button>
                            <?php
                        }
                    ?>
                    
                    
                    
                    
                    
                   
                </div>
            </div>
        </div>
        <!-- Change Address Modal -->
        <div class="modal" tabindex="-1" id="model">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-12">
                                <label for="newAdd">Address Line 1</label>
                                <input type="text" id="newAdd" class="form-control"  />
                            </div>
                            <div class="col-12">
                                <label for="newAdd2">Address Line 2</label>
                                <input type="text" id="newAdd2" class="form-control"  />
                            </div>
                            
                            <div class="col-12 col-sm-6">
                                <label for="form-label">Province</label>
                                <select id="newProvinc" class="form-select" onclick="newProToDis();">
                                    <option value="0">Select Province</option>
                                    <?php
                                    $proRs= Database::search("SELECT * FROM `province` ORDER BY `province_name` ASC ");
                                    for ($i=0; $i < $proRs -> num_rows; $i++) { 
                                        $proData = $proRs -> fetch_assoc();
                                        ?>
                                        <option value="<?php echo($proData["province_id"]);?>" ><?php echo($proData["province_name"]);?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="form-label">District</label>
                                <select id="newDistric" class="form-select" onclick="newDisToCity();">
                                <option value="0">Select District</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="form-label">City</label>
                                <select id="newCity" class="form-select" onclick="postalcode();">
                                <option value="0">Select City</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                            <label for="newPCode">Postal Code</label>
                            <input type="number" class="form-control" id="newPCode" readonly />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="changeAddress();">Save changes</button>
                </div>
                </div>
            </div>
        </div>
    </div>
<script src="script.js"></script>   
<script src="bootstrap.bundle.js"></script> 
<script src="bootstrap.bundle.min.js"></script>
</body>
</html>
        <?php
    }else{
        ?>
        <script>
            window.location = "login.php";
        </script>
        <?php
    }
?>

