
$('.btn_save').on("click",function(){
    // собираем данные с формы
    let user_data= $('.editFom').serialize();
    // отправляем данные

    $.ajax({
        url: "/update", // куда отправляем
        type: "post", // метод передачи
        dataType: "json", // тип передачи данных
        data: user_data,
        // после получения ответа сервера
        success: function(result){
            $('.messages').html(result.success); // выводим ответ сервера
        }
    });
});