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
        console.log(ids);
        console.log(data1);
        $.ajax({
            type:"GET",
            url:data1,
            success:function(data){
                modal.append(data);
            },
            error:function(msg){
                modal.append(msg);
            }
        });
    });

});