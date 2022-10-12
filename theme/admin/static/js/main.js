window.mapData = function mapData(data) {
    var result = $.map(data, function (data) {
        return {
            id: data.id,
            text: data.name
        };
    });

    return result;
};

$(document).ready(function () {
    $(document).on('click', '.add-team-league', function(){

        let league = $(this).attr('data-league')
        let team = $(this).attr('data-team')
        $.ajax({
            type: "POST",
            url: "/admin/league/add-team",
            data: {
                league: league,
                team: team,
            },
            success: function (response) {
                var resp = response;
                if (resp.error == false) {
                    alert(resp.data)
                    // toastr.success(resp.data, "Add Team");
                    // window.setTimeout(function () {
                    //     window.location.href = base_url + "";
                    // }, 500);
                } else {
                    alert(resp.data);
                    // toastr.error(resp.data, "Add Team");
                }
            }
        });
    });

    $(document).on('click', '.remove-team-league', function(){
        if(confirm('Are you sure?')) {
            let league = $(this).attr('data-league')
            let team = $(this).attr('data-team')
            $.ajax({
                type: "POST",
                url: "/admin/league/remove-team",
                data: {
                    league: league,
                    team: team,
                },
                success: function (response) {
                    var resp = response;
                    if (resp.error == false) {
                        alert(resp.data)
                        // toastr.success(resp.data, "Remove Team");
                        // window.setTimeout(function () {
                        //     window.location.href = base_url + "";
                        // }, 500);
                    } else {
                        alert(resp.data);
                        // toastr.error(resp.data, "Remove Team");
                    }
                }
            });
        }
    });

    // $('.js-data-select-team').ready(function () {
        let selectTeam = $('.js-data-select-team').select2({
            placeholder: "Select a team",
            data: [],
        })
    // })


    $(document).on('change', '#admin-match-edit-fld-league', function(){
        let leagueId = $(this).val();
        $('.js-data-select-team').find('option').remove()
        selectTeam.empty();;
        selectTeam.select2("val", "");
        $.getJSON(base_url+'/admin/league/'+leagueId+'/teams', function (response) {
            response.data.forEach(function (data) {
                var newOption = new Option(data.name, data.id, false, false);
                $('.js-data-select-team').append(newOption)
            })

        })
    });


})