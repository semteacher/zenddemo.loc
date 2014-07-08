$(function(){
console.log("My js loaded OK!");
    var fx={
        "InitModal":function(){
            if($(".modal-window").length===0){
                return $("<div>")
                    .addClass("modal-window")
                    .appendTo("body");
            } else {
                return $(".modal-window");
            }
        }

    };
    
    var addalbum=$(".albumadd");
    addalbum.click("click", function(event){
        event.preventDefault();
        $(this).addClass("active");
        console.log($(this));
        var data1 = $(this)
            .attr("href")
            .replace("add", "addAjax");
        modal=fx.InitModal();
        console.log(data1); 
        $.ajax({
            type:"POST",
            url:data1,
            success:function(data){
                modal.append(data);
            },
            error:function(msg){
                modal.append(msg);
            }
        });        
    });

    var editalbum=$(".albumedit");
    editalbum.click("click", function(event){
        event.preventDefault();
        $(this).addClass("active");
        var ids = $(this)
            .attr("id");
        var data1 = $(this)
            .attr("href")
            .replace("edit", "editAjax");
        var data = $(this)
            .attr("href")
            .replace(/.+?\? (.*)$/, "$1"),
        modal=fx.InitModal();
        console.log($(this));
        console.log(data1);
        $.ajax({
            type:"GET",
            url:data1,
            dataType: 'json',
            success:function(data){
                modal.append(data);
                $("#albumtitle").val(data.title);
                $("#albumartist").val(data.artist);
                $("#id").val(data.id);
            },
            error:function(msg){
                modal.append(msg);
            }
        });
    });

    $("#editAlbumForm").submit(function(e)
    {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        console.log(postData);
        $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR)
                {
                    console.log("data saved!");
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                }
            });
        e.preventDefault();	//STOP default action
    });
});