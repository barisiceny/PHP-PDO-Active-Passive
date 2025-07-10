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
