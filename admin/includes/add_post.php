<?php
    if(isset($_POST['create_post'])){
        $post_title = escape($_POST['title']);
        $post_author = escape($_POST['post_user']);
        $post_category_id = escape($_POST['post_category']);
        $post_status = escape($_POST['post_status']);
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_tags = escape($_POST['post_tags']);
        $post_content = mysqli_real_escape_string($connection,$_POST['post_content']);
        $post_date = date('d-m-y');
        move_uploaded_file($post_image_temp,"../images/$post_image");
        if(!empty($post_title) && !empty($post_author) && !empty($post_category_id) && !empty($post_status) && !empty($post_image) && !empty($post_tags) && !empty($post_content)){
            $query = "INSERT INTO posts(post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status) VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}')";
            $create_post_query = mysqli_query($connection,$query);
            confirmQuery($create_post_query);
            $the_post_id = mysqli_insert_id($connection);
            if(!confirmQuery($create_post_query)){
                echo "<h4 class='alert alert-success' role='alert' >Post Added Successfully <a href='/blogcms/post/{$the_post_id}'><b>View Post</b></a> OR <a href='posts?source=add_post'><b>Add More Post</b></a></h4>";
            }
        }
        else {
            echo "<h5 class='alert alert-danger'>Fields can not be empty!</h5>";
        }
    }
?>
  
   <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    
    <div class="form-group">
        <label for="post_category">Category</label>
        <select name="post_category" id="post_category" style="width: 150px;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
            <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection,$query);
                confirmQuery($select_categories);
                while($row = mysqli_fetch_assoc($select_categories)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='$cat_id'>$cat_title</option>";
                } 
            ?>
        </select>
        
    </div>
    <div class="form-group">
        <label for="post_author">User</label>
        <select name="post_user" id="post_author" style="width: auto;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
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
    
    
    
    <div class="form-group">
<!--        <input type="text" class="form-control" name="post_status">-->
        <select name="post_status" id="" style="width: 150px;height: 29px;border-radius: 4px;border-color: lightblue;padding: 4px;border:2px solid lightblue">
            <option value="draft">Post Status</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
       <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>

