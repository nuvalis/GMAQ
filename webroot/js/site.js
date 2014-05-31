$('.login-modal').mzModal({
    url: window.base_url + '/users/login/json',
    complete: function () {
        $('.mzmodal-inner > form').attr('action', window.base_url + '/users/login');
    }
});

$('.up-link').on('click', function (e) {
    e.preventDefault();

    var url, id

    var questionsID = $(this).parent().attr("data-questionsID");
    var answersID = $(this).parent().attr("data-answersID");
    var commentsID = $(this).parent().attr("data-commentsID");

    if (questionsID) {

        url = 'questions/' + questionsID;
        id = '.qid-' + questionsID;

    } else if (answersID) {

        url = 'answers/' + answersID;
        id = '.aid-' + answersID;

    } else if (commentsID) {

        url = 'comments/' + commentsID;
        id = '.cid-' + commentsID;

    };

    console.log(url);

    $.ajax({
        type: "JSON",
        url: window.base_url + '/votes/up/' + url + '/json',
        data: 'data',
        success: function (data) {
            console.log('Response: ' + data.response);

            if (data.response == 'Success') {
                console.log(id);
                var val = $(id).find('.vote-value').html();
                val = parseInt(val);
                val++
                console.log(val);
                $(id).find('.vote-value').html(val);
            } else {

           	$(this).mzModal({
            	content: '<p class="center">'+data.response+'</p>',
            	title: "Vote Error",
            	ajax: false,
            	bind: false
        	});

            }
        },
        dataType: 'json',
        error: function (data) {
            console.log('Error: ' + data);
        }
    });

});

$('.down-link').on('click', function (e) {
    e.preventDefault();

    var url, id

    var questionsID = $(this).parent().attr("data-questionsID");
    var answersID = $(this).parent().attr("data-answersID");
    var commentsID = $(this).parent().attr("data-commentsID");

    if (questionsID) {

        url = 'questions/' + questionsID;
        id = '.qid-' + questionsID;

    } else if (answersID) {

        url = 'answers/' + answersID;
        id = '.aid-' + answersID;

    } else if (commentsID) {

        url = 'comments/' + commentsID;
        id = '.cid-' + commentsID;

    };

    console.log(url);

    $.ajax({
        type: "JSON",
        url: window.base_url + '/votes/down/' + url + '/json',
        data: 'data',
        success: function (data) {
            console.log('Response: ' + data.response);

            if (data.response == 'Success') {
                console.log(id);
                var val = $(id).find('.vote-value').html();
                val = parseInt(val);
                val--
                console.log(val);
                $(id).find('.vote-value').html(val);
            } else {

           	$(this).mzModal({
            	content: '<p class="center">'+data.response+'</p>',
            	title: "Vote Error",
            	ajax: false,
            	bind: false
        	});

            }
        },
        dataType: 'json',
        error: function (data) {
            console.log('Error: ' + data);
            window.alert('Error: ' + data);
        }
    });

});