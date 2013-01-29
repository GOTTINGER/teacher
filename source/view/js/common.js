$(function () {
    $('.vote-btn').click(function () {
    	var that = $(this);
        var action = $(this).data('action');
        var target = $(this).data('target');
        var type = $(this).data('type');
        $.get('/attitude/'+type, {action:action, target:target}, function (ret) {
        	$('.'+action+'-count').text(ret);
            if (that.hasClass('btn-inverse')) {
                $('.vote-btn').removeClass('btn-inverse');
            } else {
            	$('.vote-btn').removeClass('btn-inverse');
            	$('.'+action+'-btn').addClass('btn-inverse');
            }
        });
    });
});
