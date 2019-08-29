function getMovie() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("movies").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "http://localhost/projects/server.php", true);
    xmlhttp.send();
}

var edit=(obj)=>{
    var id=$(obj).val();
    $("#"+id).html("<form action=\"/projects/server.php\" id='edit' method=\"POST\"> Actor name: <input type=\"text\" id=\"actor\"> <br> Genre: <input type=\"text\" id=\"genre\"> <br> Rating: <input type=\"text\" id=\"rating\"> <br> <input type=\"submit\" value=\"Submit\" onclick='sentedit(this)' ></form>");
}

var sentedit = (obj)=>{
    $("#edit").submit(function(e){
        console.log('here');
        e.preventDefault();
        $.post(
            '/projects/server.php?req=edit',
            {
                name: $(obj).parents('#parent').find('#mname').text(), //finding corresponding movie name
                actor: $("#actor").val(),
                rating: $("#rating").val(),
                genre: $("#genre").val(),

            },
            function(result){
                if(result == 'successfull'){
                    getMovie();
                }else{
                    // $("#result").html(result);
                }
            }
        )
    })
}

var del = (obj)=>{
    $.ajax({
        type:'delete',
        url:'/projects/server.php',
        data:{name:$(obj).parents('#parent').find('#mname').text()},
        success: function(data){
             if(data=="successfully"){
                 getMovie();
             }else{
                 alert(data)
             }
        }
    
    })

}

var addactorgenre=(greq,id,formid)=>{
    console.log($("#"+id).val());
    $("#"+formid).submit(function(e){
        e.preventDefault();
        $.post(
            '/projects/actorgenre.php?req='+greq,
            {
                aname: $("#"+id).val()

            },
            function(result){
                $("#result").html(result);
            }
        )
    });
}

var name,actor,rating,genre,img;
window.onload = function() {
    getMovie();

  };