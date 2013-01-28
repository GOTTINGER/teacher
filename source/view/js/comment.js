$(function () {
    $('.vote-btn').click(function () {
    	var that = $(this);
        var action = $(this).data('action');
        var target = $(this).data('target');
        $.get('/attitude/comment', {action:action, target:target}, function (ret) {
        	$('.'+action+'-count').text(ret);
        	$('.vote-btn').removeClass('btn-inverse');
        	$('.'+action+'-btn').addClass('btn-inverse');
        });
    });
});
