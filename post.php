<?php ob_start();?>
<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>

<?php
	if(isset($_POST['liked'])){
		$post_id = $_POST['post_id'];
		$user_id= $_POST['user_id'];
		
		//select post
		$query = "SELECT * FROM posts WHERE post_id=$post_id";
		$postResult = mysqli_query($connection, $query);
		$post = mysqli_fetch_assoc($postResult);
		$likes = $post['likes'];
		
		if(mysqli_num_rows($postResult) >= 1){
			echo $post['post_id'];
		}
		
		//update the post with likes
		
		mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");
		
		//create likes for post
		
		mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
		exit();
	}

	if(isset($_POST['unliked'])){
		$post_id = $_POST['post_id'];
		$user_id= $_POST['user_id'];
		
		//select post
		$query = "SELECT * FROM posts WHERE post_id=$post_id";
		$postResult = mysqli_query($connection, $query);
		$post = mysqli_fetch_assoc($postResult);
		$likes = $post['likes'];
		
		//delete likes
		
		mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
		
		
		//decrement the post with likes
		
		mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
		
		exit();
	}


?>
<!-- Navigation -->
<?php include 'includes/navigation.php';?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
           <?php
                if(isset($_GET['p_id'])){
                    $the_post_id = $_GET['p_id'];
                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$the_post_id}";
                    $post_view_query = mysqli_query($connection,$view_query);
                    if(!$post_view_query){
                        die("Query Error! ".mysqli_errno($connection) . ' '. mysqli_error($connection));
                    }
                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                    //var_dump($_SESSION['user_role']);
                }
                else{
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status='published'";
                }
                $select_all_posts_query = mysqli_query($connection,$query);
                if(mysqli_num_rows($select_all_posts_query) < 1){
                    echo "<h1 class='text-center' style='font-weight:bold'>No posts available</h1>";
                }
                else {
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                    $post_image = $row['post_image'];
            ?>
            <h1 class="page-header">
<!--                <small>Secondary Text</small>-->
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title;?></a>
            </h2>
            <p class="lead">
                by <a href="/blogcms/author_posts.php?author=<?php echo $post_user;?>&p_id=<?php echo $the_post_id;?>"><?php echo $post_user;?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
            <hr>
            <img class="img-responsive" src="/blogcms/images/<?php echo $post_image;?>" alt="">
            <hr>
            <p><?php echo $post_content;?></p>
            
            <hr>
            
<!--            post likes and count the likes markup-->
          <?php
				if(isLoggedIn()){ ?>
					<div class="container">
						<div class="row">
							<p><a class="no-underline <?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like' ?>" href=""><i class="fa fa-thumbs-o-up"></i><?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like' ?></a></p>
						</div>
            		</div>
			
				<?php } else { ?>
				  <div class="container">
						<div class="row">
							<p>You need to <a href="/blogcms/login">Login</a> to like</p>
						</div>
					</div>
            	<?php } ?>
           
            <hr style="margin-top:0">
            <div class="container">
            	<div class="row">
            		<p class=""><span class="circle"><i class="fa fa-thumbs-up"></i></span> <?php getPostLikes($the_post_id); ?></p>
            	</div>
            </div>
            
            
           <?php  }
           
//
              //else {
//                    header("location: index.php");
//                }
            ?>
             <!-- Blog Comments -->
                     <?php
                        if(isset($_POST['create_comment'])){
                            $the_post_id = $_GET['p_id'];
                            $comment_author 	= mysqli_real_escape_string($connection,$_POST['comment_author']);
                            $comment_email 		= mysqli_real_escape_string($connection,$_POST['comment_email']);
                            $comment_content 	= mysqli_real_escape_string($connection,$_POST['comment_content']);
                            if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                                //adding content to the database
                                $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) VALUES({$the_post_id},'$comment_author','$comment_email','$comment_content','Unapproved',now())";

                                $create_comment_query = mysqli_query($connection,$query);
                                if(!$create_comment_query){
                                    die("QUERY failed!! ".$connection);
                                }
                                $message ="Your comment has been submitted and waiting for admin approval";
                            }
                            else {
                                echo "<h5 class='alert alert-danger'>Fields Can not be empty!</h5>";
                            }
                        }
                    ?> 
                    <label for="">
                    <?php if(isset($message)){
                        echo "<div class='alert alert-success' role='alert'>{$message}</div>";
                    }
                    ?>
                    </label>  
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                       <div class="form-group">
                           <label for="comment_author">Author</label>
                            <input type="text" name="comment_author" id="" class="form-control" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                           <label for="comment_email">Email</label>
                            <input type="email" name="comment_email" id="" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                           <label for="comment">Your Comment</label>
                            <textarea class="form-control" rows="3" placeholder="Enter your comment" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
//                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status='published'";
//                    $select_published_posts_query = mysqli_query($connection,$query);
//                    $published_post_count = mysqli_num_rows($select_published_posts_query);
                    //if($published_post_count > 0){
                    
                    $query = "SELECT * from comments where comment_post_id = {$the_post_id} AND comment_status = 'Approved' ORDER By comment_id DESC";
                    $select_comment_query = mysqli_query($connection,$query);
                    if(!$select_comment_query){
                        die("Query error!!! ".$connection);
                    }
                    while($row = mysqli_fetch_assoc($select_comment_query)){
                        $comment_author = $row['comment_author'];
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content']
                    ?>
                    <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author;?>
                            <small><?php echo $comment_date;?></small>
                        </h4>
                        <?php echo $comment_content;?>
                    </div>
                </div>
                    <?php }  } }
                     
                    else {
                        header("location: index");
                    }
                    ?>
            
                <!-- Comment -->
                

                <!-- Comment -->
                
        </div>
       

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?>

    </div>
    <!-- /.row -->
    <hr>
<?php include "includes/footer.php";?>
    
    <script>
		$(document).ready(function(){
			
			var post_id = <?php echo $the_post_id; ?>
			
			var user_id = <?php echo loggedInUserId(); ?>
//			like	
			$('.like').click(function(){
                    $.ajax({
                        url: "/blogcms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'liked': 1,
                            'post_id': post_id,
                            'user_id': user_id
                        }
                    });
                });
			
			//unlike
			$('.unlike').click(function(){
                    $.ajax({
                        url: "/blogcms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'unliked': 1,
                            'post_id': post_id,
                            'user_id': user_id 
                        }
                    });
                });
		});
	</script>
