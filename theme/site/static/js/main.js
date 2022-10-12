$(document).ready(function () {
    $('.menu-btn').click(function(event) {
        $('.navbar-ifel').toggleClass('open-nav');
    });

    $('.bs-slick').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      prevArrow: '<button class="slide-arrow prev-arrow"><ion-icon name="chevron-back-outline"></ion-icon></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><ion-icon name="chevron-forward-outline"></ion-icon></button>',
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false
          }
        },
        {
          breakpoint: 480,
          settings: {
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false
          }
        }
      ]
    });

    $('.banner-slider').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      prevArrow: '<button class="slide-arrow prev-arrow"><ion-icon name="chevron-back-outline"></ion-icon></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><ion-icon name="chevron-forward-outline"></ion-icon></button>',
      dots: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
          }
        }
      ]
    });

    $('.matchday-slider').slick({
        prevArrow: '<button class="slide-arrow prev-arrow"><ion-icon name="chevron-back-outline"></ion-icon></button>',
        nextArrow: '<button class="slide-arrow next-arrow"><ion-icon name="chevron-forward-outline"></ion-icon></button>',
      centerMode: true,
      centerPadding: '0px',
      // slidesToShow: 7,
      // slidesToScroll: 7,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 3,
            slidesToScroll: 3,
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 3,
            slidesToScroll: 3,
          }
        }
      ]
    });
    $('.matchday-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        let matchDate = $(slick.$slides[nextSlide]).attr('data-date'),
            matchDateText = $(slick.$slides[nextSlide]).attr('data-date-text'),
            className = '.match-schedule.match-'+matchDate
            content = '',

        $('.md-selected-date').text(matchDateText);
        $('.match-schedule').addClass('d-none')
        $(className).removeClass('d-none')
        if($(className).length == 0){
            $.ajax({
                type: "POST",
                url: "/get-match-by-date",
                data: {
                    league_id: $('#league-id').val(),
                    date: matchDate,
                },
                success: function (response) {
                    var resp = response;
                    if (resp.error == false) {
                        if (resp.data.length > 0) {
                            resp.data.forEach(function(d){
                                matchDate = new Date(d.match_date);
                                score = '<strong class="badge bg-black">' + ("0" + matchDate.getHours()).slice(-2) +":"+("0" + matchDate.getMinutes()).slice(-2) + '</strong>';
                                if(d.result !== null) score = '<strong>' + d.result.home_score + ' - ' + d.result.away_score + '</strong>';
                                content += `<tr class="match-schedule match-`+matchDate+`">
                                        <td></span><span class="full-name d-none d-sm-inline-block">`+d.home.name+`</span><span class="d-inline-block d-sm-none">`+d.home.name+`</span><img src="`+d.home.flag+`" width="20px" class="align-middle ms-2"></td>
                                        <td>`+score+`</td>
                                        <td><img src="`+d.away.flag+`" width="20px" class="align-middle me-2"><span class="d-inline-block d-sm-none">`+d.away.name+`</span><span class="full-name d-none d-sm-inline-block">`+d.away.name+`</span></td>
                                    </tr>`;
                            })
                        } else {
                            content = `<tr class="match-schedule match-`+matchDate+`">
                                        <td colspan="3" class="text-center">
                                            <small>No Match</small>
                                        </td>
                                    </tr>`
                        }
                        $('.schedule-table tbody').append(content);

                    } else {
                        // alert(resp.data);
                        // toastr.error(resp.data, "Add Team");
                    }
                }
            });
        }
    });
    if($('#closest-date').length > 0){
        $('.matchday-slider').slick('slickGoTo', $('#closest-date').val());
    }
    $('.select-club').on('click', function(){
        var teamId = $(this).attr('data-id')
        $('.select-club').removeClass('active')
        $(this).addClass('active')
        $('.club-details').addClass('d-none')
        $('.club-player').addClass('d-none')
        $('.club-details.club-'+teamId).removeClass('d-none')
        $('.club-player.club-'+teamId).removeClass('d-none')
        if($('.club-details.club-'+teamId).length == 0) {
            $.ajax({
                type: "POST",
                url: "/get-club-details",
                data: {
                    league_id: $('#league-id').val(),
                    club_id: teamId,
                },
                success: function (response) {
                    var resp = response;
                    if (resp.error == false) {
                        contentPlayer = '';
                        content = '';

                        content = '<div class="club-details club-'+resp.data.team.id+'">\n' +
                            '                                <div class="row">\n' +
                            '                                    <div class="col-12 col-lg-2">\n' +
                            '                                        <img src="'+resp.data.team.flag+'" class="logo-club">\n' +
                            '                                    </div>\n' +
                            '                                    <div class="col-12 col-lg-10">\n' +
                            '                                        <div class="row">\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Games</div>\n' +
                            '                                                <div class="score">'+resp.data.match_played+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Wins</div>\n' +
                            '                                                <div class="score">'+resp.data.win+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Goal Scored</div>\n' +
                            '                                                <div class="score">'+resp.data.goal_for+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Draws</div>\n' +
                            '                                                <div class="score">'+resp.data.draw+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Lose</div>\n' +
                            '                                                <div class="score">'+resp.data.lose+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Fouls</div>\n' +
                            '                                                <div class="score">'+resp.data.fouls+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Passes Success</div>\n' +
                            '                                                <div class="score">'+resp.data.pass_success+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Goal Concended</div>\n' +
                            '                                                <div class="score">'+resp.data.goal_against+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Saves</div>\n' +
                            '                                                <div class="score">'+resp.data.saves+'</div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="cd-li">\n' +
                            '                                                <div class="title">Clean Sheets</div>\n' +
                            '                                                <div class="score">'+resp.data.clean_sheets+'</div>\n' +
                            '                                            </div>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                            </div>';


                        if(resp.data.team.players.length > 0) {
                            resp.data.team.players.forEach(function(p){
                                contentPlayer += '<div class="col-6 col-lg-4 club-player club-'+resp.data.team.id+'">\n' +
                                    '                                        <a href="#" class="cp-li"><img src="'+p.avatar+'"></a>\n' +
                                    '                                        <h5>'+p.name+'</h5>\n' +
                                    '                                    </div>'
                            })
                        }

                        $('.club-detail-wrapper .club-row').append(content);
                        $('.club-players .row').append(contentPlayer);

                    } else {
                        // alert(resp.data);
                        // toastr.error(resp.data, "Add Team");
                    }
                }
            });
        }
    })

    $('.club-logo').slick({
      arrows: false,
      infinite: false,
      slidesToShow: 3,
      prevArrow: '<button class="slide-arrow prev-arrow"><ion-icon name="chevron-back-outline"></ion-icon></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><ion-icon name="chevron-forward-outline"></ion-icon></button>',
      responsive: [
        {
            breakpoint: 9999,
            settings: "unslick"
        },
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            slidesToShow: 3
          }
        },
        {
          breakpoint: 480,
          settings: {
            infinite:true,
            centerMode: true,
            centerPadding: '40px',
            arrows: true,
            slidesToShow: 3,
            focusOnSelect: true,
          }
        }
      ]
    });

    $('.product-slider').slick({
      arrows: false,
      infinite: false,
      dots: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
          }
        }
      ]
    });

    // $('.checkbox-circle input[type="checkbox"]').click(function(){
    //     $('.checkbox-circle input[type="checkbox"]').prop("checked", false);
    //     $(this).prop("checked", true);
    // });

    $(document).on('click', '.checkbox-circle input[type="checkbox"]', function(){
        $('.checkbox-circle input[type="checkbox"]').prop("checked", false);
        $(this).prop("checked", true);
    });

    $(document).on('click', '.checkbox-pill input[type="checkbox"]', function(){
        $('.checkbox-pill input[type="checkbox"]').prop("checked", false);
        $(this).prop("checked", true);
    });

    // $('.checkbox-pill input[type="checkbox"]').click(function(){
    //     $('.checkbox-pill input[type="checkbox"]').prop("checked", false);
    //     $(this).prop("checked", true);
    // });

    $(document).on('click', '.quiz-gold-a input[type="checkbox"]', function(){
        $('.quiz-gold-a input[type="checkbox"]').prop("checked", false);
        $(this).prop("checked", true);
    });

    $(document).on('click', '.quiz-gold-b input[type="checkbox"]', function(){
        $('.quiz-gold-b input[type="checkbox"]').prop("checked", false);
        $(this).prop("checked", true);
    });


    $('.btn-number').click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });

    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });

    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });

    // $('.datepicker').datepicker({
    //     format: 'dd/mm/yyyy'
    // });

    $("#quiz-bronze").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        autoFocus: true,
        labels: {
            finish: "Selesai",
            next: "Berikutnya",
            previous: "Kembali",
        },
        onFinishing: function (event, currentIndex)
        {
            // $("#quiz-form").validate().settings.ignore = ":disabled";
            document.getElementById("quiz-form").submit();
            // return $("#quiz-form").valid();
        },
    });

    $("#quiz-silver").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        autoFocus: true,
        labels: {
            finish: "Selesai",
            next: "Berikutnya",
            previous: "Kembali",
        }
    });

    $("#quiz-gold").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        autoFocus: true,
        labels: {
            finish: "Selesai",
            next: "Berikutnya",
            previous: "Kembali",
        }
    });

    if($("#wizard-store").length > 0){
        $("#wizard-store").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            onStepChanging: function (event, currentIndex, newIndex) {
                if ( newIndex === 1 ) {
                    $('.steps ul').addClass('step-2');
                } else {
                    $('.steps ul').removeClass('step-2');
                }
                if ( newIndex === 2 ) {
                    $('.steps ul').addClass('step-3');
                } else {
                    $('.steps ul').removeClass('step-3');
                }

                if ( newIndex === 3 ) {
                    $('.steps ul').addClass('step-4');
                    $('.actions ul').addClass('step-last');
                } else {
                    $('.steps ul').removeClass('step-4');
                    $('.actions ul').removeClass('step-last');
                }
                return true;
            },
            labels: {
                finish: "Saya Sudah Bayar",
                next: "Lanjutkan",
                previous: "Kembali"
            }
        });
    }

});


(function () {
  var sidebar = document.getElementById("sidebar");
  if(sidebar != null) {
      var sidebarOverlay = document.getElementsByClassName("sidebar-overlay")[0];
      var container = document.getElementsByClassName("container")[0];
      var sidebarBtnClose = document.getElementById("sidebarBtnClose");
      var sidebarBtnOpen = document.getElementById("sidebarBtnOpen");

      var openSidebar = function () {
          sidebarOverlay.style.right = "0";
          sidebar.style.right = "0";
      };

      var closeSidebar = function (e) {
          e.cancelBubble = true;
          sidebarOverlay.style.right = "-100%";
          sidebar.style.right = "-100%";
      };

      sidebarOverlay.addEventListener("click", closeSidebar);
      sidebarBtnClose.addEventListener("click", closeSidebar);
      sidebarBtnOpen.addEventListener("click", openSidebar);
  }
})();

function checkAll(ele) {
      var checkboxes = document.getElementsByTagName('input');
      if (ele.checked) {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox' ) {
                  checkboxes[i].checked = true;
              }
          }
      } else {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox') {
                  checkboxes[i].checked = false;
              }
          }
      }
  }



