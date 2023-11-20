<?php
require 'function.php';
$sql = "SELECT * FROM matkul";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($query);

$sqlMember = "SELECT * FROM member";
$queryMember = mysqli_query($conn,$sqlMember);
$row = mysqli_fetch_assoc($queryMember);

$sqltugas = "SELECT * FROM detail";
$querytugas = mysqli_query($conn,$sqltugas);
$rowtugas = mysqli_fetch_assoc($querytugas);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Rose:wght@500&family=Signika+Negative:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/ready.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/kelass.css">

    <title>Web kelas PTIK H 22</title>
</head>
<body>

<!-- navbar     navbar      navbar      navbar      navbar      navbar -->
    <nav class="navbar navbar-expand-lg" style="z-index: 2;">
        <div class="container-fluid" id="home">
            <a class="navbar-brand" href="#">PTIK H</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto me-5">
                    <a class="nav-link p-3" href="#welcome">Home</a>
                    <a class="nav-link p-3" href="#beranda">Beranda</a>
                    <a class="nav-link p-3" href="#galeri">Galeri</a>
                    <a class="nav-link p-3" href="registrasi.php">Registrasi</a>
                    <a class="nav-link " href="login.php"><i class="la la-sign-in la-2x"></i></a>
                    <!-- login -->
                </div>
            </div>
        </div>
    </nav>
<!-- navbar     navbar      navbar      navbar      navbar      navbar -->

<!-- home   home    home    home    home    home    home    home    home -->
    <div id="welcome" class="hero">
        <center>
            <div class="container begrond">
                <div class="home">
                    <h2 class="hai">Hai... <span class="h3">Selamat Datang</span></h2>
                    <div class="">
                        <p>Selamat datang di website sistem informasi kelas kami, PTIK H angkatan 2022. <br>
                        Mari berkenalan lebih jauh dengan kelas PTIK H, anda dapat berkenalan <br> 
                        dengan para penghuni kelas ini.
                        </p>
                    </div> 
                    <a href="#infotugas" class="btn">Lihat Info Tugas</a>
                </div>
            </div>
        </center>
    </div>
<!-- home   home    home    home    home    home    home    home    home -->

<!-- bernda      bernda      bernda      bernda      bernda      bernda -->
    <div id="beranda" class="container beranda">
        <div class="row justify-content-between">
            <div class="col-8">
<!-- tentang      tentang     tentang     tentang     tentang     tentang -->
                <div class="tentang" style="z-index: 1;">
                    <h5>Tentang Kami</h5>
                    <p style="font-size: 15px;">PTIK H adalah salah satu kelas dalam Program Studi Pendidikan Teknik Informatika dan Komputer, Jurusan Teknik Informatika dan Komputer, Fakultas Teknik, Universitas Negeri Makassar (UNM). Kami adalah kelas PTIK H angkatan 2022. Member dari PTIK H terdiri dari sekumpulan mahasiswa yang lulus dan diterima berkuliah di Universitas Negeri Makassar melalui jalur seleksi SBMPTN tahun 2022 atau merupakan jalur jantan kata orang. </p>
                </div>
<!-- member      member      member      member     member      member -->
                <div class="member">
                    <h5>Member</h5>
                    <div class="container-fluid swiper" style="z-index: 1;">
                        <div class="slide-container">
                            <div class="card-wrapper swiper-wrapper">
								
                            <?php foreach( $queryMember as $row) : ?>
                                <div class="card1 swiper-slide " style="width: 150px; border: 0px;" >
                                    <center>
                                        <img  src="fotomember/<?php echo $row["foto"]; ?>" class="card-img">
                                        <div class="card-body">
                                            <a href="<?= $row['linkIG']; ?>" target="_blank" ><i class="fa-brands fa-instagram fa-xl mb-3" style="color: #ffffff;"></i></a>
                                            <h5 style="font-size: 15px;"><?= $row['nama']; ?></h5>
                                        </div>
                                    </center>
                                </div>
                            <?php endforeach ; ?>

                            </div>
                        </div>
                        <div class="tombolControlMember">
                            <center>
                                <i class="la la-arrow-circle-left la-2x swiperprev mx-2" style="color: red;"></i>
                                <!-- <button class="btn btn-warning">Lihat Semua</button> -->
                                <i class="la la-arrow-circle-right la-2x swipernext mx-2" style="color: red;"></i>
                            </center>   
                        </div>
                    </div>
                </div>
