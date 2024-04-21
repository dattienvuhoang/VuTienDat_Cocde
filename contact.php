<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){
   $ktra = true;
   if (empty($_POST['name'])) {
      $message[] = 'Vui lòng nhập đầy đủ tên.';
      $ktra = false;
    }
    if (empty($_POST['email'])) {
      $message[] = 'Vui lòng nhập đầy đủ email.';
      $ktra = false;
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $message[] = 'Vui lòng nhập đúng định dạng a@b.c .';
      $ktra = false;
    }
    if (empty($_POST['phone'])) {
      $message[] = 'Vui lòng nhập đầy đủ số điện thoại.';
      $ktra = false;
    }
    if (!preg_match("/^[0-9]{10}$/", $_POST['phone'])) {
      $message[] = 'Vui lòng nhập số điện thoại đúng định dạng.';
      $ktra = false;
    }
    if (empty($_POST['message'])) {
      $message[] = 'Vui lòng nhập tin nhắn của bạn.';
      $ktra = false;
    }
    if ($ktra){
         $name = mysqli_real_escape_string($conn, $_POST['name']);
         $email = mysqli_real_escape_string($conn, $_POST['email']);
         $phone = mysqli_real_escape_string($conn,$_POST['phone']); 
         $msg = mysqli_real_escape_string($conn, $_POST['message']);
   
      $mess_quantity =  mysqli_query($conn, "INSERT INTO `message`(user_id, mess_name, mess_email, mess_number, message) VALUES('$user_id', '$name', '$email', '$phone', '$msg')") or die('query failed');
      $mess_id = mysqli_insert_id($conn);
      if($mess_id){
         $message[] = 'Tin nhắn đã gửi thành công!';
      }else{
         $message[] = 'Tin nhắn gửi không thành công!';
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
   <title>Liên hệ</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Liên hệ với chúng tôi</h3>
   <p> <a href="home.php">Trang chủ</a> / Liên hệ </p>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>Viết gì đó</h3>
      <?php
         $fetch = mysqli_query($conn,"SELECT * FROM `users` WHERE user_id ='$user_id'") ; 
         while ($fetch_mess = mysqli_fetch_assoc($fetch)){ 
      ?>
      <input type="text" name="name" required placeholder="Nhập họ tên" class="box" value = "<?php echo $fetch_mess['user_name']  ?>">
      <input type="email" name="email" required placeholder="Nhập email" class="box" value = "<?php echo $fetch_mess['user_email'] ?>">
      <input type="text" name="phone" required placeholder="Nhập số điện thoại" class="box" value="<?php echo $fetch_mess['user_phone']?>">
      <textarea name="message" class="box" placeholder="Nhập tin nhắn" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Gửi tin nhắn" name="send" class="btn">
   </form>
     <?php }?>
</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>