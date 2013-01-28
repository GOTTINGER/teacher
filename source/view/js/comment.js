$(function () {
    $('.vote-btn').click(function () {
        var action = $(this).data('action');
        var target = $(this).data('target');
        $.get('/attitude/comment', {action:action, target:target}, function (ret) {
        	console.log(ret)
        })
    });
});
