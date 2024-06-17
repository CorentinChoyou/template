$(document).ready(function () {

  //var utm_data = $.trim($.session.get("utm_data"));
  //console.log("utm_data", utm_data); 

  if ($(".tooltipMessage").length) {
    $('.tooltipMessage').tooltip();
  }

  if ($(".popOverMessage").length) {
    $('.popOverMessage').popover();
  }

  if ($('.videolink').length) {
    $('.videolink').click(function (e) {
      e.preventDefault();
      var link = $(this).attr('href');
      //var linkvideo = $('#videoLive').attr('src');

      $('#videoLive').attr('src', link);

      linkvideo = link;
    });
  }


  function parallaxEffect(div) {
    //console.log("parallaxEffect div", div);    
    var scrollTop = $(document).scrollTop();
    var height = $(window).height();

    if ($.trim(div) != "" && $("." + div).length) {
      var containerTop = $('.' + div).offset().top;
      var heightCont = $('.' + div).height();
      var heightObj = $('.' + div + ' span').height();

      if (containerTop <= scrollTop + height && scrollTop - heightCont <= containerTop) {
        var topStart = containerTop - height;
        var topEnd = containerTop + heightCont;
        var totalScroll = (containerTop + heightCont) - (containerTop - height);
        var plusParallax = (((heightObj) * 100) / heightCont);
        var numParallax = ((scrollTop - topStart) * (100 - plusParallax)) / totalScroll;

        $('.' + div + ' span').css('top', -numParallax + '%');
      }
    }
  }
  parallaxEffect('apostrophe');

  if ($(".intl_tel_input").length) {
    $(".intl_tel_input").intlTelInput({
      //geoIpLookup: function (callback) {
      //        $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
      //          var countryCode = (resp && resp.country) ? resp.country : "";
      //          //console.log("countryCode", countryCode);    
      //          callback(countryCode);
      //        });
      //      },
      placeholderNumberType: "MOBILE",
      separateDialCode: true,
      hiddenInput: "full_phone",
      initialCountry: "fr",
      preferredCountries: ["fr", "us", "gb"], //, "in"
      utilsScript: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + "assets/js/intl-tel-input/js/utils.js?" + Math.random(),
    });
  }

  function ValidateintlTelInput(id) {
    if ($("#" + id).length) {
      var telInput = $("#" + id);
      if ($.trim(telInput.val())) {
        //console.log( $.trim( telInput.val() ) );
        if (telInput.intlTelInput("isValidNumber")) {
          //console.log(telInput.intlTelInput("getNumber"));
          //console.log('Valid' );

          // $( "#" + id ).parent().parent().removeClass( 'has-error' );
          $("#" + id).removeClass('is-invalid');
          $("#" + id).parent().parent().find('.invalid-feedback').css("display", "none").html("Required");
          return true;
        } else {
          // console.log(telInput.intlTelInput("getValidationError"));
          //alert('invalid');
          //$( "#" + id ).parent().parent().addClass( 'has-error' ); //select parent twice to select div form-group class and add has-error class
          $("#" + id).addClass('is-invalid');
          $("#" + id).parent().parent().find('.invalid-feedback').css("display", "block").html("Please enter a valid mobile number.");
          return false;
        }
      }
    }
    return true;
  }

  //$('#form_registration').on('submit', function(e) {
  window.addEventListener('load', function () {
    if ($(".needs-validation").length) {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      var $modal = $("#registrationForm");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (e) {
          if (form.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
          } else {
            e.preventDefault();
            e.stopPropagation();

            var $ValidateintlTelInputReturn = true;
            $ValidateintlTelInputReturn = ValidateintlTelInput("phone");
            //console.log("ValidateintlTelInputReturn", $ValidateintlTelInputReturn);

            if ($ValidateintlTelInputReturn) {
              form.classList.add('was-validated');

              var choyou_site_url = (typeof CHOYOU_SITE_URL !== "undefined") ? CHOYOU_SITE_URL : "https://www.choyou.fr/";
              var choyou_save_post_filename = (typeof CHOYOU_SAVE_POST_FILENAME !== "undefined") ? CHOYOU_SAVE_POST_FILENAME : "";

              if ($.trim(choyou_site_url) != "" && $.trim(choyou_save_post_filename) != "") {
                var total_choyou_save_post_file_url = choyou_site_url + choyou_save_post_filename;

                //console.log("total_choyou_save_post_file_url", total_choyou_save_post_file_url);

                var $data = $(this).serialize();

                var utm_data = $.trim($.session.get("utm_data"));
                //console.log("utm_data", utm_data);

                if ($.trim(utm_data) != "") {
                  $data += "&" + $.trim(utm_data);
                }
                //console.log("$data", $data);

                $.ajax({
                  method: 'POST',
                  data: $data,
                  url: total_choyou_save_post_file_url,
                  async: true,
                  cache: false,
                  crossdomain: true,
                  dataType: 'json',
                  beforeSend: function (xhr, settings) {
                    $modal.showLoading();
                  },
                  complete: function (e) {
                    $modal.hideLoading();
                      
                    $.session.remove("utm_data");    

                    if ($("#registrationForm").length) {
                      //$("#registrationForm").hide();
                      $("#registrationForm").fadeOut(1000);
                    }

                    if ($('#issend').length) {
                      //$('#issend').show();
                      $('#issend').fadeIn(1000);
                    }
                  },
                });

              } else {
                $.alert({
                  title: "Encountered an error!",
                  content: "Sorry! there is a configuration problem.",
                  type: 'red',
                  typeAnimated: true,
                  closeIcon: true,
                  closeIconClass: 'fa fa-close',
                  autoClose: 'close|5000',
                  buttons: {
                    close: function () {}
                  }
                });
              }
            }
            //else {}
          }
          form.classList.add('was-validated');
        }, false);
      });
    }
  }, false);

  $('#inscription #form_registration input').on('click focus focusout', function (e) {
    $(this).siblings('label').addClass('top');
    console.log(e.type);
    if (e.type === 'focus' || e.type === 'focusout') {
      if ($(this).val() === '' || $(this).val() === undefined) {
        console.log('empty');
        $(this).siblings('label').removeClass('top');
      }
    }
  });

  //===================================================================================//
  if ($(".modal").length) {

    $(".modal").each(function (index) {
      $(this).on("shown.bs.modal", function (e) {

        var randomAnnimation = "fadeIn"

        var open = ($.trim($(this).attr("data-easein")) != "") ? $.trim($(this).attr("data-easein")) : "fadeIn";
        open = (open != "") ? randomAnnimation : open;
      });
    });
  }


  if ($(".btnModalLoginForm").length) {
    //console.log("btnModalLoginForm exists");
    $(".btnModalLoginForm").on("click", function () {
      //console.log("btnModalLoginForm click");

      /*if ($('#form_registration').length) {
        frm_loginvalidator.resetForm();

        $('#form_registration')[0].reset();
        if ($('#form_registration').hasClass("was-validated")) {
          $('#form_registration').removeClass("was-validated");
        }
      }*/

      var $modal = $("#ModalLoginForm");
      if ($modal.css("display") == "none") {
        $('#frm_login')[0].reset();
        $modal.modal("show");
      }

    });
  }

  // close_thank_you
  if ($("#close_thank_you").length) {
    $("#close_thank_you").on("click", function () {
      //console.log("close_thank_you click");

      if ($('#form_registration').length) {
        $('#form_registration')[0].reset();
        if ($('#form_registration').hasClass("was-validated")) {
          $('#form_registration').removeClass("was-validated");
        }
        $('#form_registration').fadeIn(1000);
      }

      if ($("#registrationForm").length) {
        //$("#registrationForm").show();
        $("#registrationForm").fadeIn(1000);
      }

      if ($('#issend').length) {
        //$('#issend').hide();
        $('#issend').fadeOut(1000);
      }
    });
  }

  // check is event start datetime
  function check_is_event_started(currentStatus) {
    //console.log("check_is_user_connected");
    var $currentStatus = ($.trim(currentStatus)) ? $.trim(currentStatus).toLowerCase() : false;
    //console.log("currentStatus", $currentStatus);
    //console.log("$status Number", Number( $currentStatus ) );  

    $.ajax({
      type: "POST",
      url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + "ajax.php",
      data: {
        "function": "check_is_event_started",
      },
      dataType: "json",
      cache: false,
      success: function (data) {
        //console.log(data);  
        var $status = data.hasOwnProperty("status") ? data.status : false;
        //console.log("$status", $status);
        //console.log("$status Number", Number( $status )); 

        if (Number($currentStatus) !== Number($status)) {
          //console.log("reload");
          window.location.reload(true);
        } else {
          //console.log("all is well");
        }
      },
    });
  }
  $.fn.check_is_event_started = function (currentStatus) {
    check_is_event_started(currentStatus);
  }

  // check is user logged in
  function check_is_user_connected(currentStatus) {
    //console.log("check_is_user_connected");
    var $currentStatus = ($.trim(currentStatus)) ? $.trim(currentStatus).toLowerCase() : false;
    //console.log("currentStatus", $currentStatus);
    //console.log("$status Number", Number( $currentStatus ) );  

    $.ajax({
      type: "POST",
      url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + "ajax.php",
      data: {
        "function": "check_is_user_connected",
      },
      dataType: "json",
      cache: false,
      success: function (data) {
        //console.log(data);  
        var $status = data.hasOwnProperty("status") ? data.status : false;
        //console.log("$status", $status);
        //console.log("$status Number", Number( $status )); 

        if (Number($currentStatus) !== Number($status)) {
          //console.log("reload");
          window.location.reload(true);
        } else {
          //console.log("all is well");
        }
      },
    });
  }
  $.fn.check_is_user_connected = function (currentStatus) {
    check_is_user_connected(currentStatus);
  }

  if ($("#frm_login").length) {
    var frm_loginvalidator = $("#frm_login").validate({
      rules: {
        email: {
          required: true,
          email: true,
        },
      },
      // Custom message for error
      messages: {
        email: {
          required: "You must enter an email address..",
          email: "Please enter a valid email address.",
        }
      },

      highlight: function (element, errorClass) {
        $(element).closest(".form-group").addClass("has-error");
      },
      unhighlight: function (element, errorClass) {
        $(element).closest(".form-group").removeClass("has-error");
      },
      errorPlacement: function (error, element) {
        error.appendTo(element.parent().next());
      },
      errorPlacement: function (error, element) {
        if (element.attr("type") == "checkbox") {
          element.closest(".form-group").children(0).prepend(error);
        } else
          error.insertAfter(element);
      },
      submitHandler: function (form) {
        //console.log("submit"); 
        var $modal = $("#ModalLoginForm");
        $.ajax({
          url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + 'ajax.php',
          type: 'POST',
          data: $("#frm_login").serialize() + "&function=connectUser",
          async: true,
          cache: false,
          crossdomain: true,
          dataType: 'json',
          beforeSend: function (xhr, settings) {
            $modal.showLoading();
          },
          success: function (data) {
            $modal.hideLoading();
            //console.log("data", data);

            var $status = data.hasOwnProperty("status") ? data.status : false;
            var $title = data.hasOwnProperty("title") ? data.title : "Encountered an error!";
            var $type_class = data.hasOwnProperty("type_class") ? data.type_class : "red";
            var $html = data.hasOwnProperty("html") ? data.html : "";
            var $attendee_status_approved = data.hasOwnProperty("attendee_status_approved") ? data.attendee_status_approved : false;
            var $time = ($attendee_status_approved) ? 5000 : 10000;

            if ($('#form_registration').lenth) {
              frm_loginvalidator.resetForm();

              $('#form_registration')[0].reset();
              if ($('#form_registration').hasClass("was-validated")) {
                $('#form_registration').removeClass("was-validated");
              }
            }

            $.alert({
              title: $title,
              content: $html,
              type: $type_class,
              typeAnimated: true,
              closeIcon: false,
              closeIconClass: 'fa fa-close',
              autoClose: 'ok|' + $time,
              buttons: {
                ok: {
                  text: 'Ok',
                  btnClass: 'btn-green',
                  action: function () {
                    if ($status) {
                      if ($attendee_status_approved) {
                        window.location.reload(true);
                      }
                    } else {
                      if ($("#liveChat").length) {
                        //$("#liveChat").hide();
                        $("#liveChat").fadeOut(1000);
                      }

                      if ($('#registrationForm').length) {
                        //$('#registrationForm').show();
                        $('#registrationForm').fadeIn(1000);
                      }
                    }
                  }
                },
                //close: function () { }
              }
            });

            $modal.modal('hide');
          },
          error: function (jqXHR, textStatus, errorThrown) {
            $modal.hideLoading();
            $.alert({
              title: "Encountered an error!",
              content: "Sorry! there is a problem when connecting.",
              type: 'red',
              typeAnimated: true,
              closeIcon: true,
              closeIconClass: 'fa fa-close',
              autoClose: 'close|5000',
              buttons: {
                close: function () {}
              }
            });
          }
        });
      }
    });
  }


  // btn_modal_sign_in
  if ($(".btn_login").length) {
    $(".btn_login").on('click', function () {
      //console.log("btn_login click");
      var $modal = ($("#ModalLoginForm").length && $("#ModalLoginForm").css("display") == "block") ? $("#ModalLoginForm") : "";

      if ($.trim($modal) != "") {
        $modal.modal('hide');
      }

      if ($('#form_registration').length) {
        frm_loginvalidator.resetForm();

        $('#form_registration')[0].reset();
        if ($('#form_registration').hasClass("was-validated")) {
          $('#form_registration').removeClass("was-validated");
        }
      }

      if ($("#liveChat").length) {
        //$("#liveChat").hide();
        $("#liveChat").fadeOut(1000);
      }

      if ($('#registrationForm').length) {
        //$('#registrationForm').show();
        $('#registrationForm').fadeIn(1000);
      }

    });
  }

  //logout
  if ($(".logout").length) {
    //console.log("logout exists");  
    $(".logout").on('click', function () {
      //console.log("logout click");

      var $modal = $("body");

      $.confirm({
        title: "Confirmation de déconnexion!",
        content: "Voulez-vous vraiment vous déconnecter?",
        type: 'blue',
        typeAnimated: true,
        closeIcon: true,
        closeIconClass: 'fa fa-close',
        buttons: {
          yes: {
            text: 'Oui',
            btnClass: 'btn-green',
            action: function (button) {
              // ajax delete data to database
              $.ajax({
                url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + 'ajax.php',
                type: 'POST',
                data: {
                  function: "logout",
                },
                async: true,
                cache: false,
                crossdomain: true,
                dataType: 'json',
                beforeSend: function (xhr, settings) {
                  $modal.showLoading();
                },
                success: function (data) {
                  $modal.hideLoading();

                  //console.log(data);
                  var $status = data.hasOwnProperty("status") ? data.status : false;
                  var $html = ($status) ? "Vous vous êtes déconnecté avec succès!" : "Sorry! there is a problem when connecting..";

                  $.alert({
                    title: "Information!",
                    content: $html,
                    type: "green",
                    typeAnimated: true,
                    closeIcon: false,
                    closeIconClass: 'fa fa-close',
                    autoClose: 'ok|5000',
                    buttons: {
                      ok: {
                        text: 'Ok',
                        btnClass: 'btn-green',
                        action: function () {
                          if ($status) {
                            window.location.reload(true);
                          }
                        }
                      },
                      //close: function () { }
                    }
                  });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  $modal.hideLoading();
                  $.alert({
                    title: "Encountered an error!",
                    content: "Sorry! there is a problem when connecting..",
                    type: 'red',
                    typeAnimated: true,
                    closeIcon: true,
                    closeIconClass: 'fa fa-close',
                    autoClose: 'close|5000',
                    buttons: {
                      close: function () {}
                    }
                  });
                }
              });
            }
          },
          no: function () {}
        }
      });


    });
  }


  //===================================================================================//

  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

    for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  };

  if ($(".linkedin_connect").length) {
    $(".linkedin_connect").click(function (e) {
      //e.preventDefault();
      // e.stopPropagation();

      var $id = $(this).attr("id");
      //console.log($id);
      $.session.set("linkedin_connect", $id);
      //console.log("linkedin_connect", $.session.get("linkedin_connect"));

      if ($id == "1_click_connect") {
        var event_qs = $.trim(getUrlParameter("event"));
        if ($.trim(event_qs) != "") {
          $.session.set("event", event_qs);
          //console.log("session.event",$.trim($.session.get("event")));   
        }
      }
    });
  }

  var linked_in_code = $.trim(getUrlParameter("code"));
  if ($.trim(linked_in_code) != "") {
    //console.log("linked_in_code", linked_in_code);

    var linkedin_connect = $.trim($.session.get("linkedin_connect"));
    //console.log("linkedin_connect", linkedin_connect);

    if (linkedin_connect == "join_linkedin_group") {
      var $modal = $("body");

      $.ajax({
        url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + 'ajax.php',
        type: 'POST',
        data: "function=join_linkedin_group&code=" + $.trim(linked_in_code),
        async: true,
        cache: false,
        crossdomain: true,
        dataType: 'json',
        beforeSend: function (xhr, settings) {
          $modal.showLoading();
        },
        success: function (data) {
          //console.log(data);
          $modal.hideLoading();

          var $status = data.hasOwnProperty("status") ? data.status : false;

          if ($status) {
            var $linked_group = data.hasOwnProperty("linked_group") ? data.linked_group : "";
            if ($.trim($linked_group) != "") {
              window.location.href = $linked_group;
            } else {
              if ($.trim(SITE_URL) != "") {
                window.location.href = $.trim(SITE_URL);
              }
            }
          } else {
            var $error = data.hasOwnProperty("error") ? " " + $.trim(data.error) : "Sorry! there is a problem when joining the LinkedIn discussion group.";
            //console.log($error);

            $.alert({
              title: "Encountered an error!",
              content: $error,
              type: 'red',
              typeAnimated: true,
              closeIcon: true,
              closeIconClass: 'fa fa-close',
              autoClose: 'close|7000',
              buttons: {
                close: function () {
                  if ($.trim(SITE_URL) != "") {
                    window.location.href = $.trim(SITE_URL);
                  }
                }
              }
            });
          }

          //$modal.hideLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $modal.hideLoading();

          $.alert({
            title: "Encountered an error!",
            content: "Mistake! there is a problem when joining the LinkedIn discussion group.",
            type: 'red',
            typeAnimated: true,
            closeIcon: true,
            closeIconClass: 'fa fa-close',
            autoClose: 'close|5000',
            buttons: {
              close: function () {
                if ($.trim(SITE_URL) != "") {
                  //window.location.href = $.trim(SITE_URL);
                }
              }
            }
          });
        }
      });
    } else {
      var $modal = ($("#registrationForm").length) ? $("#registrationForm") : $("body");
      //$modal.showLoading();
      $.ajax({
        url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + 'ajax.php',
        type: 'POST',
        data: "function=signup_linkedin&code=" + $.trim(linked_in_code),
        async: true,
        cache: false,
        crossdomain: true,
        dataType: 'json',
        beforeSend: function (xhr, settings) {
          $modal.showLoading();
        },
        success: function (data) {
          //console.log(data);
          $modal.hideLoading();

          var $status = data.hasOwnProperty("status") ? data.status : false;

          if ($status) {

            if ($("#registrationForm").length) {
              //$("#registrationForm").hide();
              $("#registrationForm").fadeOut(1000);
            }

            if ($('#issend').length) {
              //$('#issend').show();
              $('#issend').fadeIn(1000);
            }

            if ($.trim(SITE_URL) != "") {
              var event_qs = "";
              event_qs = $.trim($.session.get("event"));
              event_qs = ($.trim(event_qs) != "") ? "event=" + event_qs : "";

              if ($.trim(event_qs) != "") {
                window.location.href = $.trim(SITE_URL) + "?" + event_qs + "&signup_via_linkedin=" + $status;
              } else {
                window.location.href = $.trim(SITE_URL) + "?signup_via_linkedin=" + $status;
              }
            }

          } else {
            var $error = data.hasOwnProperty("error") ? " " + $.trim(data.error) : "Désolé! il y a un problème lors de l'inscription via LinkedIn.";
            //console.log($error);

            $.alert({
              title: "Encountered an error!",
              content: $error,
              type: 'red',
              typeAnimated: true,
              closeIcon: true,
              closeIconClass: 'fa fa-close',
              autoClose: 'close|7000',
              buttons: {
                close: function () {
                  if ($.trim(SITE_URL) != "") {
                    window.location.href = $.trim(SITE_URL);
                  }
                }
              }
            });
          }

          //$modal.hideLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          $modal.hideLoading();

          $.alert({
            title: "Encountered an error!",
            content: "Erreur! there is a problem when registering via LinkedIn.",
            type: 'red',
            typeAnimated: true,
            closeIcon: true,
            closeIconClass: 'fa fa-close',
            autoClose: 'close|5000',
            buttons: {
              close: function () {
                if ($.trim(SITE_URL) != "") {
                  //window.location.href = $.trim(SITE_URL);
                }
              }
            }
          });
        }
      });
    }
  }
  //===================================================================================//

  var signup_via_linkedin = $.trim(getUrlParameter("signup_via_linkedin"));
  if ($.trim(signup_via_linkedin) != "") {
    //console.log("signup_via_linkedin", signup_via_linkedin);

    if ($('#form_registration').length) {
      frm_loginvalidator.resetForm();

      $('#form_registration')[0].reset();
      if ($('#form_registration').hasClass("was-validated")) {
        $('#form_registration').removeClass("was-validated");
      }
    }

    if ($("#registrationForm").length) {
      //$("#registrationForm").hide();
      $("#registrationForm").fadeOut(1000);
    }

    if ($('#issend').length) {
      //$('#issend').show();
      $('#issend').fadeIn(1000);
    }

    var event_qs = "";
    event_qs = $.trim(getUrlParameter("event"));
    event_qs = ($.trim(event_qs) != "") ? "?event=" + event_qs : "";
    var redirect_url = $.trim(SITE_URL) + event_qs;

    if ($.trim(SITE_URL) != "") {
      setTimeout(function () {
        window.location.href = $.trim(redirect_url);
      }, 7000);
    }
  }

  //===================================================================================//

  var connect = $.trim(getUrlParameter("connect"));
  if ($.trim(connect) != "") {
    //console.log("connect", connect);

    var $modal = $("body");

    $.ajax({
      url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + 'ajax.php',
      type: 'POST',
      data: "function=connectUser&email=" + $.trim(connect),
      async: true,
      cache: false,
      crossdomain: true,
      dataType: 'json',
      beforeSend: function (xhr, settings) {
        $modal.showLoading();
      },
      success: function (data) {
        $modal.hideLoading();
        //console.log("data", data);

        var $status = data.hasOwnProperty("status") ? data.status : false;
        var $title = data.hasOwnProperty("title") ? data.title : "Encountered an error!";
        var $type_class = data.hasOwnProperty("type_class") ? data.type_class : "red";
        var $html = data.hasOwnProperty("html") ? data.html : "";
        var $attendee_status_approved = data.hasOwnProperty("attendee_status_approved") ? data.attendee_status_approved : false;
        var $time = ($attendee_status_approved) ? 5000 : 10000;
        var currentURL = window.location.href.split('?')[0];
        //console.log("currentURL", currentURL);  

        $.alert({
          title: $title,
          content: $html,
          type: $type_class,
          typeAnimated: true,
          closeIcon: false,
          closeIconClass: 'fa fa-close',
          autoClose: 'ok|' + $time,
          buttons: {
            ok: {
              text: 'Ok',
              btnClass: 'btn-green',
              action: function () {
                if ($status) {
                  if ($attendee_status_approved) {
                    //window.location.reload(true);
                    if ($.trim(currentURL) != "") {
                      window.location.href = $.trim(currentURL);
                    }
                  }
                } else {
                  if ($("#liveChat").length) {
                    //$("#liveChat").hide();
                    $("#liveChat").fadeOut(1000);
                  }

                  if ($('#registrationForm').length) {
                    //$('#registrationForm').show();
                    $('#registrationForm').fadeIn(1000);
                  }

                  //if ($.trim(currentURL) != "") {
                  // window.location.href = $.trim(currentURL);
                  //}    
                }
              }
            },
            //close: function () { }
          }
        });

        $modal.modal('hide');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $modal.hideLoading();
        $.alert({
          title: "Encountered an error!",
          content: "Désolé! il y a un problème lors de la connexion.",
          type: 'red',
          typeAnimated: true,
          closeIcon: true,
          closeIconClass: 'fa fa-close',
          autoClose: 'close|5000',
          buttons: {
            close: function () {}
          }
        });
      }
    });
  }
  //===================================================================================//

  // download Management ==> downloads  
  if ($(".downloads").length) {
    //console.log("downloads");  
    $(".downloads").click(function (e) {
      //console.log("downloads click");     
      e.preventDefault();
      var $link = $.trim($(this).attr("href"));
      var $target = $.trim($(this).attr("target"));
      //console.log("link", $link); 
      //console.log("target", $target);

      var not_link_arr = ["#", "javascript: void(0);"];

      if ($link != "" && ($.inArray($link, not_link_arr) == -1)) {
        //console.log("proper_link", $link);
        var $modal = $("body");
        $.ajax({
          url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + 'ajax.php',
          type: 'POST',
          data: "function=downloads&link=" + $.trim($link),
          async: true,
          cache: false,
          crossdomain: true,
          dataType: 'json',
          beforeSend: function (xhr, settings) {
            $modal.showLoading();
          },
          success: function (data) {
            $modal.hideLoading();
            //console.log("data", data);
            if (data) {
              window.open($link, $target);
            } else {
              console.log("Problem while adding data!");
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            $modal.hideLoading();
            $.alert({
              title: "Encountered an error!",
              content: "Sorry! there is a problem when redirecting.",
              type: 'red',
              typeAnimated: true,
              closeIcon: true,
              closeIconClass: 'fa fa-close',
              autoClose: 'close|5000',
              buttons: {
                close: function () {}
              }
            });
          }
        });
      }
    });
  }

  //===================================================================================//
  // UTM 
  var utm_campaign = $.trim(getUrlParameter("utm_campaign"));
  if ($.trim(utm_campaign) != "") {
    //console.log("utm_campaign", utm_campaign);

    var currentURL = $(location).attr('href'); //jQuery solution 
    //console.log("currentURL", currentURL);

    var utm_source = $.trim(getUrlParameter("utm_source"));
    //console.log("utm_source", utm_source); 

    var utm_medium = $.trim(getUrlParameter("utm_medium"));
    //console.log("utm_medium", utm_medium);      

    var utm_referrer = $.trim(getUrlParameter("utm_referrer"));
    //console.log("utm_referrer", utm_referrer);  

    var $document_referrer = document.referrer;
    //console.log("document_referrer", $document_referrer);

    var $referrer = ($.trim(utm_referrer) != "") ? $.trim(utm_referrer) : $document_referrer;
    //console.log("referrer", $referrer);    

    var $query_string_data = get_query_string_data();
    //console.log("query_string_data", $query_string_data);  
    if ($.trim($query_string_data) != "") {
      $query_string_data += "&referrer=" + $referrer;
    }
    //console.log("query_string_data", $query_string_data);

    $.session.set("utm_data", $query_string_data);

    var utm_data = $.trim($.session.get("utm_data"));
    //console.log("utm_data", utm_data);

    var $modal = $("body");
    var redirect_url = $.trim(SITE_URL);
    $.ajax({
      url: ((typeof SITE_URL !== "undefined") ? SITE_URL : "") + "ajax.php",
      type: "POST",
      data: {
        "function": "record_utm_log",
        "page_url": $.trim(currentURL),
        "utm_source": $.trim(utm_source),
        "utm_medium": $.trim(utm_medium),
        "utm_campaign": $.trim(utm_campaign),
        "referrer": $referrer,
      },
      async: true,
      cache: false,
      crossdomain: true,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        $modal.showLoading();
      },
      success: function (data) {
        $modal.hideLoading();
        //console.log("data", data);
        if (data) {
          window.location.href = $.trim(redirect_url);
        } else {
          console.log("Problem while adding data!");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $modal.hideLoading();
        $.alert({
          title: "Encountered an error!",
          content: "Sorry! there is a problem while redirecting.",
          type: 'red',
          typeAnimated: true,
          closeIcon: true,
          closeIconClass: 'fa fa-close',
          autoClose: 'close|5000',
          buttons: {
            close: function () {
              window.location.href = $.trim(redirect_url);
            }
          }
        });
      }
    });
  }
  //===================================================================================/    
  function get_query_string_data() {
    var queries = {};
    $.each(document.location.search.substr(1).split('&'), function (c, q) {
      var i = q.split('=');
      queries[i[0].toString()] = i[1].toString();
    });
    //console.log(queries);

    //var recursiveEncoded = $.param(queries);
    var recursiveDecoded = decodeURIComponent($.param(queries));

    //console.log(recursiveEncoded);
    //console.log(recursiveDecoded);
    return recursiveDecoded;
  }
  //===================================================================================//          
  function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
  }

  //===================================================================================//
});


