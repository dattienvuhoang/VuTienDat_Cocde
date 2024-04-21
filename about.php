<?php

include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];
// if(!isset($user_id)){
//    header('location:login.php');
// }

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Về chúng tôi</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Về chúng tôi</h3>
   <p> <a href="home.php">Trang chủ</a> / Về chúng tôi </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Chào mừng bạn đến với H2TShop</h3>
         <br>
         <p>
            Khám phá không gian mua sắm thú vị và dễ thương tại H2TShop, 
            nơi bạn sẽ trải nghiệm không gian mua sắm thân thiện và dịch vụ chăm sóc khách hàng tận tâm. 
            Chúng tôi luôn cập nhật những xu hướng mới nhất để đáp ứng nhu cầu thời trang của bạn và giúp bạn tỏa sáng trong mọi bức ảnh.</p>
         <a href="contact.php" class="btn">Liên hệ</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Đánh giá từ khách hàng</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/image1.jpg" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Huyền Trang Trần</h3>
      </div>

      <div class="box">
         <img src="images/image2.jpg" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Phạm Thị Thương</h3>
      </div>

      <div class="box">
         <img src="images/image3.jpg" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Vũ Thị Quỳnh Anh</h3>
      </div>

      <div class="box">
         <img src="images/image4.jpg" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Nguyễn Thu Trang</h3>
      </div>

      <div class="box">
         <img src="images/image5.jpg" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Nguyễn Thị Loan</h3>
      </div>

      <div class="box">
         <img src="images/image6.jpg" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Chu Khánh Linh</h3>
      </div>

   </div>

</section>

<section class="authors">

   <h1 class="title">Thành viên trong nhóm</h1>

   <div class="box-container">

      <div class="box">
         <img src="uploaded_img/TienDat.jpg" alt="">
         <div class="share">
            <a href="https://www.facebook.com/vutiendat.sieunhangaoo/" class="fab fa-facebook-f"></a>
            <a href="" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Vũ Tiến Đạt</h3>
      </div>

      <div class="box">
         <img src="uploaded_img/HuyHoang.jpg" alt="">
         <div class="share">
            <a href="https://www.facebook.com/nthuyhoang092" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Nguyễn Tiến Huy Hoàng</h3>
      </div>



      

   </div>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>