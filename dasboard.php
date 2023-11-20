<?php
session_start();

require 'function.php';

if ( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM matkul";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($query);

//	TAMBAH MATKUL		TAMBAH MATKUL		TAMBAH MATKUL		TAMBAH MATKUL
	if (isset($_GET['tambahMatkul'])) {
		$tambahNamaMatkul = $_POST['tambahNamaMatkul'];
		$tambahNamaDosen = $_POST['tambahNamaDosen'];
		
		//query insert ke database	
		$sql = "INSERT INTO matkul (namaMatkul, dosen) VALUES ('$tambahNamaMatkul', '$tambahNamaDosen')";
		if ($conn->query($sql) === TRUE) {
			header('Location: dasboard.php');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

//	EDIT MATKUL		EDIT MATKUL		EDIT MATKUL		EDIT MATKUL
	if (isset($_GET['editMatkul'])) {
		$tampilEdit = mysqli_query($conn, "SELECT * FROM matkul WHERE id = '$_GET[id]' ");
		$data = mysqli_fetch_assoc($tampilEdit);
		if($tampilEdit){
			$namaMataKuliah = $data['namaMatkul'];
			$namaDosenEdit = $data['dosen'];
			$idEditMatkul = $data['id'];
			
		}
	}
	if (isset($_POST['simpatEditMatkul'])) {
		$editNamaMatkul = $_POST['namaMataKuliah'];
		$edithNamaDosen = $_POST['namaDosenEdit'];
		$idEditMatkul = $_POST['idEditDosen'];
		
		$queryEdit = "UPDATE matkul SET 
		namaMatkul = '$editNamaMatkul',
		dosen = '$edithNamaDosen'
		WHERE id = '$idEditMatkul'
		";
		mysqli_query($conn, $queryEdit);

		if ($conn->query($queryEdit) === TRUE) {
			header('Location: dasboard.php');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

//	HAPUS MATKUL		HAPUS MATKUL		HAPUS MATKUL		HAPUS MATKUL
	if(isset($_GET['hapusMatkul'])){
		$idHapusMatkul = $_GET['idHapusMatkul'];

		$queryHapusMatkul = "DELETE FROM matkul WHERE id = $idHapusMatkul";
		mysqli_query($conn, $queryHapusMatkul);

		if ($conn->query($queryHapusMatkul) === TRUE) {
			header('Location: dasboard.php');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

// 	TAMBAH MEMBER	TAMBAH MEMBER		TAMBAH MEMBER		TAMBAH MEMBER
	if (isset($_POST['tambahMemberBaru'])) {
		global $conn;
		$tambahMemberNamPang = htmlspecialchars($_POST["tambahMemberNamPang"]);
		$tambahMemberLIG = htmlspecialchars($_POST["tambahMemberLIG"]);

		// Upload foto
		$tambahMemberFoto = upload();
		if (!$tambahMemberFoto) {
			return false;
		}

		$query = "INSERT INTO member VALUES (
			'', '$tambahMemberNamPang', '$tambahMemberLIG', '$tambahMemberFoto'
		)";

		if ($conn->query($query) === TRUE) {
			header('Location: dasboard.php');
			exit();
		} else {
			echo "Error: " . $query . "<br>" . $conn->error;
		}

		return mysqli_affected_rows($conn);
	}

//	UPLOAD FOTO		UPLOAD FOTO		UPLOAD FOTO		UPLOAD FOTO		UPLOAD FOTO
	function upload() {
		$namaFIle = $_FILES['tambahMemberFoto']['name'];
		$ukuranFIle = $_FILES['tambahMemberFoto']['size'];
		$error = $_FILES['tambahMemberFoto']['error'];
		$tmpName = $_FILES['tambahMemberFoto']['tmp_name'];

		// Cek ada tidaknya gambar yang diupload
		if ($error === 4) {
			echo "<script>
				alert('Pilih gambar terlebih dahulu');
			</script>";
			return false;
		}

		// Cek ekstensi file yang diupload, hanya boleh gambar
		$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
		$ekstensiGambar = explode('.', $namaFIle);
		$ekstensiGambar = strtolower(end($ekstensiGambar));
		if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
			echo "<script>
				alert('Yang Anda upload bukan gambar');
			</script>";
			return false;
		}

		// Cek ukuran foto yang diupload
		if ($ukuranFIle > 5000000) {
			echo "<script>
				alert('Ukuran gambar terlalu besar');
			</script>";
			return false;
		}

		// Lolos pengecekan/ gambar siap diupload
		// Generate nama file baru sebelum upload ke database
		$namaFileBaru = uniqid();
		$namaFileBaru .= '.';
		$namaFileBaru .= $ekstensiGambar;

		move_uploaded_file($tmpName, 'fotomember/' . $namaFileBaru);

		return $namaFileBaru;
	}


$sql = "SELECT * FROM member";
$queryMember = mysqli_query($conn,$sql);
$rowMember = mysqli_fetch_assoc($queryMember);

//	HAPUS MEMBER 	HAPUS MEMBER		HAPUS MEMBER		HAPUS MEMBER
	if(isset($_GET['hapusMember'])){
		$idHapusMember = $_GET['idHapusMember'];

		$queryHapusMember = "DELETE FROM member WHERE id = $idHapusMember";
		mysqli_query($conn, $queryHapusMember);

		if ($conn->query($queryHapusMember) === TRUE) {
			header('Location: dasboard.php');
		} else {
			echo "Error: " . $queryHapusMember . "<br>" . $conn->error;
		}
	}

//	UPLOAD FOTO EDIT		UPLOAD FOTO EDIT		UPLOAD FOTO EDIT		UPLOAD FOTO EDIT
	function uploadl() {
		$namaFile = $_FILES['fotoMemberEdit']['name'];
		$ukuranFile = $_FILES['fotoMemberEdit']['size'];
		$error = $_FILES['fotoMemberEdit']['error'];
		$tmpName = $_FILES['fotoMemberEdit']['tmp_name'];

		// Cek apakah ada file yang diupload
		if ($error === 4) {
			return null; // Tidak ada file yang diupload
		}

		// Pindahkan file yang diupload ke folder tujuan
		move_uploaded_file($tmpName, 'fotomember/' . $namaFile);

		return $namaFile;
	}

// 	EDIT MEMBER		EDIT MEMBER		EDIT MEMBER		EDIT MEMBER		EDIT MEMBER
	if (isset($_GET['idEditMember'])) {
		$tampilEditMember = mysqli_query($conn, "SELECT * FROM member WHERE id = '$_GET[idEditMember]' ");
		$data = mysqli_fetch_assoc($tampilEditMember);
		if ($tampilEditMember) {
			$namaMemberEdit = $data['nama'];
			$linkMemberEdit = $data['linkIG'];
			$idPilihMember = $data['id'];
			$editMemberFoto = $data['foto'];
		}
	}

// 	SIMPAN EDIT MEMBER		SIMPAN EDIT MEMBER		SIMPAN EDIT MEMBER		SIMPAN EDIT MEMBER
	if (isset($_POST['simpanEditMember'])) {
		$editNamaMember = $_POST['namaMemberEdit'];
		$editLinkMember = $_POST['linkMemberEdit'];
		$editFotoMemberLama = $_POST['fotoMemberLama'];
		$idSimpanEditMember = $_POST['idPilihMember'];

		// Cek apakah ada file foto yang diupload
		if ($_FILES['fotoMemberEdit']['error'] === 4) {
			// Tidak ada file yang diupload, gunakan foto yang sudah ada
			$editFotoMemberBaru = $editFotoMemberLama;
		} else {
			// Ada file yang diupload, gunakan foto baru
			$editFotoMemberBaru = uploadl();

			// Hapus foto lama jika tidak NULL
			if ($editFotoMemberLama !== NULL) {
				unlink('fotomember/' . $editFotoMemberLama);
			}
		}

		$queryUpdateMember = "UPDATE member SET 
			nama = '$editNamaMember',
			linkIG = '$editLinkMember',
			foto = '$editFotoMemberBaru'
			WHERE id = $idSimpanEditMember
		";

		if (mysqli_query($conn, $queryUpdateMember)) {
			header('Location: dasboard.php');
		} else {
			echo "Error: " . $queryUpdateMember . "<br>" . mysqli_error($conn);
		}
	}

$sqladmin = "SELECT * FROM useradmin";
$queryadmin = mysqli_query($conn,$sqladmin);
$rowadmin = mysqli_fetch_assoc($queryadmin);

//	TAMBAH TUGAS		TAMBAH TUGAS		TAMBAH TUGAS		TAMBAH TUGAS
	if (isset($_POST['simpanTambahTugas'])) {
		$namaMatkulTambah = $_POST['namaMatkulTambah'];
		$detailTugas = $_POST['detailTugas'];
		$deadline = $_POST['deadline'];
		$pengumpulan = $_POST['pengumpulan'];
		$tambahJenisPenugasan = $_POST['tambahJenisPenugasan'];
		
		//query insert ke database	
		$sql = "INSERT INTO detail VALUES ('', '$namaMatkulTambah', '$detailTugas', '$deadline', '$pengumpulan', '$tambahJenisPenugasan')";
		if ($conn->query($sql) === TRUE) {
			header('Location: dasboard.php');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

$sqltugas = "SELECT * FROM detail";
$querytugas = mysqli_query($conn,$sqltugas);
$rowtugas = mysqli_fetch_assoc($querytugas);

//	HAPUS TUGAS		HAPUS TUGAS		HAPUS TUGAS		HAPUS TUGAS
	if(isset($_GET['hapusTugas'])){
		$idHapusTugas = $_GET['idHapusTugas'];

		$queryHapusTugas = "DELETE FROM detail WHERE id = $idHapusTugas";
		mysqli_query($conn, $queryHapusTugas);

		if ($conn->query($queryHapusTugas) === TRUE) {
			header('Location: dasboard.php');
		} else {
			echo "Error: " . $queryHapusTugas . "<br>" . $conn->error;
		}
	}



?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Tables - Ready Bootstrap Dashboard</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<link rel="shortcut icon" href="images/favicon.png" />
	<link rel="stylesheet" href="node_modules/flag-icon-css/css/flag-icon.min.css" />
	<link rel="stylesheet" href="css/dasboard.css">
</head>
<body>

<!-- sidebar =============================================================== -->
		<div class="sidebar">
			<div >
				<h4>PTIK H</h4>
			</div>
			<div class="scrollbar-inner sidebar-wrapper">
				<ul class="nav">
					<li class="nav-item">
						<a href="#mataKuliah" style="text-decoration: none;">
							<i class="la la-list-ul"></i>
							<p>Mata Kuliah</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#tugas" style="text-decoration: none;">
							<i class="la la-pencil-square"></i>
							<p>Tugas</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#member" style="text-decoration: none;">
							<i class="la la-group"></i>
							<p>Member</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#userAdmin" style="text-decoration: none;">
							<i class="la la-user"></i>
							<p>Admin</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="index.php" style="text-decoration: none;">
							<i class="la la-dedent"></i>
							<p>Beranda</p>
						</a>
					</li>
					<div class="nav-item logout" >
						<a href="logout.php" style="text-decoration: none;">
							<i class="la la-sign-out"></i>
							<p>LOGOUT</p>
						</a>
					</div>
				</ul>
			</div>
		</div>

<!-- CONTENT ============================================================ CONTENT-->
			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
<!-- tambah mata kuliah ===================================================-->
						<?php if(isset($_GET['tambah'])){ ?>
							<div class="col-md-6">
								<div class="card ">
								<form action="dasboard.php?tambahMatkul" method="post">
									<div class="card-header">
										<div class="card-title">Tambah Mata Kuliah</div>
									</div>
									<div class="card-body">
										<div class="form-group">
											<label for="solidInput">Nama Mata Kuliah</label>
											<input name="tambahNamaMatkul" type="text" class="form-control input-solid" id="solidInput" placeholder="Masukkan Nama Mata Kuliah" >
										</div>
										<div class="form-group">
											<label for="solidInput">Nama Dosen</label>
											<input name="tambahNamaDosen" type="text" class="form-control input-solid" id="solidInput" placeholder="Masukkan Nama Dosen">
										</div>										
									</div>
									<div class="card-action">
										<button class="btn btn-success">Tambah</button>
									</div>
								</form>
								</div>				
							</div>
						<?php } ?>

<!-- edit mata kuliah ===================================================-->
						<?php if(isset($_GET['editMatkul'])){ ?>
							<div class="col-md-6">
								<div class="card ">
								<form action="dasboard.php" method="post">
								<input type="hidden" name="idEditDosen" value="<?= $idEditMatkul;?>">
									<div class="card-header">
										<div class="card-title">Edit Mata Kuliah</div>
									</div>
									<div class="card-body">
										<div class="form-group">
											<label for="solidInput">Nama Mata Kuliah</label>
											<input type="text" name="namaMataKuliah" class="form-control" id="solidInput" value="<?= $namaMataKuliah;?>" >
										</div>
										<div class="form-group">
											<label for="solidInput">Nama Dosen</label>
											<input type="text" name="namaDosenEdit" class="form-control" id="solidInput" value="<?= $namaDosenEdit;?>">
										</div>										
									</div>
									<div class="card-action">
										<button class="btn btn-success" name="simpatEditMatkul">Edit</button>
									</div>
								</form>
								</div>
							</div>
						<?php } ?>
<!-- tambah tugas ===================================================-->
						<?php if(isset($_GET['tambahTugas'])){ ?>
							<div class="col-md-12">
								<div class="card">
								<form action="dasboard.php" method="post">
									<div class="card-header">
										<div class="card-title" id="tambahTugas">Tambah Tugas</div>
									</div>									
									<div class="card-body d-flex">
										<div class="col-7">
											<div class="d-flex">									
												<div class="form-group col-8">
													<label for="exampleFormControlSelect1">Mata Kuliah</label>
													<select class="form-control" id="exampleFormControlSelect1" name="namaMatkulTambah">
														<option value="Pemrogaman Web">Pemrogaman Web</option>
														<option value="Jaringan Komputer">Jaringan Komputer</option>
														<option value="Profesi Kependidikan">Profesi Kependidikan</option>
														<option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
														<option value="Inovasi Teknologi">Inovasi Teknologi</option>
														<option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
														<option value="Struktur Data">Struktur Data</option>
														<option value="Strategi Pembelajaran">Strategi Pembelajaran</option>
													</select>
												</div>
												<div class="form-group col-4">
													<label for="exampleFormControlSelect1">Jenis Penugasan</label>
													<select class="form-control" id="exampleFormControlSelect1" name="tambahJenisPenugasan">
														<option value="Individu">Individu</option>
														<option value="Kelompok">Kelompok</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="email">Deadline</label>
												<input type="text" class="form-control" id="email" name="deadline" placeholder="Batas Pengumpulan">
											</div>
											<div class="form-group">
												<label for="password">Pengumpulan</label>
												<input type="text" class="form-control" id="password" name="pengumpulan" placeholder="Tempat Pengumpulan">
											</div>
										</div>										
										<div class="form-group col-5">
											<label for="comment">Detail Tugas</label>
											<textarea class="form-control" name="detailTugas" id="comment" rows="9"></textarea>
										</div>
									</div>
									<div class="card-action">
										<button class="btn btn-success" name="simpanTambahTugas">Tambah</button>
										<button class="btn btn-danger">Cancel</button>
									</div>
								</form>
								</div>
							</div>
						<?php } ?>

<!-- tambah member ==============================================================-->
						<?php if(isset($_GET['tambahMember'])){?>
							<div class="col-md-6">
								<form action="dasboard.php" method="post" enctype="multipart/form-data">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Tambah Member</div>
									</div>
									<div class="card-body">
										<div class="form-group">
											<label for="solidInput">Nama Panggilan</label>
											<input type="text" class="form-control input-solid" id="solidInput" name="tambahMemberNamPang" placeholder="Nama Panggilan">
										</div>		
										<div class="form-group">
											<label for="solidInput">LInk IG</label>
											<input type="text" class="form-control input-solid" id="solidInput" name="tambahMemberLIG" placeholder="Masukkan Nama Dosen">
										</div>
										<div class="form-group">
											<label for="exampleFormControlFile1">Upload Foto</label>
											<input type="file" class="form-control-file" name="tambahMemberFoto" id="exampleFormControlFile1">
										</div>								
									</div>
									<div class="card-action">
										<button class="btn btn-success" name="tambahMemberBaru">Tambah</button>
										<button class="btn btn-danger">Cancel</button>
									</div>
								</div>
								</form>
							</div>
						<?php } ?>

<!-- edit member ==============================================================-->
						<?php if (isset($_GET['editMember'])) { ?>
							<div class="col-md-6">
								<form action="" method="post" enctype="multipart/form-data">
									<input type="hidden" name="idPilihMember" value="<?= $idPilihMember ?>">
									<input type="hidden" name="fotoMemberLama" value="<?= $editMemberFoto ?>">
									<div class="card">
										<div class="card-header">
											<div class="card-title">Edit Member</div>
										</div>
										<div class="card-body">
											<div class="form-group col-7">
												<img class="mb-3" src="fotomember/<?= $editMemberFoto ?>" width="120px"><br>
												<input type="file" class="form-control" id="solidInput" name="fotoMemberEdit">
											</div>
											<div class="form-group">
												<label for="solidInput">Nama Panggilan</label>
												<input type="text" class="form-control" id="solidInput" value="<?= $namaMemberEdit ?>" name="namaMemberEdit">
											</div>
											<div class="form-group">
												<label for="solidInput">LInk IG</label>
												<input type="text" class="form-control" id="solidInput" value="<?= $linkMemberEdit ?>" name="linkMemberEdit">
											</div>
										</div>
										<div class="card-action">
											<button class="btn btn-success" name="simpanEditMember">Edit</button>
										</div>
									</div>
								</form>
							</div>
						<?php } ?>
					</div>

<!-- MATA KULIAH =============================================================-->
					<div class="container-fluid">
						<h4 class="page-title" id="mataKuliah">Mata Kuliah</h4>
						<div class="row">
<!-- daftar mata kuliah ====================================================-->
							<div class="col-md-12 ">
								<div class="card " >
									<div class="card-header">
										<div class="card-title d-flex justify-content-between px-3">
											<h6 style="margin-bottom: 0;">Daftar Mata Kuliah</h6>
											<a href="dasboard.php?tambah=1" class="btn btn-primary" style="padding:5px;">
												<i class="la la-plus la-2x text-white"></i>
											</a>
										</div>									
										<table class="table mt-3">
										<form action="dasboard.php" method="post"></form>
											<thead>
												<tr>
													<th scope="col">No.</th>
													<th scope="col">Mata Kuliah</th>
													<th scope="col">Dosen</th>
													<th scope="col">Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php $No=1;?>
											<?php foreach($query as $row) :?>
											<tr>
												<td><?= $No++; ?></td>
												<td><?= $row["namaMatkul"]; ?></td>
												<td><?= $row["dosen"]; ?></td>
												<td>
													<a href="dasboard.php?editMatkul=1&id=<?= $row ["id"];?>" class="btn btn-info" style="padding:4px; margin-right:5px;">
														<i class="la la-pencil-square la-2x text-white"></i>
													</a>
													<a href="dasboard.php?hapusMatkul=1&idHapusMatkul=<?= $row ["id"];?>" class="btn btn-danger" style="padding:4px;">
														<i class="la la-trash la-2x text-white"></i>
													</a>
												</td>
											</tr>
											<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						
						</div>
					</div>
				

<!-- TUGAS ================================================================= TUGAS-->
					<div class="container-fluid" id="tugas">
						<h4 class="page-title">Tugas</h4>
						<div class="row">
<!-- daftar tugas ========================================================== daftar tugas-->
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header">
										<div class=" card-title d-flex justify-content-between px-3">
											<h6 style="margin-bottom: 0;">Daftar Tugas</h6>
											<a href="dasboard.php?tambahTugas=1" class="btn btn-primary" style="padding:5px;">
												<i class="la la-plus la-2x text-white"></i>
											</a>
										</div>
										<table class="table mt-3">
											<thead>
												<tr>
													<th scope="col">No.</th>
													<th scope="col">Mata Kuliah</th>
													<th scope="col">Jenis Penugasan</th>
													<th scope="col">Detail Tugas</th>
													<th scope="col">Deadline</th>
													<th scope="col">Pengumpulan</th>
													<th scope="col">Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php $No=1; ?>										
											<?php foreach ($querytugas as $key ) { ?>
												<tr>
													<td><?= $No++ ?></td>
													<td><?= $key['matkul']?></td>
													<td><?= $key['jenis']?></td>
													<td><?= $key['tugas']?></td>
													<td><?= $key['deadline']?></td>
													<td><?= $key['pengumpulan']?></td>
													<td>
														<a href="dasboard.php?hapusTugas=1&idHapusTugas=<?= $key['id']?>" class="btn btn-danger"  style="padding:4px;">
															<i class="la la-trash la-2x text-white"></i>
														</a>
													</td>
												</tr>
											<?php } ?>										
											</tbody>
										</table>
									</div>
								</div>
							</div>
				
						</div>
					</div>

<!-- MEMBER =============================================================== MEMBER-->
					<div class="container-fluid" >
						<h4 class="page-title" id="member" >Mamber</h4>
						<div class="row">

<!-- daftar member ===========================================================-->
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="d-flex justify-content-between px-3">
											<div class="card-title">Daftar Member PTIK H</div>
											<a href="dasboard.php?tambahMember=1" class="btn btn-primary" style="padding:5px;">
												<i class="la la-plus la-2x text-white"></i>
											</a>
										</div>
										<table class="table mt-2";>
											<thead>
												<tr>
													<th scope="col">No.</th>
													<th scope="col">Foto</th>												
													<th scope="col">Nama</th>
													<th scope="col">Link IG</th>
													<th scope="col">Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php $No=1; ?>
											<?php foreach( $queryMember as $row) : ?>
												<tr>
													<td><?= $No ?></td>
													<td><img src="fotomember/<?php echo $row["foto"]; ?>" style="width: 70px;"></td>
													<td><?= $row['nama']; ?></td>
													<td><?= $row['linkIG']; ?></td>
													<td>
														<a href="dasboard.php?editMember=1&idEditMember=<?= $row ["id"];?>" class="btn btn-info"  style="padding:4px; margin-right:5px;">
															<i class="la la-pencil-square la-2x text-white"></i>
														</a>
														<a href="dasboard.php?hapusMember=1&idHapusMember=<?= $row ["id"];?>" class="btn btn-danger"  style="padding:4px; margin-right:5px;">
															<i class="la la-trash la-2x text-white"></i>
														</a>
													</td>
												</tr>
											<?php $No++; ?>
											<?php endforeach ; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>	

<!-- ADMIN ============================================================ ADMIN-->
					<div class="container-fluid" id="userAdmin">
						<h4 class="page-title" id="mataKuliah">User Admin</h4>
						<div class="row">
<!-- daftar admin ====================================================-->	
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Daftar</div>									
										<table class="table mt-3">
											<thead>
												<tr>
													<th scope="col">No.</th>
													<th scope="col">Username</th>
													<th scope="col">Password Encryption</th>
													<th scope="col">Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php $No=1;?>
											<?php foreach ($queryadmin as $rowadmin ) { ?>
												<tr>
													<td><?= $No++; ?></td>
													<td><?= $rowadmin['username']?></td>
													<td><?= $rowadmin['password']?></td>
													<td>
														<a href="" class="btn btn-danger"  style="padding:4px;">
															<i class="la la-trash la-2x text-white"></i>
														</a>												
													</td>
												</tr>
											<?php }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

</div>
</body>
	<script src="assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="assets/js/core/popper.min.js"></script>
	<script src="assets/js/core/bootstrap.min.js"></script>
	<script src="assets/js/plugin/chartist/chartist.min.js"></script>
	<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
	<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
	<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
	<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
	<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<script src="assets/js/ready.min.js"></script>
	<script>
		$('#displayNotif').on('click', function(){
			var placementFrom = $('#notify_placement_from option:selected').val();
			var placementAlign = $('#notify_placement_align option:selected').val();
			var state = $('#notify_state option:selected').val();
			var style = $('#notify_style option:selected').val();
			var content = {};

			content.message = 'Turning standard Bootstrap alerts into "notify" like notifications';
			content.title = 'Bootstrap notify';
			if (style == "withicon") {
				content.icon = 'la la-bell';
			} else {
				content.icon = 'none';
			}
			content.url = 'index.html';
			content.target = '_blank';

			$.notify(content,{
				type: state,
				placement: {
					from: placementFrom,
					align: placementAlign
				},
				time: 1000,
			});
		});
	</script>
</html>