// ==================================================================================================
// ==================================================================================================


// ---------Responsive-navbar-active-animation-----------
function test() {
  var tabsNewAnim = $('#navbarSupportedContent');
  var activeItemNewAnim = tabsNewAnim.find('.active');
  
  // Check if the activeItemNewAnim element exists
  if (activeItemNewAnim.length > 0) {
      var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
      var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
      var itemPosNewAnimTop = activeItemNewAnim.position();
      var itemPosNewAnimLeft = activeItemNewAnim.position();
      
      $(".hori-selector").css({
          "top": itemPosNewAnimTop.top + "px",
          "left": itemPosNewAnimLeft.left + "px",
          "height": activeWidthNewAnimHeight + "px",
          "width": activeWidthNewAnimWidth + "px"
      });
  }
  
  $("#navbarSupportedContent").on("click", "li", function (e) {
      $('#navbarSupportedContent ul li').removeClass("active");
      $(this).addClass('active');
      
      // Check if the clicked element exists
      if ($(this).length > 0) {
          var activeWidthNewAnimHeight = $(this).innerHeight();
          var activeWidthNewAnimWidth = $(this).innerWidth();
          var itemPosNewAnimTop = $(this).position();
          var itemPosNewAnimLeft = $(this).position();
          
          $(".hori-selector").css({
              "top": itemPosNewAnimTop.top + "px",
              "left": itemPosNewAnimLeft.left + "px",
              "height": activeWidthNewAnimHeight + "px",
              "width": activeWidthNewAnimWidth + "px"
          });
      }
  });
}

