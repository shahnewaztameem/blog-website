<form action="" method="post">
  <div class="form-group">
    <label for="cat_title">Edit Category
    </label>
    <?php
        if(isset($_GET['edit'])){
        $cat_id = escape($_GET['edit']);
        $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
        $select_categories_id = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_categories_id)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
    }?>
    <input value="<?php if(isset($cat_title)) {echo $cat_title;}?>" class="form-control" type="text" name="cat_title" placeholder="Type category name">
    <?php }?>
    <?php
//update category
if(isset($_POST['update_category'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role']=='admin'){
            $the_cat_title = escape($_POST['cat_title']);
            $query = "UPDATE categories SET cat_title= '{$the_cat_title}' where cat_id = {$cat_id}";
            $update_query = mysqli_query($connection,$query);
            if(!$update_query){
            die("UPDATING QUERY FAILED ".mysqli_error($connection));
        }
    }

}
}
?>
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" value="Update Category" name="update_category">
  </div>
</form>
