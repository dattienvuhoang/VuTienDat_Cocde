<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE order_id = '$order_update_id'") or die('query failed');
   $message[] = 'Phương thức thanh toán đã được cập nhật';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE order_id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đơn hàng</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Đơn hàng</h1>

   <div class="box-container">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> ID người dùng : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Thời gian: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Họ tên : <span><?php echo $fetch_orders['order_name']; ?></span> </p>
         <p> Số điện thoại : <span><?php echo $fetch_orders['order_number']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_orders['order_email']; ?></span> </p>
         <p> Địa chỉ : <span><?php echo $fetch_orders['order_address']; ?></span> </p>
         <p> Tổng sản phẩm : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Số tiền : <span><?php echo $fetch_orders['total_price']; ?> VNĐ</span> </p>
         <p> Phương thức thanh toán : <span><?php echo $fetch_orders['order_method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['order_id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">Chưa thanh toán</option>
               <option value="completed">Đã thanh toán</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['order_id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');" class="delete-btn">Xóa</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Chưa có đơn hàng nào</p>';
      }
      ?>
   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>