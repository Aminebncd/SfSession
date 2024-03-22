document.addEventListener('DOMContentLoaded', function () {
    const burgerMenu = document.querySelector('.burger-toggler');
    const navbar = document.querySelector('.navbar');

    burgerMenu.addEventListener('click', function () {
        navbar.classList.toggle('active');
    });
});



console.log('okkkk')

$(document).ready(function() {
    $('.modifier-programme-btn').click(function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        var programmeId = $(this).data('programme-id');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                programme: programmeId
            },
            success: function(response) {
                $('.modifier-programme-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
