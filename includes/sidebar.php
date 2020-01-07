<?php
    if(ifItIsMethod('post')){
        if(isset($_POST['username']) && isset($_POST['password'])){
            login_user($_POST['username'], $_POST['password']);
        }
//        else{
//			redirect('index');
//		}
            
    }
?>
   <div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="/blogcms/search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Search Articles" required>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!--search form -->
        <!-- /.input-group -->
    </div>
    <!--user Login -->
    <div class="well">
        <?php if(isset($_SESSION['user_role'])):?>
        <h4>Logged in as <strong><?php echo $_SESSION['username']?></strong></h4>
        <a href="/blogcms/includes/logout" class="btn btn-primary">Log out</a>
        <?php else: ?>
        <h4>User Login</h4>
        <form method="post">
            <div class="form-group">
               <div class="input-group">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                   <input type="text" name="username" placeholder="Enter username" class="form-control">
               </div>
                
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                <input type="password" name="password" placeholder="Enter password" class="form-control">
                <span class="input-group-btn">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </span>
            </div>
            <br>
            <div class="form-group">
                <a href="reset.php?reset=<?= uniqid(true); ?>">Forgot Password?</a>
            </div>
        </form>
        <!--search form -->
        <!-- /.input-group -->
        <?php endif;?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <?php
            $query = "SELECT * FROM categories";
            $select_categories_sidebar = mysqli_query($connection,$query);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                        while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        echo "<li><a href='/blogcms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <?php include 'widget.php';?>
</div>