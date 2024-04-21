<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (isset($_POST['product_id'])){
   $product_id  = $_POST['product_id'] ;
}
if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $select = mysqli_query($conn, "SELECT * FROM `cart`,`products` WHERE cart.product_id = products.product_id AND cart.user_id = '$user_id' AND cart.product_id = '$product_id'") or die('query failed');
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   $fetch_quantity = mysqli_fetch_assoc($select) ;
   $update_quantity = $cart_quantity - $fetch_quantity['cart_quantity']  ; 
   if ($update_quantity > $fetch_quantity['product_quantity'])
   {
      $message[] = 'Số lượng sách trong kho không đủ!';
   }
   else {
      mysqli_query($conn, "UPDATE `cart` SET cart_quantity = '$cart_quantity' WHERE cart_id = '$cart_id'") or die('query failed');
      $update_product_quantity = $fetch_quantity['product_quantity'] - $update_quantity ; 
      mysqli_query($conn,"UPDATE `products` SET product_quantity = '$update_product_quantity' WHERE product_id = '$product_id'") ; 
      $message[] = 'Cập nhật số lượng thành công!';
   }
   
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $id = $_GET['id'];
   $quantity = $_GET['quantity'];
   $old = mysqli_query($conn,"Select * from `products` where product_id = '$id'");
   
      while($fetch_products = mysqli_fetch_assoc($old)){
         $quantity_old = $fetch_products['product_quantity'];
         $update_quantity = $quantity + $quantity_old ;
         mysqli_query($conn,"Update products set product_quantity = $update_quantity where product_id = '$id'");
         mysqli_query($conn, "DELETE FROM `cart` WHERE cart_id = '$delete_id'") or die('query failed');
         header('location:cart.php');
   
}

   
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giỏ hàng</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Đơn hàng</h3>
   <p> <a href="home.php">Trang chủ</a> / Giỏ hàng </p>
</div>

<section class="shopping-cart">

   <h1 class="title">Giỏ hàng của bạn</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`,`products` WHERE cart.product_id = products.product_id AND user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['cart_id']; ?>&quantity=<?php echo $fetch_cart['cart_quantity']?>&id=<?php echo $fetch_cart['product_id']?>" class="fas fa-times" style="height: 2.5rem; width: 2.5rem; line-height: 2.5rem;"onclick="return confirm('Xóa sản phẩm khỏi giỏ hàng?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['product_image']; ?>" alt="">
         <div class="name" style="font-size : 2rem">Tên sản phẩm: <?php echo $fetch_cart['product_name']; ?></div>
         <div class="price">Giá: <?php echo $fetch_cart['product_price_curent']; ?> VNĐ</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['cart_id']; ?>"> 
            <input type="hidden" name="product_id" value="<?php echo $fetch_cart['product_id']; ?>"> 
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['cart_quantity']; ?>">
            <button name="update_cart" class="btn">Cập nhật</button>
         </form>
         <div class="sub-total"> Tổng cộng : <span> <?php echo $sub_total = ($fetch_cart['cart_quantity'] * $fetch_cart['product_price_curent']); ?> VNĐ</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Giỏ hàng trống</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Xóa bỏ tất cả?');">Xóa bỏ</a>
   </div>

   <div class="cart-total">
      <p>Tổng cộng : <span><?php echo $grand_total; ?> VNĐ</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">Tiếp tục mua sắm</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Tiến hành thanh toán</a>
      </div>
   </div>

</section>



<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>