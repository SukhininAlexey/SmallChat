function listen(id = 0){
    var data = {id: id};
    $.ajax({
        type: "GET",
        data: data,
        url: "http://localhost/SmallChat/server/servernew.php",
        success: function(response){
            response = JSON.parse(response);
            console.log(response.id);
            response.arr.forEach(function(item, i, arr){
                var message = document.createElement('p');
                message.innerText = item[2] + ": " + item[3];
                $("#chat").append(message);
            });
            listen(response.id);
        }
    });
}

function handelSend(){
     var message = $("#message").val();
     var user = $("#message").attr('username');
     	
    var posting = $.post( "http://localhost/SmallChat/server/servernew.php", { author: user, message: message } );
    console.log(posting);
}

$(function(){
    var user = prompt('Введите ваш ник');
    $("#message").attr('username', user);
    $("#send").click(handelSend);
    listen();
});

