<?php 
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

  // setting to start from first row in db
  $start = 0;

  // setting the number of rows to display in a page
  $rows_per_page = 6;

  // calculating the number of pages
  $records = $con->query("SELECT * FROM `data_testimoni`"); // OOP Style
  $num_of_rows = $records->num_rows; // OOP Style
  $pages = ceil($num_of_rows / $rows_per_page);

  // if the user clicks on the pagination buttons we set a new starting point
  if(isset($_GET["page-nr"])){
    $page = $_GET["page-nr"] - 1;
    $start = $page * $rows_per_page;
  }

  // menentukan page number dimulai dari halaman berapa sampai berapa dan halaman mana yang sedang aktif
  $counter = $start / $rows_per_page + 1;
  $active = $counter;
  if($pages <= 5){
    $counter = 1;
    $limit = $pages;
  }else{
    $limit = $counter + 4;
    if($limit > $pages){
      $counter -= $limit - $pages;
      $limit = $pages; 
    }
  }

  $result = mysqli_query($con, "SELECT * FROM `data_testimoni` ORDER BY `id` DESC LIMIT $start, $rows_per_page"); // Procedural style

  // menutup koneksi
  mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jasa Joki Rank MLBB | KINGKONG</title>
    <link rel="icon" href="./assets/images/Profil.png" />
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <header>
      <nav class="navbar">
        <div class="navbar-left">
          <h1 class="store-name">JOKI BY KINGKONG</h1>
        </div>
        <div class="navbar-right">
          <a href="./index.php" class="nav-home" style="background-color: #4b70f5; transform: scale(1.1)">Home</a>
          <a href="./public/prices.html" class="nav-prices">Prices</a>
          <a href="./public/payment_method.html" class="nav-payment_method">Payment Method</a>
        </div>
      </nav>
    </header>
    <section class="hero">
      <h2>Welcome</h2>
      <p>
        JOKI BY KINGKONG adalah toko jasa joki yang dibuat untuk mendapat penghasilan tambahan. Para pengelola dan penjoki dari toko ini merupakan mahasiswa. Toko ini membantu anda untuk mencapai rank yang anda inginkan dengan harga yang
        terjangkau.
      </p>
      <div class="slideshow-container">
        <div class="mySlides fade">
          <img src="./assets/images/coming soon.jpg" style="width:100%">
        </div>

        <div class="mySlides fade">
          <img src="./assets/images/coming soon.jpg" style="width:100%">
        </div>

        <div class="mySlides fade">
          <img src="./assets/images/coming soon.jpg" style="width:100%">
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
      </div>
      <div style="text-align:center">
        <span class="indicator" onclick="currentSlide(1)"></span>
        <span class="indicator" onclick="currentSlide(2)"></span>
        <span class="indicator" onclick="currentSlide(3)"></span>
      </div>
    </section>
    <section class="testimoni">
      <div class="kirim-testimoni">
        <h2>Testimoni</h2>
        <button onclick="window.location.href='./formulir_testimoni.php'">Kirim Testimoni</button>
      </div>
      <div class="testimoni-container">
        <?php 
          while($row = $result->fetch_assoc()){
        ?>
          <div class="testimonial">
            <p>"<?php echo $row["pesan_testimoni"]; ?>"</p>
            <h4>- <?php echo $row["nickname"]; ?></h4>
          </div>
        <?php 
          } 
        ?>
      </div>
      <div class="page-info">
        Halaman ke-<?php echo $start / $rows_per_page + 1; ?> dari <?php echo $pages ?>
      </div>
      <div class="pagination">
        <a href="?page-nr=1" class="btn">First</a>
        <?php if(isset($_GET["page-nr"]) && $_GET["page-nr"] > 1) : ?>
          <a href="?page-nr=<?php echo $_GET["page-nr"] - 1; ?>" class="btn">< Previous</a>
        <?php endif; ?>
        <?php for($counter; $counter <= $limit; $counter++) : ?>
          <a href="?page-nr=<?php echo $counter; ?>" <?php if($active == $counter){echo "class='active'";} ?>><?php echo $counter; ?></a>
        <?php endfor; ?>  
        <?php if(!isset($_GET["page-nr"])){ ?>
          <?php if($pages > 1) : ?>
            <a href="?page-nr=2">Next</a>
          <?php endif; ?>
        <?php }else{ ?>
          <?php if($_GET["page-nr"] < $pages): ?>
            <a href="?page-nr=<?php echo $_GET["page-nr"] + 1; ?>" class="btn">Next ></a>
          <?php endif; ?>
        <?php } ?>
        <a href="?page-nr=<?php echo $pages; ?>" class="btn">Last</a>
      </div>
    </section>
    <footer>
      <div class="social-media">
        <h2>CONTACT US</h2>
        <a href="https://www.instagram.com/kingkong.joki?igsh=cmZuOTd5NGNzemR5" target="_blank">
          <img src="./assets/images/logo instagram.png" alt="Instagram" />
        </a>
        <a href="https://wa.me/6285277122003" target="_blank">
          <img src="./assets/images/logo whatsapp.png" alt="WhatsApp" />
        </a>
        <a href="mailto:andrelim806@gmail.com" target="_blank">
          <img src="./assets/images/logo email.png" alt="Email" />
        </a>
      </div>
      <div class="footer-links">
        <a href="./public/TOS.html">Terms of Service</a>
        <a href="./public/privacy_policy.html">Privacy Policy</a>
      </div>
      <div class="copyright">
        <p>&copy; 2024 JOKI BY KINGKONG. All Rights Reserved.</p>
      </div>
    </footer>
    <script src="./script.js"></script>
  </body>
</html>
