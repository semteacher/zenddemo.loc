/**
 * Created by SemenetsA on 08.07.14.
 */
$(function(){
    $("#showform").click(function(){
        $("#winpopup").dialog({
            draggable:true,
            modal: true,
            autoOpen: false,
            height:300,
            width:400,
            resizable: false,
            title:'Form Ajax',
            position:{
                my: "center",
                at: "center"
            }
        });
        $("#winpopup").load($(this).attr('href'));
        $("#winpopup").dialog("open");

        return false;
    });
});