<!-- info tugas     info tugas      info tugas      info tugas      info tugas -->


                <div id="infotugas" class="detail">
                    <h5 class="mb-3">Tugas</h5>
                    <div id="carouselExampleIndicators" class="carousel slide kotakDetail" >
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" style="width: 30px; left:10px;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" style="width: 30px; right:12px;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <div class="carousel-inner" style="margin-inline: 20px;">
                            <?php $index = 0; ?>
                            <?php foreach ($querytugas as $key) { ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <h6 style="font-size: 15px;">Detail Tugas:</h6>
                                    <p><?= $key['tugas'] ?></p><br>
                                    <div class="d-flex">
                                        <div class="col-6">
                                            <h6 style="font-size: 15px;">Mata Kuliah:</h6>
                                            <p><?= $key['matkul'] ?></p>
                                        </div>
                                        <div class="col-6">                                        
                                            <h6 style="font-size: 15px;">Jenis Penugasan:</h6>
                                            <p><?= $key['jenis'] ?></p>
                                        </div>
                                    </div><br>
                                    <div class="d-flex">
                                        <div class="col-6">
                                            <h6 style="font-size: 15px;">Deadline:</h6>
                                            <p><?= $key['deadline'] ?></p>
                                        </div>
                                        <div class="col-6">
                                            <h6 style="font-size: 15px;">Pengumpulan:</h6>
                                            <p><?= $key['pengumpulan'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php $index++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
<!-- sosmed     sosmed      sosmed      sosmed      sosmed      sosmed -->
            <div class="col-4">
                <div class="sosmed">
                    <h5>Ayo terhubung dengan kami</h5>
                    <div class="akun">                    
                        <div class="card-body body1">
                            <a href="https://www.instagram.com/ptikh_22/?utm_source=ig_web_button_share_sheet&igshid=OGQ5ZDc2ODk2ZA==" target="_blank">
                                <i class="fa-brands fa-instagram fa-2xl" style="color: #ffffff;"></i>
                            </a>
                            <h6><a href="http://www.instagram.com/ptikh_22/?utm_source=ig_web_button_share_sheet&igshid=OGQ5ZDc2ODk2ZA==" target="_blank">Instagram</a></h6>
                        </div>
                        <div class="card-body body2">
                            <a href="https://drive.google.com/drive/folders/1Y1LZiUDTV0oh0lX-RN5Xt9TflNK-XCqv" target="_blank">
                                <i class="fa-brands fa-google-drive fa-2xl" style="color: #ffffff;"></i>
                            </a>
                            <h6><a href="https://drive.google.com/drive/folders/1Y1LZiUDTV0oh0lX-RN5Xt9TflNK-XCqv" target="_blank">G-Drive</a></h6>
                        </div>                    
                    </div>
                </div>
<!-- matkul     matkul      matkul      matkul      matkul      matkul -->
                <div  class="matkul">
                    <h5>Mata Kuliah</h5> 
                    <?php foreach($query as $row) :?>
                        <div class="listing">                  
                            <li class="listmat">
                                <h6><?= $row["namaMatkul"]; ?></h6>
                                <p><?= $row["dosen"]; ?></p>
                            </li>  
                        </div>
                    <?php endforeach; ?>
                </div>
                
            </div>
        </div>
    </div>
<!-- bernda      bernda      bernda      bernda      bernda      bernda -->

<!-- galeri      galeri      galeri      galeri      galeri      galeri -->
    <div class="container galeri">
        <h4 id="galeri" style="text-align: center;">Galeri</h4>
        <div class="row">
            <div class="col-12">
                <img src="img/img4.JPG" class="gambar1">
                <img src="img/img8.jpg" class="gambar2">
                <img src="img/img13.jpg" class="gambar2">
                <img src="img/img17.jpg" class="gambar2">
                <img src="img/img1.JPG" class="gambar1">
                <img src="img/img7.jpg" class="gambar2">

            </div>
        </div>
    </div>
<!-- galeri      galeri      galeri      galeri      galeri      galeri -->

<!-- footer      footer      footer      footer      footer      footer  -->
    <div class="container-fluid footer align-items-center">
        <div class="kelompok">
            <p>
                <span>
                    <i class="fa-brands fa-connectdevelop fa-lg" style="color: #ffffff;"></i>
                </span> Kelompok 1 | Pemrograman Web | PTIK H 2022 </p>
        </div>
        <div class="developer">
            <p><span><i class="fa-solid fa-phone fa-sm" style="color: #ffffff;"></i></span> +62334227110
            <br><span><i class="fa-solid fa-envelope fa-sm" style="color: #ffffff;"></i></span>  fadhelakbarsallang@gmail.com</p>
            <!-- <p>fadhelakbarsallang@gmail.com</p> -->
        </div>
    </div>
<!-- footer      footer      footer      footer      footer      footer  -->

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/1b57e65a2d.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.js"></script>
    <!-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> -->
    <!-- <script type="text/javascript" src="js/kelas.js"></script> -->
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/kelas.js"></script>
    
</body>
</html>