jQuery(document).ready(function() {

    function userTypeFromFlags(mentors, pupils) {
        if(mentors && pupils) return 'all';
        if(mentors) return 'mentors';
        if(pupils) return 'pupils';
        return null;
    }

    function statusFromFlags(enabled, notEnabled) {
        if(enabled && notEnabled) return 'all';
        if(enabled) return 'enabled';
        if(notEnabled) return 'disabled';
        return null;
    }

    $('#inform-applicants').on('click', function() {
        // if(confirm("This will inform all non-activated pupils that their application has been unsuccessful. Continue?")) {
        //     $.post(Routing.generate('groups_inform_unsuccessful'));
        // }
    });

    $('#export-csv').on('click', function() {
        var userType = userTypeFromFlags($("#mentors").is(".active"), $("#pupils").is(".active"));
        var status = statusFromFlags($("#enabled").is(".active"), $("#notenabled").is(".active"));
        if(!userType || !status) return;

        var data = {
            usertype : userType,
            status   : status,
            type     : "csv"
        };
        window.location = Routing.generate('user_data') + '?' + $.param(data);
    });

    // Handle change of scope
    $('input').change(function(obj) {
        var label = $(obj.target.labels[0]);
        label.toggleClass("active"); //jQuery triggers event first, then updates the state...

        var userType = userTypeFromFlags($("#mentors").is(".active"), $("#pupils").is(".active"));
        var status = statusFromFlags($("#enabled").is(".active"), $("#notenabled").is(".active"));
        
        var data = {
            usertype : userType,
            status   : status,
            type     : "email"
        };

        $('#export-csv').prop('disabled', !($("#mentors").is(".active") ^ $("#pupils").is(".active")));
        label.toggleClass("active");

        if(!userType || !status) return;
        $.get(Routing.generate('user_data'), data).done(function(resp) {
            $("#list").html(resp);
        });
    });

    // Initial data to be displayed
    $('#mentors').click();
    $('#enabled').click();
});
