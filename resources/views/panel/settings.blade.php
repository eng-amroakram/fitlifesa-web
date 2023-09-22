<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <title>{{ __('Fitlife') }} - {{ __('Settings') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link href="{{ asset('assets/css/wysiwyg.css') }} " rel="stylesheet" />
    <script src="{{ asset('assets/js/wysiwyg.js') }}"></script>
    @livewireStyles

</head>

<body>
    <main style="margin-top: 58px;">
        <div id="removecontainerpadding" class="container-fluid">
            <section class="mb-4" style="height:650px;">
                <div class="card-header py-5">
                    <div class="container-fluid" style="margin: 20px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('panel.home') }}"
                                        class="text-dark fw-bold fs-6">{{ __('Back To Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page"><a href="#"
                                        class="text-dark  fs-6">{{ __('Settings') }}</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                @livewire('settings')

            </section>
        </div>
    </main>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#privacy_policy_en').wysiwyg({});
            $('#privacy_policy_ar').wysiwyg({});
            $('#terms_service_en').wysiwyg({});
            $('#terms_service_ar').wysiwyg({});
            $('#about_us_en').wysiwyg({});
            $('#about_us_ar').wysiwyg({});
        });
    </script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>


    <x-livewire-alert::scripts />

    @livewireScripts()

    <script>
        $(document).ready(function() {
            var myDiv = document.getElementById('customremoveinputgroup');
            var containerDiv = document.getElementById('removecontainerpadding');
            if (window.innerWidth <= 767) {
                myDiv.classList.remove('input-group');
            } else {
                myDiv.classList.add('input-group');
            }

            window.addEventListener('resize', function() {
                var myDiv = document.getElementById('customremoveinputgroup');
                var containerDiv = document.getElementById('removecontainerpadding');
                if (window.innerWidth <= 767) {
                    myDiv.classList.remove('input-group');
                } else {
                    myDiv.classList.add('input-group');
                }
            });

        });
    </script>

</body>

</html>
