<?php
session_start();
include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["a"])) {
        $a = $_POST["a"];
        $query = "SELECT * FROM `user` INNER JOIN `gender` ON
        user.gender_gender_id=gender.gender_id INNER JOIN `status` ON
        user.status_status_id=status.status_id ";
        if ($a == 1) {
            $query .= " ORDER BY `joined_date` DESC ";
        } else if ($a == 2) {
            $query .= " ORDER BY `joined_date` ASC ";
        } else if ($a == 3) {
            $query .= " WHERE `status_status_id`='1' ";
        } else if ($a == 4) {
            $query .= " WHERE `status_status_id`='2' ";
        } else if ($a == 5) {
            $query .= " WHERE `gender_gender_id`='1' ";
        } else if ($a == 6) {
            $query .= " WHERE `gender_gender_id`='2' ";
        }
        $rs = Database::search($query);
        if ($rs->num_rows > 0) {
            for ($i = 0; $i < $rs->num_rows; $i++) {
                $data = $rs->fetch_assoc();
                $name = $data["fname"] . " " . $data["lname"];
                $email = $data["email"];
                $mobile = $data["mobile"];
                $joined_date = $data["joined_date"];
                $gender = $data["gender_name"];
                $status = $data["status_status_id"];
                $path = "";
                $imgRs = Database::search("SELECT `path` FROM `user_img` WHERE `user_email`='" . $email . "'");
                if ($imgRs->num_rows == 0) {
                    $path = "img/userProfile/user.svg";
                } else {
    
                    $imgData = $imgRs->fetch_assoc();
    
                    $path = $imgData["path"];
                }
            ?>
                <div class="card m-3 p-0" style="width: 18rem;">
                    <img src="<?php echo ($path); ?>" class=" img-fluid " alt="..." style="width: 300px; height: 200px;" >
                    <div class="card-body">
                        <h5 class="card-title"><?php echo ($name); ?></h5>
                        <p class="card-text m-0" id="<?php echo ($i) ?>"> <?php echo ($email); ?></p>
                        <p class="card-text m-0"><?php echo ($mobile); ?></p>
                        <p class="card-text m-0"><?php echo ($gender); ?></p>
                        <p class="card-text m-0"><?php echo ($joined_date); ?>(Joined Date)</p>
                        <div class="row">

              <?php
              if ($status == 1) {
              ?>
                <button class="btn btn-primary col-10 offset-1 mt-2" onclick="changeUserStatus(<?php echo ($i); ?>)">Active</button>
              <?php
              } else {
              ?>
                <button class="btn btn-danger col-10 offset-1 mt-2" onclick="changeUserStatus(<?php echo ($i); ?>)">Inactive</button>

              <?php
              }
              ?>
              </div>
                    </div>
                </div>
    <?php
            }
        } else {
?>
            <div class="col-12 text-center">
                <h1>No user found</h1>
            </div>
        <?php
        }
        
    }
}
