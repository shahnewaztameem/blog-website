<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php include "includes/navigation.php"; ?>

<!--Load Composer's autoloader-->
<?php require "vendor/autoload.php"; ?>

<?php
    if(!isset($_GET['reset'])){
        redirect("index");
    }
    if(ifItIsMethod('post')){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $length = 50;
            //token 
            $token = bin2hex(openssl_random_pseudo_bytes($length));
            
			//check for exitsting email
            if(email_exists($email) && !empty($email)){
                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email= ?")){
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt); 
					
					//configure phpmailer
					//Instantiation 
					$mail = new PHPMailer();
					$mail->isSMTP();                                            // Send using SMTP
					$mail->Host       = Config::SMTP_HOST;                    	// Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->Username   = Config::SMTP_USER;                     // SMTP username
					$mail->Password   = Config::SMTP_PASSWORD;                               // SMTP password
					$mail->SMTPSecure = 'tls';         // Enable TLS encryption;
					$mail->isHTML(true);
					$mail->CharSet = 'UTF-8';
					$mail->setFrom("shahnewaztamim@gmail.com", "Shahnewaz");
					$mail->addAddress($email);
					$mail->Subject = "Reset Your Password";
					$mail->Body = '<p>Please click the link below to reset your password</p>
					
					<a href="http://localhost/blogcms/forgot.php?email='.$email.'&token='.$token.'">http://localhost/blogcms/forgot.php?email='.$email.'&token='.$token.'</a>';
					if($mail->send()){
						$mailSent = true;
					}
					else {
						echo "Not sent";
					}
					      
                }
                else {
                    echo mysqli_error($connection);
                }
            }
			else if(empty($email)){
				echo "<h3 class='text-center alert alert-danger'>Email field can not be blank</h3>";
			}
			else{
				echo "<h3 class='text-center alert alert-danger'>Email does not exists</h3>";
			}
        }
		
    }

?>

<!-- Page Content -->
<div class="container">

	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">
							<?php if(!isset($mailSent)): ?>
							<h3><i class="fa fa-lock fa-4x"></i></h3>
							<h2 class="text-center">Forgot Password?</h2>
							<p>You can reset your password here.</p>
							<div class="panel-body">


								<form id="register-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
											<input id="email" name="email" placeholder="email address" class="form-control" type="email">
										</div>
									</div>
									<div class="form-group">
										<input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
									</div>

									<input type="hidden" class="hide" name="token" id="token" value="">
								</form>

							</div><!-- Body-->
							<?php else: ?>
							<h4>Please check your email inbox!</h4>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<hr>

	<?php include "includes/footer.php";?>

</div> <!-- /.container -->