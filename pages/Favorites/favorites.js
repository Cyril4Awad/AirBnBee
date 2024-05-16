// JavaScript code to handle favorite icon click
$(document).ready(function() {
    $('.carousel-favorite').click(function() {
        var listingId = $(this).data('listing-id');
        var spanElement = $(this).find('span');

        $.ajax({
            type: 'POST',
            url: 'update_favorite.php',
            data: { listingId: listingId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (spanElement.hasClass("glyphicon-heart-empty")) {
                        spanElement.removeClass("glyphicon-heart-empty").addClass("glyphicon-heart");
                    } else {
                        spanElement.removeClass("glyphicon-heart").addClass("glyphicon-heart-empty");
                    }
                } else {
                    alert('Failed to update favorite status: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while processing your request.');
            }
        });
    });
});




