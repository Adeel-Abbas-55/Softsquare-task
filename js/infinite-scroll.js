// custom infinite scroll 
jQuery(function($) {
    var can_load = true;
    var max_pages = infinite_scroll_params.max_pages;
    var current_page = 1;

    $(window).scroll(function() {
        if (can_load && $(window).scrollTop() + $(window).height() >= $(document).height()) {
            can_load = false;
            if (current_page < max_pages) {
                current_page++;
                $.ajax({
                    url: infinite_scroll_params.next_posts_url,
                    data: {
                        paged: current_page,
                    },
                    type: 'GET',
                    success: function(response) {
                        var new_posts = $(response).find('.blog-card');
                        $('.grid-container').append(new_posts);
                        can_load = true;
                    }
                });
            }
        }
    });
});
