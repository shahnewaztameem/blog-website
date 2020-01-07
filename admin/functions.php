<?php
//redirection
    function redirect($location){
        header("location:" .$location);
        exit;
    }

	//query return with connection var
	function query($query){
		global $connection;
		$result = mysqli_query($connection, $query);
		confirmQuery($result);
		return $result;
	}

	//get all posts for specific user

	function get_all_user_posts(){
		$result = query("SELECT * FROM posts WHERE user_id=".loggedInUserId()."");
		confirmQuery($result);
		return $result;
	}
	
	//get all comments for specific user
	function get_all_posts_user_comments(){
		$result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()."");
		confirmQuery($result);
		return $result;
	}
	
	//get catagories by users
	function get_all_user_categoreis(){
		$result = query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
		confirmQuery($result);
		return $result;
	}

	//get all user publish posts

	function get_all_user_published_posts(){
		$result = query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='published'");
		confirmQuery($result);
		return $result;
	}

	//get all user draft posts

	function get_all_user_draft_posts(){
		$result = query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='draft'");
		confirmQuery($result);
		return $result;
	}

	function get_all_user_approved_posts_comments(){
		$result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status = 'Approved'");
		confirmQuery($result);
		return $result;
	}

	function get_all_user_unapproved_posts_comments(){
		$result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status = 'Unapproved'");
		confirmQuery($result);
		return $result;
	}

	function fetchRecords($result){
		return mysqli_fetch_array($result);
	}

//	get username
	function get_username(){
		if(isset($_SESSION['username'])){
			return $_SESSION['username'];  
		}
		return null;
              
	}
//    check for the get or post method type
    function ifItIsMethod($method=null){
        if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
            return true;
        }
        return false;
    }

//    check if the user is logged in or not
    function isLoggedIn(){
        if(isset($_SESSION['user_role'])){
            return true;
        }
        return false;
    }
	
	// get the logged in user id
	function loggedInUserId(){
		if(isLoggedIn()){
			$result = query("SELECT * FROM users WHERE username='".$_SESSION['username']."'");
			$user = mysqli_fetch_array($result);
			if(mysqli_num_rows($result) >=1){
				return $user['user_id'];
			}
		}
		return false;
	}

	//check if the use liked the post
	function userLikedThisPost($post_id){
		$result = query("SELECT * FROM likes WHERE user_id=".loggedInUserId()." AND post_id={$post_id}");
		return mysqli_num_rows($result) >= 1 ? true : false;
	}
	
	//count the records
	function count_records($result){
		return mysqli_num_rows($result);
	}

	//get post likes 
	function getPostLikes($post_id){
		$result = query("SELECT * FROM likes WHERE post_id=$post_id");
		echo mysqli_num_rows($result);
	}
//    if user logged in and also redirected the user
    function checkIfTheUserIsLoggedInAndRedirect($redirectLocation = null){
        if(isLoggedIn()){
            redirect($redirectLocation);
        }
    }

//escape special characters and mysqli injections
    function escape($string){
        global $connection;
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        $string = mysqli_real_escape_string($connection,$string);
        return $string;
    }

    //total users online

    function users_online(){
        if(isset($_GET['onlineusers'])){
            global $connection;
            if(!$connection){
                session_start();
                include "../includes/db.php";
                $session = session_id();
                $time = time();
                $time_out_in_seconds = 10;
                $time_out = $time - $time_out_in_seconds;
                $query = "SELECT * FROM users_online WHERE session = '{$session}'";
                $send_query = mysqli_query($connection,$query);
                $count_users_online = mysqli_num_rows($send_query);
                if($count_users_online == NULL){
                    mysqli_query($connection,"INSERT INTO users_online(session,time) VALUES('{$session}','{$time}')");
                }
                else {
                    //keep tracking users with time
                    mysqli_query($connection,"UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'");

                }
                $users_online_query =mysqli_query($connection,"SELECT * FROM users_online WHERE time > '{$time_out}'");        
                echo $users_online_count = mysqli_num_rows($users_online_query);
            }
        }
    }
    users_online();

//check for query error

    function confirmQuery($result){
        global $connection;
        if(!$result){
            die("Query Failed".mysqli_error($connection));
        }
    }

