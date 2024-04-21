<?php

include 'config.php';

session_start();


$admin_id = $_SESSION['admin_id'];
$search_id = "";
if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){
   $id = mysqli_real_escape_string($conn,$_POST['id']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price_old = mysqli_real_escape_string($conn, $_POST['price_old']);
   $price_curent = mysqli_real_escape_string($conn, $_POST['price_curent']);
   $date  = mysqli_real_escape_string($conn,$_POST['date']);
   $quantity = mysqli_real_escape_string($conn,$_POST['quantity']);
   $detail = mysqli_real_escape_string($conn,$_POST['detail']);
   $image = $_FILES['image']['name'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_size = $_FILES['image']['size'];
   $folder = 'images/Quan/'.$image;
   $cat_id = mysqli_real_escape_string($conn,$_POST['cat_id']);

   $select_product_id = mysqli_query($conn, "SELECT product_id FROM `products` WHERE product_id = '$id'") or die('query failed');

   if(mysqli_num_rows($select_product_id) > 0){
      $message[] = 'Mã sản sản phẩm trùng';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(product_id, product_name, product_price_old, product_price_curent, product_quantity, product_image,product_date, product_detail, cat_id ) VALUES('$id', '$name', '$price_old', '$price_curent', '$quantity', '$image', '$date', '$detail', '$cat_id')") or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'Kích thước ảnh không phù hợp';
         }else{
            $message[] = 'Thêm sản phẩm thành công';
            move_uploaded_file($image_tmp_name, $folder);
         }
      }else{
         $message[] = 'Không thể thêm sản phẩm';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $product = mysqli_query($conn, "Select product_id FROM `cart` WHERE product_id = '$delete_id'") or die('query failed');
   if (mysqli_fetch_assoc($product) > 0)
   {
     
      $message[] = "Xóa không thành công, sản phẩm đang nằm trong giỏ hàng của khách hàng!";
   }
   else {
      $del = mysqli_query($conn, "DELETE FROM `products` WHERE product_id = '$delete_id'") or die('query failed');
      $delete_image_query = mysqli_query($conn, "SELECT product_image FROM `products` WHERE product_id = '$delete_id'") or die('query failed');
      $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
      unlink('images/Quan/'.$fetch_delete_image['product_image']);

   }
   
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price_old = $_POST['update_price_old'];
   $update_price_curent = $_POST['update_price_curent'];
   $update_quantity = $_POST['update_quantity'] ; 
   $update_detail = $_POST['update_detail'];
   $update_date = $_POST['update_date'];


   mysqli_query($conn, "UPDATE `products` SET product_name = '$update_name', product_price_old = '$update_price_old', product_price_curent = '$update_price_curent', product_quantity = '$update_quantity', product_detail = '$update_detail', product_date = '$update_date' WHERE product_id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'images/Quan/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'Kích thước của ảnh quá lớn, hãy chọn ảnh khác!';
      }else{
         mysqli_query($conn, "UPDATE `products` SET product_image = '$update_image' WHERE product_id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('images/Quan/'.$update_old_image);
         $message[] = 'Cập nhật thông tin thành công!';
      }
   }

   //header('location:admin_products.php');
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sản phẩm</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">Thêm sản phẩm mới</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Sản phẩm</h3>
      <input type="text" name="id" class="box" placeholder="Nhập mã sản phẩm" required>
      <input type="text" name="name" class="box" placeholder="Nhập tên sản phẩm" required>
      <input type="number" min="0" name="price_old" class="box" placeholder="Nhập giá ban đầu" required>
      <input type="number" min="0" name="price_curent" class="box" placeholder="Nhập giá sau khi giảm" required>
      <input type="number" min="1" name="quantity" class="box" placeholder="Nhập số lượng" required>
      <input type="text" name="detail" class="box" placeholder="Nhập thông tin chi tiết"required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="date" min="1" name="date" class="box" placeholder="Nhập ngày nhập háng" required>
      <div class="box">
            <span>Loại sản phẩm:</span>
            <select name="cat_id">
               <option value="A">Áo</option>
               <option value="Q">Quần</option>
               <option value="V">Váy</option>
               <option value="DB">Đồ bộ</option>
               <option value="TS">Túi sách</option>
            </select>
         </div>
      <input type="submit" value="Nhập sách" name="add_product" class="btn">
   </form>

</section>
<section class="add-products">
      <form action="" method="post" enctype="multipart/form-data">
         <h3>Tìm kiếm sản phẩm</h3>
         <input type="number" name="search_id" class="box" min="1" placeholder="Nhập mã sản phẩm" value="<?php echo $search_id?>"required>
         <input type="submit" name="search" class="btn"value="Tìm kiếm">
      </form>
   </section>
<section class="show-products">

   <div class="box-container" style="display: block ;">
   
      <?php
         
         if (isset($_POST['search']))
         {
            $search_id = $_POST['search_id'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` where product_id = $search_id") or die('query failed');
         }
         else 
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['product_image']; ?>" alt="">
         <div class="id" style="font-size: 2rem">ID: <?php echo $fetch_products['product_id']; ?></div>
         <div class="name">Tên: <?php echo $fetch_products['product_name']; ?></div>
         <div class="price">Giá ban đầu: <?php echo $fetch_products['product_price_old']; ?> VNĐ</div>
         <div class="price">Giá sau khi giảm: <?php echo $fetch_products['product_price_curent']; ?> VNĐ</div>
         <div class="price">Số lượng: <?php echo $fetch_products['product_quantity']; ?> Cái</div>
         <a href="admin_products.php?update=<?php echo $fetch_products['product_id']; ?>" class="option-btn" >Cập nhật</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['product_id']; ?>" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa bỏ</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Mã sản phẩm tìm kiếm không tồn tại!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE product_id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['product_id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['product_image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['product_image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['product_name']; ?>" class="box" required placeholder="Nhập tên sản phẩm">
      <input type="number" name="update_price_old" value="<?php echo $fetch_update['product_price_old']; ?>" min="0" class="box" required placeholder="Nhập giá sản phẩm ban đầu">
      <input type="number" name="update_price_curent" value="<?php echo $fetch_update['product_price_curent']; ?>" min="0" class="box" required placeholder="Nhập giá sản phẩm sau giảm giá">
      <input type="number" name="update_quantity" value="<?php echo $fetch_update['product_quantity']; ?>" min="0" class="box" required placeholder="Nhập số lượng sản phẩm">
      <input type="text" name="update_detail" value="<?php echo $fetch_update['product_detail']; ?>"  class="box" required placeholder="Nhập mô tả sản phẩm">

      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="date" name="update_date" value="<?php echo $fetch_update['product_date']; ?>" min="0" class="box" required placeholder="Nhập ngày nhập sản phẩm">
      <input type="submit" value="Cập nhật" name="update_product" class="btn" onclick="return confirm('Bạn có chắc chắn muốn cập nhật thông tin này?');">
      <input type="reset" value="Hủy bỏ" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>


<script src="js/admin_script.js"></script>

</body>
</html>