<?php 
if(isset($_POST["submit"])){
  // detail database
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "kingkong_joki";

  // connect ke mysql
  $con = mysqli_connect($host, $username, $password, $dbname);

  // kondisi jika koneksi ke mysql tidak berhasil
  if (!$con){
    die("Connection failed!" . mysqli_connect_error());
  }

  $nickname = $_POST["nickname"];
  $testimoni = $_POST["testimoni"];

  // penyaringan data
  if($nickname === ""){
    $error_message = "Nickname tidak boleh kosong";
  }else if($testimoni === ""){
    $error_message = "Testimoni tidak boleh kosong";
  }else if(mysqli_num_rows(mysqli_query($con, "SELECT `nickname` FROM `data_testimoni` WHERE `nickname` = '$nickname'")) > 0){
    $error_message = "Nickname tidak tersedia";
  }else{
    // mengirim data ke database
    $query = "INSERT INTO `data_testimoni` (`nickname`, `pesan_testimoni`) VALUES ('$nickname', '$testimoni')";

    $success = mysqli_query($con, $query);
    if($success){
      $success_message = "Data Berhasil Dikirim";
    }
  }

  // menutup koneksi
  mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Testimoni</title>
    <link rel="stylesheet" href="./style.css" />
    <link rel="icon" href="./assets/images/Profil.png" />
    <style>
      p{
        padding: 8px;
        font-size: 16px;
        margin: auto;
        margin-top: 20px;        
        width: fit-content;
      }
      .error{
        background-color: rgba(255, 192, 203, 0.7);
        border: 1px solid red;
      }
      .success{
        background-color: rgba(144, 238, 144, 0.5);
        border: 1px solid green;
      }
    </style>
  </head>
  <body>
    <?php if(isset($error_message)): ?>
      <p class="error"><?php echo $error_message ?></p>
    <?php endif; ?>
    <?php if(isset($success_message)): ?>
      <p class="success"><?php echo $success_message; ?></p>
    <?php endif;  ?>
    <form action="" method="post">
      <h1>Testimoni</h1>
      <input type="text" name="nickname" placeholder="Nickname" />
      <textarea name="testimoni" placeholder="Testimoni"></textarea>
      <button type="submit" name="submit">Submit</button>
    </form>
  </body>
</html>
