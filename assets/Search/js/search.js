$(function(){$(".rating").raty({path:"/assets/raty/lib/img",noRatedMsg:"Not rated yet",click:function(a){var c=$(this).find('[type="hidden"]').val();$.ajax({url:"/",method:"post",data:{ajax:!0,media_id:c,rating:a}})},score:function(){return $(this).attr("data-score")},hints:["bad","poor","regular","good","great"]})});