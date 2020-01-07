<?php
    $pageName = basename($_SERVER['PHP_SELF']);
    $index = "index.php";
    $posts = "posts.php";
    $categories = "categories.php";
    $comments = "comments.php";
    $users = "users.php";
    $profile = "profile.php";
	$dashboard = "dashboard.php";
    //assign
    $index_active_class 		= '';
    $posts_active_class 		= '';
    $categories_active_class 	= '';
    $comments_active_class 		= '';
    $users_active_class 		= '';
    $profile_active_class 		= '';
    $dashboard_active_class 	= '';
    if($pageName == $index){
        $index_active_class = 'active';
    }
    else if($pageName == $posts){
        $posts_active_class = 'active';
    }
    else if($pageName == $categories){
        $categories_active_class = 'active';
    }
    else if($pageName == $comments){
        $comments_active_class = 'active';
    }
    else if($pageName == $users){
        $users_active_class = 'active';
    }
    else if($pageName == $profile){
        $profile_active_class = 'active';
    }
	else if($pageName == $dashboard){
        $dashboard_active_class = 'active';
    }

?>
           <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/blogcms/admin">CMS Admin Panel</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
<!--                <li><a href=""><span class="online"></span>Users online:  //users_online() </a></li>-->
                <li><a href=""><span class="online"></span>Users online: <span class="users-online"></span></a></li>
                <li><a href="../">Main Site</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                        <?php
                            if(isset($_SESSION['username']))
                            echo $_SESSION['username'];
                        ?>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class='<?= $index_active_class?>'>
                        <a href="/blogcms/admin"><i class="fa fa-fw fa-dashboard"></i> My Dashboard</a>
                    </li>
                    <?php if(is_admin()): ?>
					<li class='<?= $dashboard_active_class?>'>
                        <a href="/blogcms/admin/dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                     <?php endif; ?>
                    <li class='<?= $posts_active_class?>'>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-list-alt"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="/blogcms/admin/posts"><i class="fa fa-fw fa-eye"></i> View All Posts</a>
                            </li>
                            <li>
                                <a href="/blogcms/admin/posts?source=add_post"><i class="fa fa-fw fa-plus-circle"></i> Add Posts</a>
                            </li>
                        </ul>
                    </li>
                    <li class='<?= $categories_active_class?>'>
                        <a href="/blogcms/admin/categories"><i class="fa fa-fw fa-th-large"></i> Categories</a>
                    </li>
    
                    <li class='<?= $comments_active_class?>'>
                        <a href="/blogcms/admin/comments"><i class="fa fa-fw fa-comments"></i> Comments</a>
                    </li>
                    <li class='<?= $users_active_class?>'>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="/blogcms/admin/users"><i class="fa fa-fw fa-eye"></i> View All Users</a>
                            </li>
                            <li>
                                <a href="/blogcms/admin/users?source=add_user"><i class="fa fa-fw fa-plus-circle"></i> Add User</a>
                            </li>
                        </ul>
                    </li>
                    
                     <li class='<?= $profile_active_class?>'>
                        <a href="/blogcms/admin/profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

