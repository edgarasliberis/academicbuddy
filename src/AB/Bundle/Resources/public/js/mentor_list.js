jQuery(document).ready(function() {
    $('select.category-select').on('change', function() {
        $url = Routing.generate('mentor_list', {category: this.value}, true)
        window.location.href = $url;
    });

    $('div.show').on('click', function () {
        var button = $(this);
        var descr = $(this).parent().parent().find(".extended")
        descr.slideToggle(100, function() {
            if (descr.is(":visible")) button.html("Mažiau");
            else button.html("Daugiau");
        });
    });

});
