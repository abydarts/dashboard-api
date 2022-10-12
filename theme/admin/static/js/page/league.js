$(document).ready(function () {
    $(document).on('click', '#add-league-team', function(){
        $.ajax({
            type: "POST",
            url: "/admin/league/add-team",
            data: {
                league: league,
                team: team,
            },
            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.status == "success") {
                    toastr.success(resp.message, "Approval KYC");
                    window.setTimeout(function () {
                        window.location.href = base_url + "kyc_list";
                    }, 500);
                } else {
                    toastr.error(resp.message, "Approval KYC");
                }
            }
        });
    });
})