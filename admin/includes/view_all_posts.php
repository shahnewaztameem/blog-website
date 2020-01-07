<?php include "delete_modal.php"?>
   <?php
    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId){
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options){
//              publish posts according to the check box
                    
                case 'published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                    $update_to_published_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_published_status);
                    break;
//              draft posts according to the check box

                case 'draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                    $update_to_draft_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_draft_status);
                    break;
                case 'delete':
//                  delete posts according to the check box
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                    $update_to_delete_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_delete_status);
                    break;
                case 'clone':
//                  clone posts according to the check box 
                    
                    $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                    $select_post_query = mysqli_query($connection,$query);
                    while($row = mysqli_fetch_assoc($select_post_query)){
                        $post_category_id   = $row['post_category_id'];
                        $post_title         = $row['post_title'];
                        $post_user          = $row['post_user'];
                        $post_date          = $row['post_date'];
                        $post_image         = $row['post_image'];
                        $post_content       = $row['post_content'];
                        $post_tags          = $row['post_tags'];
                        $post_status        = $row['post_status'];
                    }
                    $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}', '{$post_tags}', '{$post_status}')";
                    $copy_post_query = mysqli_query($connection,$query);
                    
                    if(!$copy_post_query){
                        die("Query Error!! ".mysqli_error($connection) . ' ' . mysqli_errno($connection));
                    }
                    
            }
        }
    }

?>
  <div class="table-responsive">
   <form action="" method="post">
    <div id="bulkOptionContainer" class="col-xs-4">
<!--       bulk options for all the posts-->
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
            <th><input type="checkbox" id="selectAllBoxex"></th>
            <th>Id</th>
            <th>Users</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Images</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th style="width:20px;">Edit</th>
            <th style="width:20px;">Delete</th>
            <th>Views</th>
            </tr>
        </thead>
        <tbody>
            <?php
//            last post show first
            //$query = "SELECT * from posts ORDER BY post_id DESC";
            
            
//            joining posts and catogory tables to get all the property of posts and categories table
            $query ="SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, ";
            $query .="categories.cat_id, categories.cat_title ";
            $query .="FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
            $select_post = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_post)){
                $post_id            = $row['post_id'];
                $post_author        = $row['post_author'];
                $post_user          = $row['post_user'];
                $post_title         = $row['post_title'];
                $post_category_id   = $row['post_category_id'];
                $post_status        = $row['post_status'];
                $post_image         = $row['post_image'];
                $post_tags          = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date          = $row['post_date'];
                $post_views_count   = $row['post_views_count'];
                $cat_id             = $row['cat_id'];
                $cat_title          = $row['cat_title'];
            echo "<tr>"; ?>
            
            <td>
            <!--get the individual post id-->
            <input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='<?php echo $post_id;?>'>
            
            </td>
            
            <?php
            echo "<td>{$post_id}</td>";

            if(!empty ($post_user)) {
                echo "<td>{$post_user}</td>";
            }
            elseif(!empty ($post_author)) {
                 echo "<td>{$post_author}</td>";
            }
                
            echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
            $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            $select_category_id = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_category_id)){
                $cat_title = $row['cat_title'];
                echo "<td>{$cat_title}</td>";
            }
            echo "<td>{$post_status}</td>";
            echo "<td><img width='100' src='../images/{$post_image}' alt='post_image' style='display:block;margin:auto;'></td>";
            echo "<td>{$post_tags}</td>";
            
//          query to get comment by id
            $query                          = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
            $send_comment_query = mysqli_query($connection,$query);
            $count_comments        = mysqli_num_rows($send_comment_query);
                
            $row = mysqli_fetch_assoc($send_comment_query);
            $comment_id = $row['comment_id'];
//          comment count and redirect to the comment according to post
            echo "<td><a href='post_comment.php?id=$post_id'>{$count_comments}</a></td>";
                
                
            echo "<td>{$post_date}</td>";
            echo "<td><a class='btn btn-info btn-sm' href='posts.php?source=edit_post&p_id={$post_id}'>Edit <i class='fa fa-pencil-square-o'></i></a></td>";
            //echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link btn btn-danger btn-sm'>Delete <i class='fa fa-trash-o'></i></a></td>";
            echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to reset post views?'); \" href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
            echo "</tr>";
            }
            ?>
            
        </tbody>
    </table>
    </form>
    <?php
        //delete post
        if(isset($_GET['delete'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $the_post_id = escape($_GET['delete']);
                    $query = "DELETE FROM posts WHERE post_id =". mysqli_real_escape_string($connection,$the_post_id) ." ";
                    $delete_query = mysqli_query($connection,$query);
                    confirmQuery($delete_query);
                    //call to function redirect to the specific page
                    redirect("posts.php");
                }
            }
            
        }
      
//      reset post view count
      if(isset($_GET['reset'])){
          if(isset($_SESSION['user_role'])){
              if($_SESSION['user_role'] == 'admin'){
                  $the_post_id = escape($_GET['reset']);
                  $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =". mysqli_real_escape_string($connection,$the_post_id) ." ";
                  $reset_post_count_query = mysqli_query($connection,$query);
                  confirmQuery($reset_post_count_query);
                  header("location: posts.php");
              }
          }
          
      }
    
    ?>
    
</div>

<script>
//modal delete confirmation
    $(document).ready(function(){
        $(".delete_link").on('click',function(){
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete="+id+" ";
            $(".modal_delete_link").attr("href",delete_url);
            $("#myModal").modal('show');
        });
    });
</script>
