/** SR-APP */

$(document).ready(function() {
    console.log("StarRentals ready");

    $("#check-upgrade").click(function(e) {
        $.ajax({
            type: "POST",
            url: App.AJAX_UPGRADE,
            data: $("#booking-form").serialize(),
            success: function(r) {
                if (r.is_upgradable) {
                    $("#check-result").html(r.client.firstname + " " + r.client.lastname + " can be upgraded to " + r.elite_range);
                } else {
                    $("#check-result").html(
                        r.client.firstname + " " + r.client.lastname + " can not be upgraded to " +
                        r.elite_range + " and have to stay with " + r.basic_range
                    );
                }
            }
        });

        e.preventDefault();
        return false;
    });
});
