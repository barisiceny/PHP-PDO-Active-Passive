<!DOCTYPE html>
<html>
<head>
    <title>PHP PDO Active Passive</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!-- Verilerimizi göstermek için bir tablo oluşturduk-->
                <table class="table table-sm table-hover">
                    <br>
                    <h4 style="text-align:center;">Verilerin Aktif Pasif Düzenlemesi</h4>
                    <thead>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Active</th>                       
                    </thead>
                    <?php
                    include('fonc.php'); // Veritabanımızı sayfalarımıza dahil ediyoruz
                    $query = $connect->prepare("Select * from products"); // Verilerimizi id ye göre sıralamak için sorgumuzu yazıyoruz
                    $query->execute(); // Sorguyu başlatıyoruz

                    while ($result = $query->fetch())  // Verilerimizi sıralamak için bir süre döngüsü ile iade ettik
                            {      // While Start , Verilerimizi while'in başlangıcı ile while'ın sonu arasında sıralarız
                    ?>
                        <tbody>
                            <td><?= $result['id']?></td>
                            <td><?= $result['title']?></td>
                            <td><?= $result['content']?></td>
                            <td>
                                <label class="switch">
                                    <!-- id ve active (1 veya 0) bilgileri onay kutumuza ekledik -->
                                    <input type="checkbox" id='<?php echo $result['id'] ?>'
                                    class="ActivePassive" <?php echo $result['active'] == 1 ? 'checked' : '' ?> />  
                                    <!--Girişte class a yazılanlara dikkat edelim. Bu verileri "activedata.js" adlı dosyamıza göndereceğiz -->
                                     <span class="slider"></span>
                                </label>
                            </td>                            
                            </tbody>
                            <?php
                        }  // While bitişi

                        ?>
                    </table>
                    <h2 style="color:red; text-align:center;" id="result"></h2> <!-- Hataları ve sonuçları bildirmek için başlığımız -->
                </div>

                <div class="col-md-6">
                <!--Veritabanında Verileri Sıralama -->
                    <table class="table">
                        <br>
                        <h4 style="text-align:center;">Ürünler</h4>
                        <h6>Veritabanındaki Verileri Sıralama</h6>

                        <thead class="thead-dark">
                             <tr>
                                <th scope="col">id</th>
                                <th scope="col">Başlık</th>
                                <th scope="col">Açıklama</th>                                
                             </tr>
                        </thead>
                    <tbody>
                        <?php
                            $query = $connect->prepare("SELECT * FROM products where active=1"); 
            // Verilerinizi Aktif-Pasif Duruma göre sıralıyoruz. Durum = 1 verileri gösterir. Durum = 0 Veri göstermiyoruz
                            $query->execute(); // query end

                                while ($result = $query->fetch()) 
                                    { //Başlarken, verilerimizi while'in başlangıcı ile while'ın sonu arasında sıralarız
                        ?>

                            <tr>
                                <td><?= $result['id']?></td>
                                <td><?= $result['title']?></td>
                                <td><?= $result['content']?></td>  
                            </tr>

                            <?php
                                    } //While bitiş
                            ?>
                        
                    </tbody>
                </table>
                    


                </div>
            </div>
        </div>
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="activedata.js"></script> <!-- Dahil olmak üzere "activdata.js" dosyamızı alıyoruz-->
        <link rel="stylesheet" type="text/css" href="css/switch.css"> <!--Aktif Pasif switch css dosyasını dahil ediyoruz -->
    </body>
    </html>
