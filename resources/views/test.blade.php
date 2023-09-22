<!DOCTYPE html>
<html>

<head>
    <title> Bootstrap wysiwyg Example </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width= device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    {{-- @include('partials.panel.styles') --}}



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link href="{{ asset('assets/css/wysiwyg.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/wysiwyg.js') }}"></script>
</head>

<body>


    <textarea id="privacy_policy_en">
    </textarea>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#privacy_policy_en').wysiwyg({});
        });
    </script>
</body>

</html>
