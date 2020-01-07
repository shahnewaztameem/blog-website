<?php

?>
  
  <?php
//get user data by id
    if(isset($_GET['user_id'])){
        $user_id = escape($_GET['user_id']);
    $query = "SELECT * from users WHERE user_id = {$user_id}";
    $select_all_user_information = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_all_user_information)){
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];

?>
  <?php
//    update user
    if(isset($_POST['update_user'])){
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);
        
        
        
        if(!empty($user_firstname) && !empty($user_lastname) && !empty($user_role) && !empty($username) && !empty($user_email) && !empty($user_password)){
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost"=>10));
            $query ="UPDATE users SET user_firstname = '$user_firstname', user_lastname = '$user_lastname', user_role ='$user_role', username ='$username', user_email = '$user_email', user_password = '$hashed_password' WHERE user_id = $user_id";
            $update_user_info = mysqli_query($connection,$query);
            if(!$update_user_info){
                die("QUERY FAILED ". $connection);
            }
            else{
                echo "<h5 class='alert alert-success' role='alert' style='font-weight:bold'>Successfully Updated. &nbsp; <a href='users.php'>View All Users </a></h5>";
            }
        }
        else{
            echo "<h5 class='alert alert-danger' role='alert'>Fields can not be empty</h5>";
        }
    }
}
    }

    else {
        header("location: index.php");
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
       <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>
</form>
