<?php

include 'config.php';
$name = $email = $pass = $cpassword = $phone = $address = "" ; 
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $address = $_POST['address'];
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];
   $user_type = "user";

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'Người dùng đã tồn tại ';
   }else{
      if (empty($name) || strlen($name) < 3) {
         $error['name'] = 'Họ tên không được để trống và phải có ít nhất 3 ký tự.';
       }
     
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $error['email'] = 'Địa chỉ email không hợp lệ.';
       }
     
       if (!preg_match('/^0[0-9]{9}$/', $phone)) {
         $error['phone'] = 'Số điện thoại không hợp lệ.';
       }
     
       if (empty($address)) {
         $error['address'] = 'Địa chỉ không được để trống.';
       }
     
       if (strlen($password) < 8) {
         $error['password'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
       }
     
       if (!preg_match('/[A-Z]+[a-z]+[0-9]+/', $password)) {
         $error['password'] = 'Mật khẩu phải bao gồm ít nhất 1 ký tự chữ hoa, 1 ký tự chữ thường và 1 ký tự số.';
       }
     
       if ($password != $cpassword) {
         $error['cpassword'] = 'Xác nhận mật khẩu không trùng khớp với mật khẩu.';
       }
       if (empty($error))
       {
         mysqli_query($conn, "INSERT INTO `users`(user_name, user_email, user_phone, user_address, user_password, user_type) VALUES('$name', '$email', '$phone', '$address', md5('$password') ,'$user_type')") or die('query failed');
         $message[] = 'Đăng Kí Thành Công!';
         //header('location:login.php');
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
   <title>Đăng kí</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'header.php'; ?>


<?php
if (isset($error)){
   foreach($error as $key => $value){
      echo '
      <div class="message">
         <span>'.$value.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Đăng kí ngay</h3>
      <input type="text" name="name" placeholder="Họ tên" required class="box" value="<?=$name?>">
      <input type="email" name="email" placeholder="Email" required class="box" value="<?=$email?>">
      <input type="text" name="phone" placeholder="Số điện thoại" required class="box" value="<?=$phone?>">
      <input type="text" name="address" placeholder="Địa chỉ" required class="box" value="<?=$address?>">
      <input type="password" name="password" placeholder="Mật khẩu" required class="box" >
      <input type="password" name="cpassword" placeholder="Xác nhận mật khẩu" required class="box">
      <input type="submit" name="submit" value="Đăng Kí " class="btn">
      <p>Bạn đã có tài khoản ? <a href="login.php">Đăng Nhập</a></p>
   </form>

</div>
<?php include 'footer.php'; ?>
</body>
</html>