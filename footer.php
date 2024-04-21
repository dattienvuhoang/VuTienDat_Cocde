<section class="footer">

   <div class="box-container">

      <div class="box">
         <h3>Menu</h3>
         <a href="home.php">Trang chủ</a>
         <a href="about.php">Giới thiệu</a>
         <a href="shop.php">Sản phẩm</a>
         <a href="contact.php">Liên hệ</a>
      </div>

      <div class="box">
         <h3>Liên kết</h3>
         <?php
            if (isset($_SESSION['user_id']))
            {
         ?>
         <a href="home.php">Đăng nhập</a>
         <?php
            }
            else {
         ?>
         <a href="login.php">Đăng nhập</a>
         <?php 
            }
         ?>
         <?php
            if (isset($_SESSION['user_id']))
            {
         ?>
         <a href="home.php">Đăng ký</a>
         <?php
            }
            else {
         ?>
         <a href="register.php">Đăng ký</a>
         <?php 
            }
         ?>
         <a href="cart.php">Giỏ hàng</a>
         <a href="orders.php">Đơn mua</a>
      </div>

      <div class="box">
         <h3>Liên hệ</h3>
         <p> <i class="fas fa-phone"></i>0853833717</p>
         <p> <i class="fas fa-envelope"></i> dattienvuhoang@gmail.com </p>
         <p> <i class="fas fa-map-marker-alt"></i> Hà Nội-000084 </p>
      </div>

      <div class="box">
         <h3>Theo dõi chúng tôi</h3>
         <a href="https://www.facebook.com/vutiendat.sieunhangaoo/"> <i class="fab fa-facebook-f"></i> Facebook </a>
         <a href="#"> <i class="fab fa-twitter"></i> Twitter </a>
         <a href="#"> <i class="fab fa-instagram"></i> Instagram </a>
         <a href="#"> <i class="fab fa-linkedin"></i> Linkedin </a>
      </div>

   </div>
   
   <p class="credit"> &copy; Copyright <?php echo date('d-m-Y'); ?> by <span>H2T Shop</span> </p>
   <p class="credit">  
      <span>
         Vũ Tiến Đạt - 20103100001 - 14/01/2001 <br>
         Nguyễn Tiến Huy Hoàng - 20103100261 - 09/02/2002
      </span> 
   </p>

</section>