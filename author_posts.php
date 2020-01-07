<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>
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
                    $the_post_author = $_GET['author'];
                }
            ?>
            
            <?php
                //$query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' AND post_status='published'";
				if(isset($_SESSIONS['user_role']) && is_admin($_SESSION['user_role'])){
                    $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}'";
                }
                else {
                    $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' AND post_status='published'";
                }
                $select_all_posts_query = mysqli_query($connection,$query);
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                    $post_image = $row['post_image'];
            ?>
            <h1 class="page-header">
<!--                Page Heading-->
<!--                <small>Secondary Text</small>-->
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title;?></a>
            </h2>
            <p class="lead">
                All posts by <?php echo $post_author;?>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
            <hr>
            <p><?php echo $post_content;?></p>
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
             <?php } ?>
             <!-- Blog Comments -->
                     <?php
                        if(isset($_POST['create_comment'])){
                            $the_post_id = $_GET['p_id'];
                            $comment_author = mysqli_real_escape_string($connection,$_POST['comment_author']);
                            $comment_email = mysqli_real_escape_string($connection,$_POST['comment_email']);
                            $comment_content = mysqli_real_escape_string($connection,$_POST['comment_content']);
                            if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                                //adding content to the database
                                $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) VALUES({$the_post_id},'$comment_author','$comment_email','$comment_content','Unapproved',now())";

                                $create_comment_query = mysqli_query($connection,$query);
                                if(!$create_comment_query){
                                    die("QUERY failed!! ".$connection);
                                }
                                //update comment count
                                $query = "UPDATE posts SET post_comment_count=post_comment_count + 1 WHERE post_id = {$the_post_id}";
                                $update_comment_count = mysqli_query($connection,$query);
                                if(!$update_comment_count){
                                    die("QUERY failed!! ".$connection);
                                }
                            }
                            else {
                                echo "<script>alert('Fields Can not be empty!')</script>";
                            }
                        }
                    ?>    
                <!-- Comments Form -->
               


            
                <!-- Comment -->
                

                <!-- Comment -->
                
        </div>
       

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include "includes/footer.php";?>