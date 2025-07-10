# PHP-PDO-Active-Passive
## Merhaba,

JQUERY Ajax ile projelerinizde veya uygulamalarınızda aktif ve pasif olan Yönetici paneline aktif ve pasif düğmeye girerek daha pratik ve verimli siteler oluşturabilirsiniz.
#### Projemiz Nasıl Çalışır,

Checkbox'ta yaptığımız eylemi "activedata.js" dosyasına gönderiyoruz. sonra "activepassiv.php"yi güncelliyoruz
## İndex.php
Aktif Pasif Ve Ürünler
![alt text](https://github.com/barisiceny/PHP-PDO-Active-Passive/blob/main/img/ss/home.png?raw=true)
### İndex.php 
->H2 etiketindeki düzenleme durumunu veya hataları gösterir (active data.js aracılığıyla)
![alt text](https://github.com/barisiceny/PHP-PDO-Active-Passive/blob/main/img/ss/home-edit.png?raw=true)
->Gördüğünüz gibi, pasif olanlar ürün tablosunda görünmüyor.
## DataTable Tablo

Not=Veritabanı Tablomuzun Etkin sütununu "int" veri türü ve varsayılan kısmı "no default" ile uygulayın
![alt text](https://github.com/barisiceny/PHP-PDO-Active-Passive/blob/main/img/ss/database-table.png?raw=true)
### DataTable Veriler
![alt text](https://github.com/barisiceny/PHP-PDO-Active-Passive/blob/main/img/ss/database-table-data.png?raw=true)
## Kaynak Kodları

#### Aktif Pasif için Kod
```
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
```
#### Veritabanındaki Verileri Sıralama Kodu
```
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
    </html
```

#### activepassive.php için kod
```
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
```
#### aktifdata.js

```
$(document).ready(function () {
    $('.ActivePassive').click(function (event) {
        var id = $(this).attr("id");  //id değerini alıyoruz

        var status = ($(this).is(':checked')) ? '1' : '0';
        //Onay kutusuna göre, aktif mi yoksa pasif mi olduğu bilgisini alırız.

        $.ajax({
            type: 'POST',
            url: 'activepassive.php',  //İşlediğimiz sayfayı belirtiriz
            data: {id: id, status: status}, //Verilerimizi gönderiyoruz
            success: function (result) {
                $('#result').text(result);
                //Sonucu h2 etiketinde gösteriyoruz
            },
            error: function () {
                alert('Error');
            }
        });
    });
});
```
#### Veritabanı Ayarları
```
<?php
$host = '127.0.0.1';
$dbname = 'activepassive';  // Veritabanımızın adını yazdık
$username = 'root'; 
$password = '';
$charset = 'utf8';
//$collate = 'utf8_unicode_ci';
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    
];
try {
    $connect = new PDO($dsn, $username, $password, $options);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connect Error: ' . $e->getMessage();
    exit;
}
?>

```



İyi kodlamalar

