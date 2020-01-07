<?php ob_start();?>
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
            
            if(isset($_POST['submit'])){
                $search =  $_POST['search'];
                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                $search_query = mysqli_query($connection,$query);
            if(!$search_query){
                die("Query Error!!" . mysqli_error($connection));
            }
            $count = mysqli_num_rows($search_query);
            if($count == 0){
                echo "<h1 class='alert alert-danger'>No results Found!</h1>";
            }
            else{
                while($row = mysqli_fetch_assoc($search_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_content = substr($row['post_content'],0,120);
                    $post_image = $row['post_image'];
                ?>
                
            <h1 class="page-header">
               Search Results
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="/blogcms/post/<?php echo $post_id?>"><?php echo $post_title;?></a>
            </h2>
            <p class="lead">
                by <a href="/blogcms/author_posts.php?author=<?php echo $post_user;?>&p_id=<?php echo $post_id;?>"><?php echo $post_user;?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
            <hr>
            <p><?php echo $post_content;?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>

            <?php }}} ?>


        </div>


        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include "includes/footer.php";?>