<?php include "includes/admin_header.php";?>
<?php
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_user_profile_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_user_profile_query)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }
    }
?> 

 <?php
//    update user
    if(isset($_POST['update_user'])){
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        if(!empty($user_firstname) && !empty($user_lastname) && !empty($user_role) && !empty($username) && !empty($user_email) && !empty($user_password)){
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost"=>10));
            $query ="UPDATE users SET user_firstname = '$user_firstname', user_lastname = '$user_lastname', user_role ='$user_role', username ='$username', user_email = '$user_email', user_password = '$user_password' WHERE username = '{$username}'";
            $update_user_info = mysqli_query($connection,$query);
            if(!$update_user_info){
                die("QUERY FAILED ". $connection);
            }
            else{
                $message = "<h4 class='alert alert-success'>Successfully updated <a href='index.php'>Return back to home</a></h4>";
            }
        }
        else{
            $message ="<h4 class='alert alert-danger'>Fields can not be empty</h4>";
        }
    }

?>

<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php";?>
    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome To Admin Dashboard
                        <small>
                        <?php
                            if(isset($_SESSION['username']))
                            echo $_SESSION['username'];
                        ?>
                        </small>
                    </h1>
                    <?php 
                        if(isset($message)){
                            echo $message;
                        }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Firstname</label>
                            <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname;?>">
                        </div>
                        <div class="form-group">
                            <label for="title">Lastname</label>
                            <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>">
                        </div>

                        <div class="form-group">
                            <label for="user_role">User Role</label>
                            <br>
                            <select name="user_role" id="" style="width: 150px;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
                                <?php echo "<option value='$user_role'>$user_role</option>";?>

                                <?php
                                    if($user_role == "admin"){
                                        echo "<option value='subscriber'>subscriber</option>";
                                    }
                                else{
                                    echo "<option value='admin'>admin</option>";
                                }
                                ?>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="title">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username;?>">
                        </div>

                        <div class="form-group">
                            <label for="post_status">Email</label>
                            <input type="email" class="form-control" name="user_email" value="<?php echo $user_email;?>">
                        </div>

                        <!--
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
-->

                        <div class="form-group">
                            <label for="post_status">Password</label>
                            <input type="password" class="form-control" name="user_password">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="update_user" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>

    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php";?>
