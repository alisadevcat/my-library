
$('#btn_save').on("click",function(event){
    event.preventDefault();

    
    let user_data= $('form[name="editForm"]').serialize();
    let url =window.location.origin;
    let id = $("input[name=id]").val();

    $.ajax({
        url: `/update/${id}`, 
        type: "post", 
        data: user_data,
        success: function(response){
            let result = JSON.parse(response);
            setTimeout(() => window.location.replace(url), 2000);
            $('#success').html(result.response);
        }
    });
});



$("#btn_add").on("click",function(event){
    event.preventDefault();

    let data= $("#addForm").serialize();
    let url1 =window.location.origin;

    $.ajax({
        url: '/addForm', 
        type: "post", 
        data: data,
        success: function(result){
            let response = JSON.parse(result);
            setTimeout(() => window.location.replace(url1), 2000);
            $('#success').html(response.result);
            
        }
    });
});