$(document).ready(function(){
setTimeout(function(){ test(); });
});
$(window).on('resize', function(){
setTimeout(function(){ test(); }, 500);
});
$(".navbar-toggler").click(function(){
$(".navbar-collapse").slideToggle(300);
setTimeout(function(){ test(); });
});














// AGENDA ==========================

const pointerScroll = (elem) => {
  let isDrag = false;
  let startX;

  const dragStart = (ev) => {
    isDrag = true;
    startX = ev.type.includes('mouse') ? ev.pageX : ev.touches[0].pageX;
    elem.classList.add('dragging');
  };

  const dragEnd = () => {
    isDrag = false;
    elem.classList.remove('dragging');
  };

  const drag = (ev) => {
    if (!isDrag) return;
    const x = ev.type.includes('mouse') ? ev.pageX : ev.touches[0].pageX;
    elem.scrollLeft -= (x - startX);
    startX = x;
  };

  elem.addEventListener("mousedown", dragStart);
  elem.addEventListener("touchstart", dragStart);
  document.addEventListener("mouseup", dragEnd);
  document.addEventListener("touchend", dragEnd);
  document.addEventListener("mousemove", drag);
  document.addEventListener("touchmove", drag);
};

document.querySelectorAll(".scroll").forEach(pointerScroll);

