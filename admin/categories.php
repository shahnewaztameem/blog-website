<?php include "includes/admin_header.php";?>
<?php include "includes/delete_modal.php";?>


<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php";?>
    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome To Admin Dashboard
                        <small>
                           <?php
                                if(isset($_SESSION['username']))
                                echo $_SESSION['username'];
                            ?>
                        </small>
                    </h1>
                    <div class="col-xs-6">
<!--                       insert categories-->
                        <?php insert_categories(); ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Add Category</label>
                                <input class="form-control" type="text" name="cat_title" placeholder="Type category name">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form> <!-- add category -->
                        <?php
                            //update and include query
                            if(isset($_GET['edit'])){
                                $cat_id = $_GET['edit'];
                            
                                include "includes/update_categories.php";
                            }

                        ?>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-responsive table-hover table-striped">
                            <thead class="thead-dark">
                                <th>Id</th>
                                <th>Category</th>
                                <th>Delete</th>
                                <th>Edit</th>
                                

                            </thead>
                            <tbody align="center">

                                <?php
                                //Find all categories query
                                    findAllCategories();
                                ?>
                                <?php
                                //delete query
                                    delete_categories();
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php";?>
    
   <script>
//modal delete confirmation
    $(document).ready(function(){
        $(".delete_link").on('click',function(){
            var id = $(this).attr("rel");
            var delete_url = "categories.php?delete="+id+" ";
            $(".modal_delete_link").attr("href",delete_url);
            $("#myModal").modal('show');
        });
    });
</script>