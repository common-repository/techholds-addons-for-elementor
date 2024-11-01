jQuery(document).ready(function($) {
    // Handle star click event.
    $(document).on('click', '.techholds-ea-rating .star', function() {
        var $stars = $(this).siblings('.star');
        var rating = $(this).data('rating');
        var postId = $(this).closest('.techholds-ea-rating').data('post-id');

        // Reset all stars.
        $stars.removeClass('active fractional');

        $stars.find('i.fraction-star').remove();

        // Update star styles based on clicked star.
        $stars.each(function() {
            var $star = $(this);
            var starRating = $star.data('rating');

            if (starRating <= rating) {
                $star.addClass('active');
            } else {
                $star.removeClass('active');
            }
        });

        // Handle the clicked star itself.
        $(this).addClass('active');


        // Send AJAX request to update rating.
        $.ajax({
            url: techholdsFrontendScript.ajaxurl, // Use localized ajaxurl.
            type: 'POST',
            data: {
                action: 'thafe_techholds_update_rating',
                post_id: postId,
                rating: rating,
                nonce: techholdsFrontendScript.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('.techholds-ea-rating-text').hide();
                    $('.techholds-ea-thanks-rating-text').show();
                } else {
                    $('.techholds-ea-rating-text').text('Failed to update rating');
                }
            }
        });
    });
});