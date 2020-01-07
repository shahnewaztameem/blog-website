<?php
    if(isset($_POST['create_user'])){
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);
        $username = escape($_POST['username']);
//        $post_image = $_FILES['image']['name'];
//        $post_image_temp = $_FILES['image']['tmp_name'];
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);
//        hasing passwords
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 10));
        $user_created_date = date('d-m-y');
//        $post_date = date('d-m-y');
//        move_uploaded_file($post_image_temp,"../images/$post_image");
        
        if(!empty($user_firstname) && !empty($user_lastname) && !empty($username) && !empty($user_email) && !empty($user_password)){
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 10));
            $query = "INSERT INTO users(username,user_firstname,user_lastname,user_role,user_email,user_password,created_date) VALUES('{$username}','{$user_firstname}','{$user_lastname}','{$user_role}','{$user_email}','{$user_password}',now())";
            $create_post_query = mysqli_query($connection,$query);
            confirmQuery($create_post_query);
            if(!confirmQuery($create_post_query)){
            echo "<h4 class='alert alert-success' role='alert'>User Added Successfully. <a href='users.php'>View Users</a></h4>";
            }
        }
        else {
            echo "<script>alert('Fields are required')</script>";
        }
        
    }
?>
   <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
        <label for="user_role">User Role</label>
        <br>
        <select name="user_role" id="" style="width: 150px;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
            <option value="subscriber">Select an option</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
        
    </div>
    
    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    
    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="email" class="form-control" name="user_email">
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
       <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>
