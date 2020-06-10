$(function () {
    $('.search-dishes').on('click', function () {
        let values = $('#w0').select2("data");
        values = values.map(function (elem) {
            return elem.id;
        });
        values = values.join(',');
        $.ajax({
            url: '/site/search',
            data: {values: values},
            type: 'GET',
            success: function (res) {
                $('.body-content').html(res);
            },
            error: function (e) {
                alert(e);
            }
        });
        return false;
    });
});