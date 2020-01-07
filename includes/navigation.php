
<?php //include "admin/functions.php"?>
   <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
       <div class="container">
           <!-- Brand and toggle get grouped for better mobile display -->
           <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="/blogcms">Home</a>
           </div>
           <!-- Collect the nav links, forms, and other content for toggling -->
           <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">

                <?php
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection,$query);
                while($row = mysqli_fetch_assoc($select_all_categories_query)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    //active class declaration
                    $category_active_class= '';
                    $registration_active_class= '';
                    $contact_active_class= '';
                    $login_active_class= '';
                    
                    //page declaration
                    $registration_page = 'registration.php';
                    $contact_page = 'contact.php';
                    $login_page = 'login.php';
                    $pageName = basename($_SERVER['PHP_SELF']);
                    
                    if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                        $category_active_class = 'active';
                    }
                    elseif($pageName == $registration_page){
                        $registration_active_class = 'active';
                    }
                    elseif($pageName == $contact_page) {
                        $contact_active_class = 'active';
                    }
                    elseif($pageName == $login_page) {
                        $login_active_class = 'active';
                    }
                    echo "<li class=$category_active_class><a href='/blogcms/category/$cat_id'>{$cat_title}</a></li>";
                } 
            ?>
            <li class='<?php echo $contact_active_class?>'>
                <a href="/blogcms/contact">Contact</a>
            </li>
             <?php
//                    if(isset($_SESSION['user_role'])=='admin'){
//                            echo "<li>
//                                    <a href='/blogcms/admin'>Admin area</a>
//                                </li>";
//                        }
                ?>
<!--
                <li>
                    <a href="admin">Admin</a>
                </li>
-->
                <?php
                    if(isset($_SESSION['user_role'])){
                        if(isset($_GET['p_id'])){
                            $the_post_id = $_GET['p_id'];
                            echo "<li>
                                    <a href='/blogcms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit post</a>
                                </li>";
                        }
                    }
                ?>
            
            </ul>
            <ul class="nav navbar-nav">
               
               <?php if(isLoggedIn()): ?>
                   <li class='<?php echo $registration_active_class?>'>
                       <a href='/blogcms/admin'>Admin area</a>
                    </li>
                    <li >
                       <a href='/blogcms/includes/logout.php'>Logout</a>
                    </li>
                
                <?php else: ?>
                    <li class='<?php echo $registration_active_class?>'>
                       <a href='/blogcms/registration'>Signup</a>
                    </li>
                    <li class='<?php echo $login_active_class?>'>
                       <a href='/blogcms/login'>Login</a>
                    </li>
               <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
