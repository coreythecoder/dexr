$(document).ready(function () {

    $("#subject").keyup(function () {
        var subval = $("#subject").val();
        subval = subval.toLowerCase().replace(/\b[a-z]/g, function (letter) {
            return letter.toUpperCase();
        });
        $("#prev_subject").html(subval);
    });

    $("#body").keyup(function () {
        var bodval = $("#body").val();
        $("#prev_body").html(bodval);
    });

    $('a').click(function () {
        if ($(this).attr('target') !== '_blank' && !$(this).hasClass('noThinker')) {
            $('#thinker').modal('show');
        }
        ;
    });

    $('button').click(function () {
        if (this.id == 'download_button') {
            setTimeout(function () {
                $('#thinker').modal('hide');
            }, 8000);

        }
    });

    $('a').click(function () {
        if ($(this).hasClass('download-button')) {
            setTimeout(function () {
                $('#thinker').modal('hide');
            }, 8000);
        }
    });

    $('form').submit(function () {
        if (!$(this).hasClass('noThinker')) {
            $('#editFilters').modal('hide');
            $('#thinker').modal('show');
        }
        ;
    });

    $('button').click(function () {
        if (!$(this).hasClass('noThinker')) {
            $('#thinker').modal('hide');
        }
        ;
    });

    $('input[name="daterange"]').daterangepicker();

    $("#daterangeTrue").change(function () {

        if ($("#daterangeTrue").prop('checked')) {
            $("#daterange").slideDown();
        } else {
            $("#daterange").slideUp();
        }
    });

    $("#saveDataset").on("click", function () {
        console.log("button click");
        if ($("#datasetInput").val().length > 0) {

            $('#createDataset').modal('hide');
            $('#form').submit();
        }
    });


    $(".add").on("click", function () {
        $("#added").append('<div class="row animated fadeInDown"><div class="col-md-5 text-center" style=""><select name="col[]" class="form-control"><option value="registrant_city">City</option><option value="registrant_state">State</option><option value="registrant_country">Country</option><option value="contactEmail">Email Address</option><option value="registrarName">Registrar</option><option value="registrant_name">Registrant Name (first & last)</option><option value="registrant_organization">Organization Name</option><option value="registrant_street1">Street Address</option><option value="registrant_postalCode">Zip Code</option><option value="phone">Phone</option></select></div><div class="col-md-2 text-center" style=""><select name="type[]" class="form-control"><option value="equals">Equals (exact)</option><option value="not_equals">Not Equals (exact)</option><option value="not_contains">Not Contains (regexp)</option></select></div><div class="col-md-5 text-center" style=""><input type="text" class="form-control" name="keyword[]" placeholder=""></div></div>');
    });

    $("#saveAutomate").on("click", function () {
        $("#automate-options").show();
    });

    $("#saveButton").on("click", function () {
        $("#automate-options").hide();
    });

    $(".panel").on("click", function () {
        if ($("#save-text").val() !== "") {

            $("#panel-email").on("click", function () {
                $("#hidden_campaign_type").val("email_redirect");
                $("#form").submit();
            });
            $("#panel-robo").on("click", function () {
                $("#hidden_campaign_type").val("robo_redirect");
                $("#form").submit();
            });
            $("#panel-sms").on("click", function () {
                $("#hidden_campaign_type").val("sms_redirect");
                $("#form").submit();
            });
            $("#panel-alarm").on("click", function () {
                $("#hidden_campaign_type").val("alarm_redirect");
                $("#form").submit();
            });


        } else {
            alert("Please provide a filter label.");
            $("#save-text").focus();
        }
    });

    $(function () {
        $('#userFilters').change(function () {
            if ($('#userFilters').val() !== "") {
                this.form.submit();
            }
        });
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(".zap-button").click(function () {
        var orig = $(this).html();
        $(this).html("<i class='fa fa-check'></i> Zap!");
    });

    $("#premium_payment_button").on("click", function () {
        $("#text").html("Please add a funding source to be used after your trial expires. Please cancel the subscription before your 7 day trial period expires to avoid any unwanted charges.");
        $("#type").val("premium");
        $("#savePaymentSource").html("Save & Start Trial Period");
    });

    $("#pro_payment_button").on("click", function () {
        $("#text").html("Your card will be charged immediately for $250 and will be a recurring charge on the same day of the month, each month. To cancel your subscription, sign in, visit the \"My Account\" section and click \"Cancel\" next to the subscription you'd like to cancel.");
        $("#type").val("pro");
        $("#savePaymentSource").html("Pay $250 Now");
    });

});

function zap(uid, recordID, zapID, tableID) {
    $.getJSON('/zap/' + uid + '/' + recordID + '/' + zapID + '/' + tableID, function (data) {
        console.log(data);
    });
}
;


// Create a Stripe client.
var stripe = Stripe('pk_live_eBC8PoJVsc1ID70rOlsKkllM');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function (event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {
    event.preventDefault();

    stripe.createToken(card).then(function (result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
