<?php
if ($_POST) { //Bir gönderi olup olmadığını kontrol ediyoruz
    include("fonc.php"); //Veritabanına bağlanma

    //Değişkenleri tamsayılar olarak alıyoruz
    $id = (int)$_POST['id'];
    $status = (int)$_POST['status'];


    $line = array('id' => $id,
        'status' => $status,
    );
    // Veri güncelleme sorgumuzu yazıyoruz.
    $sql = "UPDATE products SET active=:status WHERE id=:id;";
    $status = $connect->prepare($sql)->execute($line);    
    echo $id . " Numaralı Veriler Değiştirildi";
}
?>
