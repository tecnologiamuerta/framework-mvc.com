$(function(){
    if($("#hSender").length == 0){
        var sender = $("<input type='hidden' id='hSender' name='hSender' />");
        $("form").append(sender);
    }
    DefaultClickBehavior();
});
$(window).load(function(){
});

function DefaultClickBehavior(){
    $('a, button, input[type=button], input[type=submit]').click(function(event){
        $("#hSender").val(event.target.id);
        console.log(event.target.id);
    });
}