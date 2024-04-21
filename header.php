<?php
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
?>

<header class="header">

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo"><b>H2TSHOP</b></a>

         <nav class="navbar">
            <a href="home.php">Trang chủ</a>
            <a href="about.php">Giới thiệu</a>
            <a href="shop.php">Sản phẩm</a>
            <a href="orders.php">Đặt hàng</a>
            <a href="contact.php">Liên hệ</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               if (isset($_SESSION['user_id']))
               {
                  $user_id = $_SESSION['user_id'];
                  $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                  $cart_rows_number = mysqli_num_rows($select_cart_number); 
               }
               else $cart_rows_number = 0 ; 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p align="left">Họ Tên  : <span>
               <?php
                  if(isset($_SESSION['user_name'])) 
                      echo $_SESSION['user_name'];
                  else {
                     echo " " ; 
                  } 
               ?></span></p>
            <p align="left">Email : <span>
               <?php 
                  if(isset($_SESSION['user_email'])) 
                  echo $_SESSION['user_email'];
                  else {
                     echo " " ; 
           } 
               ?>
               </span></p>
                  <a href="logout.php" class="delete-btn">
                     <?php
                        if (isset($_SESSION["user_id"]))
                        {
                           echo "Đăng Xuất" ; 
                        } 
                        else 
                           {
                              echo "Đăng Nhập" ;
                           }     
                     ?>
                  </a>
         </div>
      </div>
   </div>

</header>