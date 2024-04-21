<?php

include 'config.php';

session_start();
$product_link = $_GET["id"] ; 
$image = $_GET['type'];
$link = $product_link.$image.".jpg";
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

<section class="py-5">
    <?php 
         $sql = "Select * from products where product_id = ".$image ;
         $select_product = mysqli_query($conn,$sql) or die("Lấy dữ liệu thất bại");
         $product = mysqli_fetch_assoc($select_product);
    ?>
                <form method ="post">
                <div class="container_product px-4 px-lg-5 my-5">
                    <div class="row gx-4 gx-lg-5 align-items-center">
                        <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="images/Quan/<?php echo $link ?>" alt="..." /></div>
                        <div class="col-md-6" style="padding-left: 14px;">
                            <h1 class="display-5 fw-bolder"><?php echo $product['product_name']?></h1>
                            <div class="fs-5 mb-5">
                                <span class="text-decoration-line-through" style="font-size: 2rem"><?php echo $product['product_price_old']?>đ</span>
                                <span style="font-size: 3rem; color : red"><?php echo $product['product_price_curent']?>đ</span>
                            </div>
                            <p class="lead"><?php echo $product['product_detail']?></p>
                            <div class="d-flex">
                                <input type="hidden" name="product_id" value="<?php echo $product["product_id"]?>">
                                <input class="form-control text-center me-3" name="product_quantity" type="number" value="1"  min="1" max = "<?php echo $product['product_quantity']?>" style="max-width: 5rem;max-height: 3.5rem; max-width: 5rem ; margin-top: 1rem;" />
                                <button class="btn" name="add_to_cart">
                                    <i class="bi-cart-fill me-1"></i>
                                    Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>