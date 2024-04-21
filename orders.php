<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đơn hàng</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Đơn hàng của bạn</h3>
   <p> <a href="home.php">Trang chủ</a> / Đơn hàng </p>
</div>

<section class="placed-orders">

   <h1 class="title">Đơn đặt</h1>

   <div class="box-container" style="display : block">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> Thời gian: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Tên : <span><?php echo $fetch_orders['order_name']; ?></span> </p>
         <p> Số Điện Thoại : <span><?php echo $fetch_orders['order_number']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_orders['order_email']; ?></span> </p>
         <p> Địa chỉ : <span><?php echo $fetch_orders['order_address']; ?></span> </p>
         <p> Phương thức thanh toán : <span><?php echo $fetch_orders['order_method']; ?></span> </p>
         <p> Đơn hàng của bạn :<span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Tổng cộng : <span><?php echo $fetch_orders['total_price']; ?> VNĐ</span> </p>
         <p> Trạng thái: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">Chưa có đơn hàng nào!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>