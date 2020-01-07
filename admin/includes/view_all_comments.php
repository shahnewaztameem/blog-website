<?php include "delete_modal.php"?>
   <?php
    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId){
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options){
                case 'Approved':
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$postValueId}";
                    $update_to_published_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_published_status);
                    break;
                case 'Unapproved':
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$postValueId}";
                    $update_to_draft_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_draft_status);
                    break;
                case 'delete':
                    $query = "DELETE FROM comments WHERE comment_id = {$postValueId}";
                    $update_to_delete_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_delete_status);
                    break;
                        
                    
            }
        }
    }

?>
   

   <div class="table-responsive">
   <form action="" method="post">
   <div id="bulkOptionContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Approved">Approve</option>
            <option value="Unapproved">Unapprove</option>
            <option value="delete">Delete</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th><input type="checkbox" id="selectAllBoxex"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Comments</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response to</th>
                <th>Date</th>
                <th style="width:20px">Approve</th>
                <th style="width:20px">Unapprove</th>
                <th style="width:20px">Delete</th>
          </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * from comments";
            $select_post = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_post)){
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_email = $row['comment_email'];
                $comment_content = $row['comment_content'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
            echo "<tr>"; ?>
            <td>
            <input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='<?php echo $comment_id;?>'>
            </td>
            <?php
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_content}</td>";

            echo "<td>{$comment_email}</td>";
                if($comment_status == "Approved"){
                    $class="alert-success";
                }
                else{
                    $class="alert-danger";
                }
            echo "<td ><strong class='$class'>{$comment_status}</strong></td>";
            //get the post that commented on
            $query = "SELECT * from posts WHERE post_id = $comment_post_id";
            $select_post_id_query = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_post_id_query)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            }
            echo "<td>{$comment_date}</td>";
            echo "<td><a class='btn btn-success btn-sm' href='comments.php?approve=$comment_id'>Approve</a></td>";
            echo "<td><a class='btn btn-info btn-sm' href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
            //echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='comments.php?delete=$comment_id'>Delete</a></td>";
            echo "<td><a rel='$comment_id' href='javascript:void(0)' class='delete_link btn btn-danger btn-sm'>Delete <i class='fa fa-trash-o'></a></td>";
            echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    
//        approve comments
        if(isset($_GET['unapprove'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $the_comment_id = escape($_GET['unapprove']);
                    $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $the_comment_id";
                    $unapprove_comment_query = mysqli_query($connection,$query);
                    confirmQuery($unapprove_comment_query);
                    header("Location: comments.php");
                }
            }
            
        }
//    unapprove comments
        if(isset($_GET['approve'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $the_comment_id = escape($_GET['approve']);
                    $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $the_comment_id";
                    $approve_comment_query = mysqli_query($connection,$query);
                    confirmQuery($approve_comment_query);
                    header("Location: comments.php");
                }
            }
           
        }
    
    //delete comments
        if(isset($_GET['delete'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $the_comment_id = escape($_GET['delete']);
                    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
                    $delete_query = mysqli_query($connection,$query);
                    confirmQuery($delete_query);
                    header("Location: comments.php");
                }
            }
            
        }
    
    ?>
       </form>
</div>
<script>
//modal delete confirmation
    $(document).ready(function(){
        $(".delete_link").on('click',function(){
            var id = $(this).attr("rel");
            var delete_url = "comments.php?delete="+id+" ";
            $(".modal_delete_link").attr("href",delete_url);
            $("#myModal").modal('show');
        });
    });
</script>