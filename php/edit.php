<?php
require '../function.php';

$sql = "SELECT * FROM matkul";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($query);

$id = $_GET['id'];
$sql = "SELECT * FROM matkul WHERE id = '".$id."'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$iniidi = $id;
$namaMatkul =$row["namaMatkul"];
$dosen =$row["dosen"];

if (isset($_POST["editMatkul"])){
    if (editMatkul($_POST)>0) {
        echo "
            <script>
                alert ('matkul berhasil diedit');
                document.location.href = 'admin.php';
            </script>
        ";
    }else{
        echo "
        <script>
            alert ('matkul gagal diedit');
            document.location.href = 'admin.php';
        </script>
    ";
    }
}

?>