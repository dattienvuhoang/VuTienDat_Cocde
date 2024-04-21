<?php

include 'config.php';
$search_item = "" ;
session_start();
if (isset($_SESSION['search']))
$search_item = $_SESSION["search"];

if(isset($_POST['add_to_cart'])){
   $user_id = $_SESSION['user_id'];
   if(!isset($user_id)){
      header('location:login.php');
   }
   else {
      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_image = $_POST['product_image'];
      $product_quantity = $_POST['product_quantity'];
   
      $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE cart_name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   
      if(mysqli_num_rows($check_cart_numbers) > 0){
         $message[] = 'Đã được thêm vào giỏ hàng!';
      }else{
         mysqli_query($conn, "INSERT INTO `cart`(user_id, cart_name, cart_price, cart_quantity, cart_image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
         $message[] = 'Sản phẩm đã được thêm vào giỏ hàng!';
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
   <title>Tìm kiếm</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Tìm kiếm</h3>
   <p> <a href="home.php">Trang chủ</a> / Tìm kiếm </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Nhập tên sản phẩm bạn cần tìm" class="box" value="<?php echo $search_item?>">
      <input type="submit" name="submit" value="Tìm kiếm" class="btn">
   </form>
</section>

<section class="products">
   <div class="grid__row">
   <div class="grid__column-100" >
            <div class="product_new" style="border: groove;"> 
               <div class="home-product">
                  <div class="grid__row">  
                  <?php
                     
                     if(isset($_POST['submit'])){
                        
                        $search_item = $_POST['search'];
                        $_SESSION["search"] = $search_item ;
                        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE product_name LIKE '%{$search_item}%'") or die('query failed');
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
                                       <input class="form-control text-center me-3" name ="product_quantity" type="number" value="1" min="1" max = "<?php echo $fetch_products['product_quantity']?>" style="max-width: 5rem;max-height: 3.5rem;"  />
                                       <input type="hidden" name="product_name" value="<?php echo $fetch_products["product_name"]?>">
                                       <input type="hidden" name="product_price_curent" value="<?php echo $fetch_products["product_price_curent"]?>" >
                                    </div>
                              </form>
                           </div>
                     </div>
                     
                  
                  </div>
               </div>
            </div>     
         </div>  
            
   </div>
                         <?php
                                 }
                              }else{
                                 echo '<p class="empty" style = "margin-left: 40%;">Không có kết quả phù hợp</p>';
                              }
                           }else{
                              echo '<p class="empty" style = "margin-left: 40%;">Trống!</p>';
                           }
                        ?>
</section>  



<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>