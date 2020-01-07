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
                if(isset($_GET['category'])){
                    $post_category = $_GET['category'];
            ?>
            <?php
                if(isset($_SESSION['user_role']) && is_admin($_SESSION['user_role'])){
                    $query = "SELECT * FROM posts WHERE post_category_id = {$post_category}";
                }
                else {
                    $query = "SELECT * FROM posts WHERE post_category_id = $post_category AND post_status='published'";
                }
                //$query = "SELECT * FROM posts WHERE post_category_id = $post_category AND post_status='published'";
                $select_all_posts_query = mysqli_query($connection,$query);
                if(mysqli_num_rows($select_all_posts_query) < 1){
                    echo "<h1 class='text-center' style='font-weight:bold'>No posts available under this category</h1>";
                }
                else {
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_content = substr($row['post_content'],0,120);
                    $post_image = $row['post_image'];
            ?>
            <h1 class="page-header">
<!--                Page Heading-->
<!--                <small>Secondary Text</small>-->
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="/blogcms/post/<?php echo $post_id;?>"><?php echo $post_title;?></a>
            </h2>
            <p class="lead">
                by <a href="/blogcms/author_posts.php?author=<?php echo $post_user;?>&p_id=<?php echo $post_id;?>"><?php echo $post_user;?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
            <hr>
            <img class="img-responsive" src="/blogcms/images/<?php echo $post_image;?>" alt="">
            <hr>
            <p><?php echo $post_content;?></p>
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
             <?php } } }
            else {
                    header("location: index.php");
                }
            ?>
        </div>
       

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include "includes/footer.php";?>