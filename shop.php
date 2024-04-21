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
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sản phẩm</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Toàn Bộ Sản Phẩm</h3>
</div>

<section class="products">

   <div class="grid__row">
   <div class="grid__column-100">
            <div class="product_new" >  
               <div class="home-product">
                  <div class="grid__row">  
                     <?php
                        if (isset($_GET["Ao"]))
                        {
                           $select_products = mysqli_query($conn, "SELECT * FROM `products` where cat_id = 'A'" ) or die('query failed');
                        }
                        else if (isset($_GET["Quan"]))
                        {
                           $select_products = mysqli_query($conn, "SELECT * FROM `products` where cat_id = 'Q'" ) or die('query failed');
                        }
                        else if (isset($_GET["Vay"]))
                        {
                           $select_products = mysqli_query($conn, "SELECT * FROM `products` where cat_id = 'V'" ) or die('query failed');
                        }
                        else if (isset($_GET["DoBo"]))
                        {
                           $select_products = mysqli_query($conn, "SELECT * FROM `products` where cat_id = 'DB'" ) or die('query failed');
                        }
                        else if (isset($_GET["TuiSach"]))
                        {
                           $select_products = mysqli_query($conn, "SELECT * FROM `products` where cat_id = 'TS'" ) or die('query failed');
                        }
                        else 
                        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                        if(mysqli_num_rows($select_products) > 0){
                           while($fetch_products = mysqli_fetch_assoc($select_products)){
                              $product_link = "product_detail.php?id=".$fetch_products['cat_id']."&type=".$fetch_products['product_id'];
                     ?>
                   <div class="grid__column-2-4" style="border: groove;">
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
                     <?php }} ?>
                  </div>
               </div>
            </div>     
         </div>  
            
   </div>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>