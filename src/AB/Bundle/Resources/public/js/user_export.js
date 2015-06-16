jQuery(document).ready(function() {
    $('#export-csv').on('click', function() {
        var url = Routing.generate('user_data');
        var data = {
            mentors    : $("#mentors").is(".active"),
            pupils     : $("#pupils").is(".active"),
            enabled    : $("#enabled").is(".active"),
            notenabled : $("#notenabled").is(".active"),
            type       : "csv"
        };
        window.location = url + '?' + $.param(data);
    });

    // Handle change of scope
    $('input').change(function(obj) {
        var label = $(obj.target.labels[0]);
        label.toggleClass("active"); //jQuery triggers event first, then updates state...
        var url = Routing.generate('user_data');
        var data = {
            mentors    : $("#mentors").is(".active"),
            pupils     : $("#pupils").is(".active"),
            enabled    : $("#enabled").is(".active"),
            notenabled : $("#notenabled").is(".active"),
            type       : "email"
        };
        $('#export-csv').prop('disabled', !($("#mentors").is(".active") ^ $("#pupils").is(".active")));
        label.toggleClass("active");
        $.get(url, data).done(function(resp) {
            $("#list").html(resp);
        });
    });

    // Initial data to be displayed
    $('#mentors').click();
    $('#enabled').click();
});
