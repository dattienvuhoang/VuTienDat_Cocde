<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
$name = $email = $phone  = $method = $address = $placed_on = "";
if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){
   
   if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['method']) || empty($_POST['flat']) || empty($_POST['street']) || empty($_POST['city']) || empty($_POST['country']) || empty($_POST['pin_code'])) {
      $message[] = 'Vui lòng điền đầy đủ thông tin.';
   }
   else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $message[] = 'Vui lòng nhập đúng định dạng a@b.c .';
   }
   else if (!preg_match("/^[0-9]{10}$/", $_POST['phone'])) {
      $message[] = 'Vui lòng nhập số điện thoại đúng định dạng.';
   }
   else if (!preg_match("/^[a-zA-Z0-9\s]+$/", $_POST['street'])) {
      $message[] = 'Vui lòng nhập đường phố đúng định dạng.';
   }
   else if (!preg_match("/^[a-zA-Z0-9\s]+$/", $_POST['city'])) {
      $message[] = 'Vui lòng nhập thành phố đúng định dạng.';
   }
   else if (!preg_match("/^[a-zA-Z0-9\s]+$/", $_POST['country'])) {
      $message[] = 'Vui lòng nhập quốc gia đúng định dạng.';
   }
   else {
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $phone = mysqli_real_escape_string($conn,$_POST['phone']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $method = mysqli_real_escape_string($conn, $_POST['method']);
      $street = $_POST['street'];
      $city = $_POST['city'] ;
      $country = $_POST['country'];
      $address = mysqli_real_escape_string($conn,  $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']); 
      $placed_on = date('d-M-Y');

      $cart_total = 0;
      $cart_products[] = '';

      $cart_query = mysqli_query($conn, "SELECT * FROM `cart`,`products` WHERE cart.product_id = products.product_id AND user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($cart_query) > 0){
         while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['product_name'].' ('.$cart_item['cart_quantity'].') ';
            $sub_total = ($cart_item['product_price_curent'] * $cart_item['cart_quantity']);
            $cart_total += $sub_total;
         }
      }

      $total_products = implode(', ',$cart_products);

      $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE order_name = '$name' AND order_number = '$phone' AND order_email = '$email' AND order_method = '$method' AND order_address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

      if($cart_total == 0){
         $message[] = 'Giỏ hàng của bạn trống!';
      }else{
         if(mysqli_num_rows($order_query) > 0){
            $message[] = 'order already placed!'; 
         }else{
            mysqli_query($conn, "INSERT INTO `orders`(user_id, order_name, order_number, order_email, order_method, order_address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$phone', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $message[] = 'Đặt hàng thành công!';
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         }
      }
   }
   
   
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thông tin thanh toán</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Thanh toán</h3>
   <p> <a href="home.php">Trang chủ</a> / Thanh toán </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart`,`products` WHERE cart.product_id = products.product_id AND user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['product_price_curent'] * $fetch_cart['cart_quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['product_name']; ?> <span>(<?php echo ''.$fetch_cart['product_price_curent'].'VNĐ'.', Số lượng:  '. $fetch_cart['cart_quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">Giỏ hàng của bạn đang trống!</p>';
   }
   ?>
   <div class="grand-total"> Tổng cộng : <span><?php echo $grand_total; ?> VNĐ</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>Nhập thông tin yêu cầu</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Họ tên :</span>
            <input type="text" name="name" required placeholder="Nhập họ tên" value="<?php echo $name?>">
         </div>
         <div class="inputBox">
            <span>Số điện thoại :</span>
            <input type="text" name="phone" required placeholder="Nhập số điện thoại" value="<?php echo $phone?>">
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" required placeholder="Nhập email" value="<?php echo $email?>">
         </div>
         <div class="inputBox">
            <span>Phương thức thanh toán :</span>
            <select name="method">
               <option value="cash on delivery">Tiền mặt</option>
               <option value="credit card">Thẻ tín dụng</option>
               <option value="paypal">Paypal</option>
               <option value="paytm">Visa,Master card</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Số nhà :</span>
            <input type="number" min="0" name="flat" required placeholder="Số nhà">
         </div>
         <div class="inputBox">
            <span>Đường, Phố :</span>
            <input type="text" name="street" required placeholder="Phố">
         </div>
         <div class="inputBox">
            <span>Thành phố :</span>
            <input type="text" name="city" required placeholder="Thành phố">
         </div>
         <div class="inputBox">
            <span>Quốc gia :</span>
            <input type="text" name="country" required placeholder="Việt Nam">
         </div>
         <div class="inputBox">
            <span>Mã zip vùng :</span>
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
         </div>
      </div>
      <input type="submit" value="Đặt hàng" class="btn" name="order_btn">
   </form>

</section>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>