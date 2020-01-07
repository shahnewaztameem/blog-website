<?php
    if(isset($_GET['p_id'])){
        $the_post_id = escape($_GET['p_id']);
    }
    $query = "SELECT * from posts where post_id = $the_post_id";
    $select_post_by_id = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($select_post_by_id)){
    $post_id = $row['post_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
}
    if(isset($_POST['update_post'])){
        $post_title = escape($_POST['title']);
        $post_user = escape($_POST['post_user']);
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_tags = escape($_POST['post_tags']);
        $post_content = mysqli_real_escape_string($connection,$_POST['post_content']);
        move_uploaded_file($post_image_temp, "../images/$post_image");
        if(empty($post_image)){
            $query = "SELECT * from posts WHERE post_id = $the_post_id";
            $select_image = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_image)){
                $post_image = $row['post_image'];
            }
        }
        $update_query = "UPDATE posts SET
        post_title = '{$post_title}', 
        post_category_id = '{$post_category_id}', 
        post_date = now(), 
        post_user = '{$post_user}', 
        post_status = '{$post_status}', 
        post_tags = '{$post_tags}', 
        post_content = '{$post_content}', 
        post_image = '{$post_image}' WHERE post_id = {$the_post_id} ";
        //execute query
        $update_post = mysqli_query($connection,$update_query);
        confirmQuery($update_post);
        if(!confirmQuery($update_post)){
            echo "<h4 class='alert alert-success' role='alert'>Post Updated Successfully <a href='/blogcms/post/{$the_post_id}'><b>View Post</b></a> OR <a href='posts'><b>Edit More Post</b></a></h4>";
        }
    }
    
?>
   

   
   
   <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?= $post_title;?>" type="text" class="form-control" name="title">
    </div>
    
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select name="post_category" id="" style="width: 150px;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
            <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection,$query);
                confirmQuery($select_categories);
                while($row = mysqli_fetch_assoc($select_categories)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    if($cat_id == $post_category_id) {
                        echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                    }
                    else {
                        echo "<option value='{$cat_id}'>{$cat_title}</option>";
                    }
                }
                
            ?>
        </select>
        
    </div>
    <div class="form-group">
        <label for="post_user">User</label>
        <select name="post_user" id="" style="width: auto;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
            <?php
                $query = "SELECT * FROM users";
                $select_users = mysqli_query($connection,$query);
                confirmQuery($select_users);
                while($row = mysqli_fetch_assoc($select_users)){
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    echo "<option value='$username'>$username</option>";
                } 
            ?>
        </select>
        
    </div>
<!--
    <div class="form-group">
        <label for="title">Post Author</label>
        <input value="<?= $post_user;?>" type="text" class="form-control" name="author">
    </div>
-->
    
    <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select name="post_status" id="" style="width: 150px;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            <?php
                if($post_status == 'published') {
                    echo "<option value='draft'>Draft</option>";
                }
                else {
                    echo "<option value='published'>Published</option>";
                }
            
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <br>
        <img width="100" src="../images/<?php echo $post_image;?>" alt="">
        <input type="file" name="image" style="margin-top:10px;">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?= $post_tags;?>" type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="30"><?php echo str_replace('\r\n','<br>',$post_content);?></textarea>
    </div>
    <div class="form-group">
       <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>