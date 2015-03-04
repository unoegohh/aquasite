

function getNames(r){
    var $ul = $(r).parent();
    $ul.addClass('converted');
    var runTwise = 0;
    $ul.hide();
    var $template = $("<div><a href='#' class='click_me_to_open'>e</a><div class='hello_me' style='display:none'></div></div>");
    var index = 0;
    $ul.children().each(function(){
        if(index == 0){
            $template.find('a').html($(this).html().replace("##", ""));
        }else{
            var $newTemplate = $("<span style='padding:0 0 0 20px;'></span><br>");
            if($(this).find('ul').length == 0){

                $newTemplate.first().html($(this).html());
                $template.find('.hello_me').append($newTemplate);
            }else{
                $template.find('.hello_me').append($newTemplate.first().html(getNames($(this).find('ul li').first())));
            }

        }
        index++
    });
    return $template;

}
$('ul:not(".converted")>li:first-child:contains("##")').each(function(){
    if(!$(this).parent().parent().is("li")){
        $(this).parent().after(getNames(this));
    }
});
$(document).on("click", ".click_me_to_open", function(e){
    e.preventDefault();
    console.log($(this).parent().find('div'));
    $(this).parent().find('div').first().toggle();
})