//insert to caterogies

    function insert_categories(){
        global $connection;
        if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)){
        echo "<h5 class='alert alert-danger'>This field should not be empty</h5>";
        }
        else{
        $query = "INSERT INTO categories(cat_title) VALUES('{$cat_title}')";
        $create_category_query = mysqli_query($connection,$query);
        echo "<h5 class='alert alert-success'>Category Added</h5>";
        if(!$create_category_query){
        die("QUERY FAILED ".mysqli_error($connection));
                }
            }
        }
    }

    function findAllCategories(){
        global $connection;
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        //echo "<td style='width: 10%;'><a class='btn btn-danger btn-sm' href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td style='width: 10%;'><a rel ='$cat_id' class='btn btn-danger btn-sm delete_link' href='javascript:void(0)'>Delete <i class='fa fa-trash-o'></i></a></td>";
        echo "<td style='width: 10%;'><a class='btn btn-info btn-sm' href='categories.php?edit={$cat_id}'>Edit <i class='fa fa-pencil-square-o'></i></a></td>";
        echo "</tr>";   
        }
    }

    function delete_categories(){
        global $connection;    
        if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        $delete_query = mysqli_query($connection,$query);
        header("location:categories.php");
        }
    }

//return the total count of individual tables

    function recordCount($table){
        global $connection;
        $query = "SELECT * FROM {$table}";
        $select_all_post_query = mysqli_query($connection,$query);
        return mysqli_num_rows($select_all_post_query);
    }

//return the status of the post,comment i.e. published,draft,upapproved

    function checkStatus($table, $column, $status){
        global $connection;
        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $result = mysqli_query($connection,$query);
        return mysqli_num_rows($result);
    }
    
//return the status of the user
    function checkUserRole($table, $column, $status){
        global $connection;
        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $result = mysqli_query($connection,$query);
        return mysqli_num_rows($result);
    }

//check logged in user is admin or not 
    function is_admin(){
        //global $connection;
		if(isLoggedIn()){
			$result = query("SELECT user_role FROM users WHERE user_id=".$_SESSION['user_id']."");
			confirmQuery($result);
			$row = mysqli_fetch_assoc($result);

			//check for user role
			if($row['user_role'] == 'admin'){
				return true;
			}
			else {
				return false;
			}
		}
        return false;

    }

//check for existing username
    function username_exists($username) {
        global $connection;
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = mysqli_query($connection,$query);
        confirmQuery($result);
//        check for the existance of username
        if(mysqli_num_rows($result) > 0) {
            return true;
        }
        else {
            return false;
        }
        
    }

//check for existing email
    function email_exists($email) {
        global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = mysqli_query($connection,$query);
        confirmQuery($result);
//        check for the existance of username
        if(mysqli_num_rows($result) > 0) {
            return true;
        }
        else {
            return false;
        }
        
    }

//user registration
    function register_user($username, $email, $password){
        global $connection;
        
        $username = mysqli_real_escape_string($connection,$username);
        $email    = mysqli_real_escape_string($connection,$email);
        $password = mysqli_real_escape_string($connection,$password);
        
        $password = password_hash($password, PASSWORD_BCRYPT, array("cost"=>10));
        $query    = "INSERT INTO users (username, user_email, user_password, user_role, created_date) VALUES ('{$username}','{$email}', '{$password}', 'subscriber',now())";
        $register_user_query = mysqli_query($connection, $query);
        confirmQuery($register_user_query);
    }

//login functionality
    function login_user($username, $password){
//        must start the session in order to proceed to the login page after registration
        
        //session_start();
        global $connection;
        
//        prevent mysqli injection
        
        $username = mysqli_real_escape_string($connection,$username);
        $password = mysqli_real_escape_string($connection,$password);
//        query to fetch username
        
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_user_query = mysqli_query($connection,$query);
        confirmQuery($select_user_query);
        
//        loop through to get all the info from users table 

        while($row = mysqli_fetch_assoc($select_user_query)){
            $db_user_id                 = $row['user_id'];
            $db_username             = $row['username'];
            $db_user_password     = $row['user_password'];
            $db_firstname             = $row['user_firstname'];
            $db_lastname             = $row['user_lastname'];
            $db_email                  = $row['user_email'];
            $db_user_role            = $row['user_role'];
            if(password_verify($password, $db_user_password)){
            
//            assign db credentials to the sessions
            
            $_SESSION['user_id']     	= $db_user_id;
            $_SESSION['username']     	= $db_username;
            $_SESSION['firstname']     	= $db_firstname;
            $_SESSION['lastname']      	= $db_lastname;
            $_SESSION['email']          = $db_email;
            $_SESSION['user_role']      = $db_user_role;
            
//            redirect to the control panel
            
            redirect("/blogcms/admin");
            }
            else{
            return false;
            }
        }
        return true;
        
    }
?>