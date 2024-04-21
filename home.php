<?php

include 'config.php';

session_start();

if (isset($_POST['add_to_cart'])) {
   $user_id = $_SESSION['user_id'];
   $product_id = $_POST['product_id'];
   $product_quantity = $_POST['product_quantity'];

   if (isset($_SESSION['user_id'])) {
       // Kiểm tra số lượng hàng trong giỏ hàng và sản phẩm
       $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'");
       $check_product_quantity = mysqli_query($conn, "SELECT * FROM `products` WHERE product_id = '$product_id'");
       
       $cart_row = mysqli_fetch_assoc($check_cart_numbers);
       $product_row = mysqli_fetch_assoc($check_product_quantity);

       if ($cart_row && $product_row) {
           if ($product_quantity > $product_row['product_quantity']) {
               $message[] = 'Số lượng hàng trong kho không đủ!';
           } else {
               // Cập nhật giỏ hàng
               $new_cart_quantity = $cart_row['cart_quantity'] + $product_quantity;
               $update_cart = "UPDATE `cart` SET `cart_quantity`='$new_cart_quantity' WHERE product_id = '$product_id' AND user_id = '$user_id'";
               mysqli_query($conn, $update_cart);

               // Cập nhật số lượng sản phẩm
               $new_product_quantity = $product_row['product_quantity'] - $product_quantity;
               $update_product = "UPDATE `products` SET `product_quantity`='$new_product_quantity' WHERE product_id = '$product_id'";
               mysqli_query($conn, $update_product);

               $message[] = 'Đã cập nhật vào giỏ hàng!';
           }
       } else {
           // Thêm mới vào giỏ hàng
           mysqli_query($conn, "INSERT INTO `cart`(product_id, user_id, cart_quantity) VALUES('$product_id', '$user_id', '$product_quantity')");

           // Cập nhật số lượng sản phẩm
           $new_product_quantity = $product_row['product_quantity'] - $product_quantity;
           $update_product = "UPDATE `products` SET `product_quantity`='$new_product_quantity' WHERE product_id = '$product_id'";
           mysqli_query($conn, $update_product);

           $message[] = 'Thêm vào giỏ hàng thành công!';
       }
   } else {
       header("location:login.php");
   }
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
   <title>H2TSHOP</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Mang thời trang đến tận tay của bạn</h3>
      <a href="about.php" class="white-btn">Khám phá thêm</a>
   </div>

</section>

<section class="app-products" style = " scroll-behavior: smooth; ">

   

   <nav class="catagory">
      <div class="grid__row">
         <div class="grid__column-2">
         <h3 class="catagory__heading">
            <i class="fa-solid fa-list catagory__heading-icon" ></i> 
            Danh mục
            </h3>
            <ul class="catagory-list">
              <!-- <li class="catagory-item catagory-item--active" >
                  <a href="#" class="catagory-item__link">Thời trang nữ</a>
               </li> -->
               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="hidden" value="Áo" name="Ao" >
                  <button name="product" class="btn catagory-item__link">Áo</button>
                  </form>
               </li>
               
               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="hidden" value="Quần" name="Quan" >
                  <button name="product" class="btn catagory-item__link">Quần</button>
                  </form>
               </li>
               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="hidden" value="Váy" name="Vay" >
                  <button name="product" class="btn catagory-item__link">Váy / Đầm</button>
                  </form>
               </li>
               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="hidden" value="Túi sách" name="TuiSach" >
                  <button name="product" class="btn catagory-item__link">Túi sách</button>
                  </form>
               </li>
               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="hidden" value="Đồ bộ" name="DoBo" >
                  <button name="product" class="btn catagory-item__link">Đồ bộ</button>
                  </form>
               </li>
               <!-- <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="submit" value="Quần" name="Quan" class="catagory-item__link">
                  </form>
               </li>

               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="submit" value="Váy" name="Vay" class="catagory-item__link">
                  </form>
               </li>

               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="submit" value="Túi sách" name="TuiSach" class="catagory-item__link">
                  </form>
               </li>

               <li class="catagory-item">
                  <form method="get" action = "shop.php">
                  <input type="submit" value="Đồ bộ" name="DoBo" class="catagory-item__link">
                  </form>
               </li> -->
               
            </ul>
         </div> 
         <script>
               function scrollToSection(sectionId) {
                  const targetElement = document.getElementById(sectionId);
        
                     if (targetElement) {
                           targetElement.scrollIntoView({ behavior: 'smooth' });
                           targetElement.focus();
                     }
               }
         </script>   
         <div class="grid__column-10">
            <div class="home-filter">
               <span class="home-filter__label">Hiển thị theo</span>
               <button class="home-filter__btn btn filter" onclick="scrollToSection('common')">Phổ biến</button>
               <button class="home-filter__btn btn filter btn-home" onclick="scrollToSection('new')">Mới nhất</button>
               <button class="home-filter__btn btn filter " onclick="scrollToSection('sale')">Bán chạy</button>
            </div>
            <div id="product_new"> 
               <h1 class="title" id = "new">Sản Phẩm Mới Ra Mắt</h1>
               <div class="home-product">
                  <div class="grid__row">  
                     <?php
                        $sql = "SELECT * FROM products WHERE product_date BETWEEN ( DATE_SUB(NOW(), INTERVAL 10 DAY)) AND NOW() AND product_quantity > 0 ";
                        $select_products = mysqli_query($conn, $sql) or die('query failed');
                        if(mysqli_num_rows($select_products) > 0){
                           while($fetch_products = mysqli_fetch_assoc($select_products)){
                              $product_link = "product_detail.php?id=".$fetch_products['cat_id']."&type=".$fetch_products['product_id'];
                     ?>
                     <div class="grid__column-2-4">
                           <div class="home-product-item">
                              <form method="post">
                                    <a href="<?php echo $product_link?>"> 
                                          <div class="home-product-item__img" style = "background-image: url(images/Quan/<?php echo $fetch_products["product_image"]?>);"></div>
                                          <h4 class="home-product-item__name"><?php echo $fetch_products["product_name"]?></h4>
                                    </a>
                                    <div class="home-product-item__price">
                                       <span class="price-old"><?php echo $fetch_products["product_price_old"]?>đ</span>
                                       <span class="price-current"><?php echo $fetch_products["product_price_curent"]?>đ</span>
                                    </div>
                                    <div class="btn-add"  style="display: inline-flex;">
                                      
                                       <button class="btn" name="add_to_cart" style="margin-top : 0rem ;padding : 1rem "> Thêm vào giỏ</button>
                                       <input type="hidden" name="product_id" value="<?php echo $fetch_products["product_id"]?>">
                                       <input class="form-control text-center me-3" name="product_quantity" type="number" value="1" min="1" max = "<?php echo $fetch_products['product_quantity']?>" style="max-width: 5rem;max-height: 3.5rem;"  />
                                       <input type="hidden" name="product_name" value="<?php echo $fetch_products["product_name"]?>">
                                       <input type="hidden" name="product_price_curent" value="<?php echo $fetch_products["product_price_curent"]?>" >
                                    </div>
                              </form>
                           </div>
                     </div>
                     <?php }} ?>
                  </div>
               </div>
            </div>      
            <div id="product_common"> 
               <h1 class="title" id = "common">Sản Phẩm Mới Phổ Biến</h1>
               <div class="home-product">
                  <div class="grid__row">  
                     <?php
                        $sql = "SELECT * FROM products WHERE product_quantity >= 20";
                        $select_products = mysqli_query($conn, $sql) or die('query failed');
                        if(mysqli_num_rows($select_products) > 0){
                           while($fetch_products = mysqli_fetch_assoc($select_products)){
                              $product_link = "product_detail.php?id=".$fetch_products['cat_id']."&type=".$fetch_products['product_id'];
                     ?>
                     <div class="grid__column-2-4">
                           <div class="home-product-item">
                              <form method="post">
                                    <a href="<?php echo $product_link?>"> 
                                          <div class="home-product-item__img" style = "background-image: url(images/Quan/<?php echo $fetch_products["product_image"]?>);"></div>
                                          <h4 class="home-product-item__name"><?php echo $fetch_products["product_name"]?></h4>
                                    </a>
                                    <div class="home-product-item__price">
                                       <span class="price-old"><?php echo $fetch_products["product_price_old"]?>đ</span>
                                       <span class="price-current"><?php echo $fetch_products["product_price_curent"]?>đ</span>
                                    </div>
                                    <div class="btn-add"  style="display: inline-flex;">
                                      
                                       <button class="btn" name="add_to_cart" style="margin-top : 0rem ;padding : 1rem "> Thêm vào giỏ</button>
                                       <input type="hidden" name="product_id" value="<?php echo $fetch_products["product_id"]?>">
                                       <input class="form-control text-center me-3" name="product_quantity" type="number" value="1" min="1" max = "<?php echo $fetch_products['product_quantity']?>" style="max-width: 5rem;max-height: 3.5rem;"  />
                                       <input type="hidden" name="product_name" value="<?php echo $fetch_products["product_name"]?>">
                                       <input type="hidden" name="product_price_curent" value="<?php echo $fetch_products["product_price_curent"]?>" >
                                    </div>
                              </form>
                           </div>
                     </div>
                     <?php }} ?>
                  </div>
               </div>
            </div>
            <div name="product_sale"> 
               <h1 class="title" id = "sale">Sản Phẩm Mới Bán Chạy</h1>
               <div class="home-product">
                  <div class="grid__row">  
                     <?php
                        $sql = "SELECT * FROM products WHERE product_quantity <=5 AND product_quantity >0";
                        $select_products = mysqli_query($conn, $sql) or die('query failed');
                        if(mysqli_num_rows($select_products) > 0){
                           while($fetch_products = mysqli_fetch_assoc($select_products)){
                              $product_link = "product_detail.php?id=".$fetch_products['cat_id']."&type=".$fetch_products['product_id'];
                     ?>
                    <div class="grid__column-2-4">
                           <div class="home-product-item">
                              <form method="post">
                                    <a href="<?php echo $product_link?>"> 
                                          <div class="home-product-item__img" style = "background-image: url(images/Quan/<?php echo $fetch_products["product_image"]?>);"></div>
                                          <h4 class="home-product-item__name"><?php echo $fetch_products["product_name"]?></h4>
                                    </a>
                                    <div class="home-product-item__price">
                                       <span class="price-old"><?php echo $fetch_products["product_price_old"]?>đ</span>
                                       <span class="price-current"><?php echo $fetch_products["product_price_curent"]?>đ</span>
                                    </div>
                                    <div class="btn-add"  style="display: inline-flex;">
                                      
                                       <button class="btn" name="add_to_cart" style="margin-top : 0rem ;padding : 1rem "> Thêm vào giỏ</button>
                                       <input type="hidden" name="product_id" value="<?php echo $fetch_products["product_id"]?>">
                                       <input class="form-control text-center me-3" name="product_quantity" type="number" value="1" min="1" max = "<?php echo $fetch_products['product_quantity']?>" style="max-width: 5rem;max-height: 3.5rem;"  />
                                       <input type="hidden" name="product_name" value="<?php echo $fetch_products["product_name"]?>">
                                       <input type="hidden" name="product_price_curent" value="<?php echo $fetch_products["product_price_curent"]?>" >
                                    </div>
                              </form>
                           </div>
                     </div>
                     <?php }}
                     else {
                        echo "Không có sản phẩm nào!" ;
                     }
                      ?>
                  </div>
               </div>
            </div>
            
               <div class="load-more" style="margin-top: 2rem; text-align:center">
                  <a href="shop.php" class="option-btn">Xem thêm</a>
               </div>
         </div>  
      </div>
   </nav>

   

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Tại sao lại chọn H2TSHOP ?</h3>
         <p>Với sự đa dạng về kiểu dáng, màu sắc và chất liệu, 
            H2TShop cam kết mang đến cho bạn những bộ trang phục vô cùng phong cách, 
            từ những bộ đầm thanh lịch đến những bộ trang phục hàng ngày mang đậm chất cá nhân. 
            Chúng tôi không chỉ chú trọng vào xu hướng thời trang mới nhất mà còn tập trung vào chất lượng sản phẩm, 
            giúp bạn tự tin và thoải mái suốt cả ngày dài..</p>
         <a href="about.php" class="btn">Xem thêm</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Bạn còn thắc mắc điều gì ?</h3>
      <p>Trao đổi với chúng tôi tại đây</p>
      <a href="contact.php" class="white-btn">Liên hệ</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>