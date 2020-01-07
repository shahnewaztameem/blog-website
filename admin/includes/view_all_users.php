<?php include "delete_modal.php"?>
   <div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>User Role</th>
                <th colspan='2' class="text-center">Change User's Role</th>
                <th width="20px">Delete</th>
                <th width="20px">Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * from users";
            $select_post = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_post)){
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_password = $row['user_password'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
                $user_email = $row['user_email'];
                $user_image = $row['user_image'];
                $user_role = $row['user_role'];
            
            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
            echo "<td class='change-role'><a href='users.php?change_to_admin={$user_id}'>Change Role to Admin</a></td>";
            echo "<td class='change-role'><a href='users.php?change_to_subscriber={$user_id}'>Change Role to Subscriber</a></td>";
            //echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='users.php?delete={$user_id}'>Delete</a></td>";
                if($_SESSION['username'] == $username){
                    echo "<td><a rel='$user_id' href='javascript:void(0)' class='delete_link  btn btn-danger btn-sm disabled'>Delete <i class='fa fa-trash-o'></a></td>";
                }
                else {
                    echo "<td><a rel='$user_id' href='javascript:void(0)' class='delete_link  btn btn-danger btn-sm'>Delete <i class='fa fa-trash-o'></a></td>";
                }
            echo "<td><a class='btn btn-info btn-sm' href='users.php?source=edit_user&user_id={$user_id}'>Edit <i class='fa fa-pencil-square-o'></a></td>";
            echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    
//        change role to admin
        if(isset($_GET['change_to_admin'])){
            $the_user_id = escape($_GET['change_to_admin']);
            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id}";
            $change_to_admin_comment_query = mysqli_query($connection,$query);
            confirmQuery($change_to_admin_comment_query);
            header("Location: users.php");
        }
//    change role to subscriber
        if(isset($_GET['change_to_subscriber'])){
            $the_user_id = escape($_GET['change_to_subscriber']);
            $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$the_user_id}";
            $change_to_subscriber_comment_query = mysqli_query($connection,$query);
            confirmQuery($change_to_subscriber_comment_query);
            header("Location: users.php");
        }
    
    //delete users 
        if(isset($_GET['delete'])){
            if(isset($_SESSION['user_role'])){
                if($_SESSION['user_role'] == 'admin'){
                    $the_user_id = escape($_GET['delete']);
                    $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
                    $delete_user_query = mysqli_query($connection,$query);
                    confirmQuery($delete_user_query);
                    header("Location: users.php");
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
            var delete_url = "users.php?delete="+id+" ";
            $(".modal_delete_link").attr("href",delete_url);
            $("#myModal").modal('show');
        });
    });
</script>