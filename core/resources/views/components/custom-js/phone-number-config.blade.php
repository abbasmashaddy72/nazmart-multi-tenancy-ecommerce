@props([
    'selector' => '#telephone',
    'submitButtonId' => 'register_button'
])

<link rel="stylesheet" href="{{asset('assets/common/css/intlTelInput.min.css')}}">
<style>
    #telephone.error{
        border-color: var(--main-color-one);
    }
    #telephone.success{
        border-color: var(--main-color-three);
    }
    .single-input .iti {
        width: 100%;
    }
</style>

<script src="{{asset('assets/common/js/intlTelInput.js')}}"></script>
<script>
    let input = document.querySelector(`{{$selector}}`);

    let iti = window.intlTelInput(input, {
        autoPlaceholder: "aggressive",
        // autoPlaceholder: "off",
        // formatOnDisplay: false,
        // initialCountry: "auto",
        // localizedCountries: { 'de': 'Deutschland' },
        excludeCountries: ["il"],
        separateDialCode: true,
        utilsScript: `{{asset("assets/common/js/utils.js")}}`
    });

    $(document).on('keyup', `{{$selector}}`, function () {
        let el = $(this);
        let inputNumbers = el.val();

        let phoneNumbers = inputNumbers.replace(/[^0-9+]/g, '');
        el.val(phoneNumbers);

        $('.error-text').remove();

        let isValid = iti.isValidNumber();
        if (!isValid) {
            el.addClass('error');
            el.parent().after(`<p class="text-end text-danger error-text"><small>{{__('The number is not valid.')}}</small></p>`);
            document.getElementById(`{{$submitButtonId}}`).disabled = true;
        } else {
            el.removeClass('error');
            el.addClass('success');
            el.parent().after(`<p class="text-end text-success error-text"><small>{{__('The number is perfect.')}}</small></p>`);
            setTimeout(function () {
                el.removeClass('success');
                $('.error-text').remove();
            }, 5000);
            document.getElementById(`{{$submitButtonId}}`).disabled = false;
        }
    });
</script>
