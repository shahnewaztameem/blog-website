<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php require "vendor/autoload.php"; ?>
<?php
//	env
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//	load env file
	$dotenv->load();
?>
<?php
//	pusher
//	pusher('$auth_key','$secret','$app_id','$options')
	$options = array(
		'cluster' => 'ap2',
		'useTLS' => true
  	);
 	$pusher = new \Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);

?>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        $error = [
          "username" => '',  
          "email" => '',  
          "password" => ''  
        ];
        
//        check for empty username
        if($username == ''){
            $error['username'] = "Username can not be empty";
        }
        
//        check for username lengh to be at least 5
        else if(strlen($username) < 4){
            $error['username'] = "Username needs to be at least 5 characters long";
        }
        
//        check for existing username
        else if(username_exists($username)){
            $error['username'] = "Username already exists";
        }
        
//        check for username pattern that contains letter and number only
        else if(!preg_match("/^[a-zA-Z-]+$/", $username) && preg_match('/\s/',$username)){
            $error['username'] = "Invalid username!Username can only contains characters and numbers";
        }
        
//        check for empty email
        if(empty($email)){
            $error['email'] = "Email can not be empty";
        }
        
//        check for valid email formate
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error['email'] = "Invalid email format"; 
        }
        
//        check for existing email by calling the function
        else if(email_exists($email)){
            $error['email'] = "Email already exists. <a href='index.php'>Go to login page</a>";
        }
        
//        check for empty password
        if(empty($password)){
            $error['password'] = "Password can not be empty";
        }
        
//        check for the length of the password to be 8
        else if(strlen($password) < 8){
            $error['password'] = "Password needs to be at least 8 characters long";
        }
        
//        loop through the error array to detect errors 
        foreach($error as $key => $value){
            if(empty($value)){
                unset($error[$key]);
            }
        } //foreach end
        
        if(empty($error)){
			//register the user if there is no error
            
            register_user($username, $email, $password);
			
			//trigger pusher after registration
			$data['message'] = $username;
			$pusher->trigger('notifications','new_user',$data);
			
            
			//after register redirect to the admin dashboard
            
            login_user($username, $password);
        }
    }


?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <p class="error-msg">
                            <?php 
                                echo isset($error['username']) ? $error['username'] : '';
                            ?>
                            </p>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username) ? $username : '';?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <p class="error-msg">
                            <?php 
                                echo isset($error['email']) ? $error['email'] : ''
                            ?>
                            </p>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : '';?>">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <p class="error-msg">
                            <?php 
                                echo isset($error['password']) ? $error['password'] : '';
                            ?>
                                </p>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
<hr>
<?php include "includes/footer.php";?>
