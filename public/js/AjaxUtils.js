$(function(){
   $("[data-type=ajax]").click(function(e){
    var url = $(this).attr("href");
    var target = $(this).attr("data-target");
    var content = $.get(url, function(data){
        $(target).html(data);
        SetFormAjax(target);
    });
    e.preventDefault();
   });
});

function SetFormAjax(target){
    if($("#hSender").length == 0){
        var sender = $("<input type='hidden' id='hSender' name='hSender' />");
        $("form").append(sender);
    }
    $("form[data-type=ajax]").submit(function(e){
        var url = $(this).attr("action");
        var data = $(this).serialize();
        $.post(url, data, function(d){
            $(target).html(d);
            SetFormAjax(target);
        });
        e.preventDefault();
    });
    DefaultClickBehavior();
}