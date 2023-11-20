<?php
$conn = mysqli_connect("localhost", "root", "", "ptikh");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result)) {
        $rows [] = $row;
    }
    return $rows;
}

// REGISTRASI USER ADMIN
function registrasi($data){
    global $conn;
    
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT * FROM userAdmin WHERE username = '$username'");

    if( mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username sudah terdaftar');
            </script>";
        return false;
    }

        //konfirmasi password
        if ($password !== $password2) {
            echo "<script>
                    alert('password tidak sesuai');
                </script>";
            return false;
        } 
    
        //enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);
    
        //insert user baru ke database
        mysqli_query($conn, "INSERT INTO userAdmin VALUES ('', '$username', '$password')");
    
        return mysqli_affected_rows($conn);
}

//TAMBAH MATA KULIAH
function tambahMatkul($data){
    global $conn;
    $tambahmatakuliah = htmlspecialchars($data["tambahmatakuliah"]);
    $tambahdosenpengampu = htmlspecialchars($data["tambahdosenpengampu"]);

    $query = "INSERT INTO matkul VALUES (
        '', '$tambahmatakuliah', '$tambahdosenpengampu'
    )";
    mysqli_query($conn, $query);

    header("Location: admin.php");

    return mysqli_affected_rows($conn);
}

//HAPUS MATA KULIAH
function hapusMatkul($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM matkul WHERE id = $id");

    mysqli_affected_rows($conn);
}

//EDIT
function editMatkul($data){
    global $conn;
    $id = $_POST["idEditMatkul"];
    $matkul = $_POST["editNamaMatakul"];
    $dosen = $_POST["editDosen"];

    $query = "UPDATE matkul SET 
            namaMatkul = '$matkul',
            dosen = '$dosen'
            WHERE id = $id
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
?>