const images = document.querySelectorAll('.speaker_image img');

images.forEach(img => {
    img.addEventListener('mousedown', (e) => {
        e.preventDefault();
    });
});



// ANIMATION NAV BAR + SCROLL TO SECTION + BACK TO TOP BUTTON
// ANIMATION NAV BAR + SCROLL TO SECTION + BACK TO TOP BUTTON
// ANIMATION NAV BAR + SCROLL TO SECTION + BACK TO TOP BUTTON
// ANIMATION NAV BAR + SCROLL TO SECTION + BACK TO TOP BUTTON



document.addEventListener('DOMContentLoaded', () => {
  const navbar = document.querySelector('#navbar .nav_container');
  const links = document.querySelectorAll('#navbar ul li a');
  const background = document.querySelector('.background');
  const sections = document.querySelectorAll('section');
  const headerContainer = document.getElementById('header_container');
  const backToTopButton = document.getElementById('backToTop');
  const nav_container = document.querySelector('.nav_container');
  const nav_logos = document.querySelectorAll('.logo');
  const nav_links = document.querySelectorAll('.nav_container ul li');
  const navbar_toggler = document.querySelector('.navbar_toggler');
  const navcontent = document.getElementById('nav_content');
  const body = document.querySelector('body');
  const navLinks = document.querySelectorAll('#nav_content li a');

  let isScrolling = false;
  let scrollTimeout = null;
  let total_logo_width = 0;
  let total_link_width = 0;

  background.classList.add('background');
  navbar.appendChild(background);

  nav_logos.forEach(function (logo) {
    total_logo_width += logo.offsetWidth;
  });

  nav_links.forEach(function (link) {
    total_link_width += link.offsetWidth;
  });

  function isDesktopMode() {
    return nav_container.offsetWidth > total_logo_width + total_link_width + 200;
  }

  function updateNavContainer() {
    if (isDesktopMode()) {
      nav_container.classList.remove('mobile');
    } else {
      nav_container.classList.add('mobile');
    }
  }

  function hideBackground() {
    background.style.width = '0';
    links.forEach(l => l.classList.remove('active'));
  }

  updateNavContainer();

  window.addEventListener('resize', () => {
    updateNavContainer();
    hideBackground();
  });

  function handleLinkClick(event) {
    if (isDesktopMode()) {
      isScrolling = true;

      const rect = this.getBoundingClientRect();
      const navbarRect = navbar.getBoundingClientRect();
      background.style.width = `${rect.width}px`;
      background.style.left = `${rect.left - navbarRect.left}px`;
      background.style.top = `${rect.top - navbarRect.top}px`;
      background.style.height = `${rect.height}px`;

      links.forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      const targetId = this.getAttribute('href').substring(1);
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - navbar.offsetHeight,
          behavior: 'smooth'
        });
      }
    } else {
      navLinks.forEach(link => {
        link.classList.remove('active');
      });
      this.classList.add('active');
      navbar_toggler.classList.remove('active_btn');
      navcontent.classList.remove('active_navbar');
      body.classList.remove('overflow-hidden');
    }
  }

  links.forEach(link => {
    link.addEventListener('click', handleLinkClick);
  });

  window.addEventListener('scroll', () => {
    if (isScrolling) {
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        isScrolling = false;
      }, 100); // Adjust timeout duration as needed
      return;
    }
  
    let currentSection = null;
    const offsetTrigger = 250;
  
    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      if (pageYOffset >= sectionTop - navbar.offsetHeight - offsetTrigger) {
        currentSection = section;
      }
    });
  
    if (backToTopButton) {
      if (window.pageYOffset > 300) {
        backToTopButton.classList.add('show');
      } else {
        backToTopButton.classList.remove('show');
      }
    }
  
    const headerRect = headerContainer.getBoundingClientRect();
    if (pageYOffset < headerContainer.offsetHeight) {
      background.style.width = '0';
      links.forEach(l => l.classList.remove('active'));
      return;
    }
  
    if (currentSection && isDesktopMode()) {
      const sectionId = currentSection.id;
      const selector = `#navbar ul li a[href*="#${sectionId}"]`;
      const activeLink = document.querySelector(selector);
  
      if (activeLink) {
        const rect = activeLink.getBoundingClientRect();
        const navbarRect = navbar.getBoundingClientRect();
        background.style.width = `${rect.width}px`;
        background.style.left = `${rect.left - navbarRect.left}px`;
        background.style.top = `${rect.top - navbarRect.top}px`;
        background.style.height = `${rect.height}px`;
  
        links.forEach(l => l.classList.remove('active'));
        activeLink.classList.add('active');
      }
    }
  });

  if(backToTopButton) {
    backToTopButton.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  if (navbar_toggler) {
    navbar_toggler.addEventListener('click', () => {
      navbar_toggler.classList.toggle('active_btn');
      navcontent.classList.toggle('active_navbar');
      body.classList.toggle('overflow-hidden');
    });
  } else {
    console.error('Navbar toggler not found');
  }
});