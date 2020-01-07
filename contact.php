<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
    if(isset($_POST['submit'])) {
        
        $to          = "shahnewaztamim@gmail.com";
        $subject     = wordwrap($_POST['subject'],50);
        $body        = $_POST['body'];
        $header      = "From: " . $_POST['email'];
        if(!empty($to) && !empty($subject) && !empty($body)){
            mail($to,$subject,$body,$header);
            $message = "<h5 style='color:green;font-weight:bold'>Your message has been sent!</h5>";
        }
        else {
            $message = "Fields can not be empty";
        }
        
    }
    else {
        $message = "";
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
                <h1>Contact Us</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                       <div class="form-group">
                            <h5 style="color:red;font-weight:bold;"><?php echo $message;?></h5>
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">subject</label>
                            <input type="text" name="subject" id="usesubjectrname" class="form-control" placeholder="Enter Subject">
                        </div>
                         <div class="form-group">
                            <textarea name="body" id="" cols="50" rows="10" class="form-control" style="resize: none;"></textarea>
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
