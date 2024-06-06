<?php
session_start();
include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["a"])) {
        $cat = $_POST["cat"];
        $text = $_POST["text"];
        if (empty($text)) {
            echo ("empty");
        } else {

            $query = "SELECT * FROM `user` INNER JOIN `gender` ON
            user.gender_gender_id=gender.gender_id INNER JOIN `status` ON
            user.status_status_id=status.status_id ";
            if ($cat == 0) {
                $sText = explode(" ", $text);
                if (isset($sText[0])) {
                    $query .= (" WHERE `fname` LIKE '%" . $sText[0] . "%' ");
                } else if (isset($sText[1])) {
                    $query .= (" WHERE `fname` LIKE '%" . $sText[0] . "%' AND `lname` LIKE '%" . $sText[1] . "%' ");
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
            <img src="<?php echo ($path); ?>" class=" img-fluid " alt="..." style="width: 300px; height: 200px;">
            <div class="card-body" onclick="goToUserDetails(<?php echo ($i) ?>);">
              <h5 class="card-title"><?php echo ($name); ?></h5>
              <p class="card-text m-0" id="<?php echo ($i) ?>"> <?php echo ($email); ?></p>
              <p class="card-text m-0"><?php echo ($mobile); ?></p>
              <p class="card-text m-0"><?php echo ($gender); ?></p>
              <p class="card-text m-0"><?php echo ($joined_date); ?>(Joined Date)</p>

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
            } else if ($cat == 1) {
                if (!filter_var($text, FILTER_VALIDATE_EMAIL)) {
                    echo ("invalid");
                } else {

                    $query .= (" WHERE `email`='" . $text . "'");
                    $rs = Database::search($query);

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
                        <div class="card m-3" style="width: 19rem;">
                            <img src="<?php echo ($path); ?>" class="img-fluid" style="width: 300px; height: 200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo ($name); ?></h5>
                                <p class="card-text m-0" id="<?php echo ($i) ?>"> <?php echo ($email); ?></p>
                                <p class="card-text m-0"><?php echo ($mobile); ?></p>
                                <p class="card-text m-0"><?php echo ($gender); ?></p>
                                <p class="card-text m-0"><?php echo ($joined_date); ?>(Joined Date)</p>
                                <?php
                                if ($status == 1) {
                                ?>
                                    <button class="btn btn-primary mt-2" onclick="changeUserStatus(<?php echo ($i); ?>)">Active</button>
                                <?php
                                } else {
                                ?>
                                    <button class="btn btn-danger mt-2" onclick="changeUserStatus(<?php echo ($i); ?>)">Inactive</button>

                                <?php
                                }
                                ?>
                            </div>
                        </div>
<?php
                    }
                }
            }
        }
    }
} else {
    echo ("Illeagle");
}
?>