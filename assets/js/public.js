jQuery(document).ready(function($){

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;
    var form = $("#msform");

    //console.log( steps );
    
    setProgressBar(current);
    
    $(".next").click(function(){
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        form.validate({
			rules: {
				"f_name": {
					required: true,
                },
                "other[email]": {
                    required: true
                },
                "address": {
                    required: true
                },
                "city": {
                    required: true
                },
                "state": {
                    required: true
                },
                "zipcode": {
                    required: true
                },
                "contact[c_phone]": {
                    require_from_group: [1, ".phone-grp"]
                },
				"contact[h_phone]": {
					require_from_group: [1, ".phone-grp"]
				},
                "other[ss_number]": {
                    required: true
                },
                "other[dob]": {
                    required: true
                },
                "emergency_contact[em_contact_1][name]": {
                    required: true
                },
                "emergency_contact[em_contact_1][relation]": {
                    required: true
                },
                "emergency_contact[em_contact_1][address]": {
                    required: true
                },
                "emergency_contact[em_contact_1][city]": {
                    required: true
                },
                "emergency_contact[em_contact_1][state]": {
                    required: true
                },
                "emergency_contact[em_contact_1][zipcode]": {
                    required: true
                },
                "emergency_contact[em_contact_1][phone]": {
                    required: true
                },
                "Name": {
                    required: true
                },
                "signature[app_1][signature]": {
                    required: true
                },
                "drivers_id": {
                    required: true
                },
                "proof_of_income": {
                    required: true
                },
                "miscellaneous[convicted_felony]": {
                    required: true
                },
                "miscellaneous[evicted]": {
                    required: true
                },
                "miscellaneous[explain]": {
					required: '.miscellaneous[value="Y"]:checked'
                },
                "miscellaneous[explain]": {
                  required: '.miscellaneous[value="Y"]:checked'  
               },
                "emp_history[app_1][cur_emp]": {
                    required: true
                },
                "emp_history[app_1][address]": {
                    required: true
                },
                "emp_history[app_1][city]": {
                    required: true
                },
                "emp_history[app_1][state]": {
                    required: true
                },
                "emp_history[app_1][zipcode]": {
                    required: true
                },
                "emp_history[app_1][phone]": {
                    required: true
                },
                "emp_history[app_1][how_long]": {
                    required: true
                },
                "emp_history[app_1][paid]": {
                    required: true
                },
				"driver-license": {
					required: true
				},
				"drivers_id[]": {
					required: true
				},
				"proof_of_income[]": {
					required: true
				},
				"proof-of-income": {
					required: true
				},
                "pets[Y][no_pets]": {
                    required: true
                },
                "pets[Y][breed]": {
                    required: true
                },
                "pets[Y][desc]": {
                    required: true
                },
                "pets[Y][lbs]": {
                    required: true
                },
                "pet_image": {
                    required: true
                },
                "other[interested_in]": {
                    required: true
                },
                "other[how_many_people]": {
                    required: true
                }

			},
            focusInvalid: false,
                invalidHandler: function(form, validator) {

                    if (!validator.numberOfInvalids())
                        return;

                    $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top - 100
                    }, 1000);

                }
		});

         if (form.valid() == true){
            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            $("#applicant_1").val($("input[name='f_name']").val());

            if(isNaN($("input[name='second_applicant[f_name]']").val())){
                $("#applicant_2").val($("input[name='second_applicant[f_name]']").val());
                $(".sign-hide").show();
            }else{
                $(".sign-hide").hide();
            }
            
            if(current === 6){
                $(function() {
                    $("#driver_id_input").change(function() {
                        if (this.files && this.files[0]) {
                            var reader = new FileReader();
                            reader.onload = imageDriverIsLoaded;
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                });

                function imageDriverIsLoaded(e) {
                    $('#preview_id').css("display", "block");
                    $('#preview_id_img').attr('src', e.target.result);
                    // $('#drivers_id').attr('value', e.target.result);
                };
                
                $(function() {
                    $("#proof_id_input").change(function() {
                        if (this.files && this.files[0]) {
                            var reader = new FileReader();
                            reader.onload = imageProofIsLoaded;
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }); 

                function imageProofIsLoaded(e) {
                    $('#preview_proof').css("display", "block");
                    $('#preview_proof_img').attr('src', e.target.result);
                    // $('#proof_of_income').attr('value', e.target.result);
                };
            }

            if(current === 2){
                $(function() {
                    $("#pet_file").change(function() {
                        if (this.files && this.files[0]) {
                            var reader = new FileReader();
                            reader.onload = imageIsLoaded;
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }); 
                function imageIsLoaded(e) {
                    $('#preview').css("display", "block");
                    $('#previewimg').attr('src', e.target.result);
                    // $('#pet_image').attr('value', e.target.result);
                };
            }
            //if(current === 5){
                // Initialize jSignature
                var signaturePad = new SignaturePad(document.getElementById('signature_app1'));
                var signaturePad2 = new SignaturePad(document.getElementById('signature_app2'));

                $("input[name='certify']").change(function() {
                    if(this.checked) {
                        var data1 = signaturePad.toDataURL('image/png');
                        $("#signature1").attr("value",data1);

                        var data2 = signaturePad2.toDataURL('image/png');
                        $("#signature2").attr("value",data2);
                    }
                });

                // $("fieldset").on("click", ".sign-submit", function(){
                //     var data1 = signaturePad.toDataURL('image/png');
                //     $("#signature1").attr("value",data1);

                //     var data2 = signaturePad2.toDataURL('image/png');
                //     $("#signature2").attr("value",data2);
                // });
                    
                $("#clear_sign1").on("click", function(){
                    var canvas = document.getElementById("signature_app1");
                    var context = canvas.getContext('2d');
                    context.clearRect(0, 0, canvas.width, canvas.height);
                });

                $("#clear_sign2").on("click", function(){
                    var canvas = document.getElementById("signature_app2");
                    var context = canvas.getContext('2d');
                    context.clearRect(0, 0, canvas.width, canvas.height);
                });
            //}
            //show the next fieldset
            if(current === 7){
                var data = new FormData(this.form);
				next_fs.show();
                $.ajax({
                    url     : ra_data.ajax_url,
                    type    : 'POST',
                    processData: false,
                    contentType: false,
                    data    : data,
                    beforeSend: function(){
                        $("fieldset .submit-final").attr('disabled','disabled');
                        $("fieldset .submit-final").val('Sending...');
                    },
                    success : function(response){
                        var r = JSON.parse(response);
                        //console.log(r.url);
						
                        location.href = r.url;

                        
                    }
                });
            }else{
                next_fs.show();
            }

            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;
                    
                    current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(++current);

            $('html, body').animate({
                scrollTop: ($('#heading').offset().top - 100)
            }, 1000);
         }
    });
    
    $(".previous").click(function(){
    
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    
    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
        //show the previous fieldset
        previous_fs.show();
        
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });

                previous_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(curStep){
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width",percent+"%")
    }
    $("body").on("change", 'input[name="pets"]', function(){
        //console.log($(this).val());
        if($(this).val() === "Y"){
            $(".pet-opition").show();
			$('.action-button').attr('disabled', 'disabled');
        }else{
            $(".pet-opition").hide();
			$('.action-button').removeAttr('disabled');
        }
    });
	$("input[name='pets-deposit']").change(function() {
		if(this.checked) {
			$('.action-button').removeAttr('disabled');
		}else {
			$('.action-button').attr('disabled','disabled');
		}
	});
	$("input[name='driver-license']").change(function() {
		if(this.checked) {
			$('.driver-license-wrap').show();
		}else {
			$('.driver-license-wrap').hide();
		}
	});
	$("input[name='proof-of-income']").change(function() {
		if(this.checked) {
			$('.proof-of-income-wrap').show();
		}else {
			$('.proof-of-income-wrap').hide();
		}
	});
	$("input[name='certify']").change(function() {
		if(this.checked) {
			$('.action-button').removeAttr('disabled');
		}else {
			$('.action-button').attr('disabled','disabled');
		}
	});
});