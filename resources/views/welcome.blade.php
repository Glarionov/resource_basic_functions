<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Notary appointments</title>

        <link rel="stylesheet" href="{{mix('/css/app.css')}}"/>
    </head>
    <body class="antialiased">
        <div id="app">
        </div>

        <script>
            {{--window.appointments = @json($appointments);--}}
            {{--window.appointmentTypes = @json($appointmentTypes);--}}
            {{--window.validatoinRules = @json($validationRules);--}}
        </script>

        <script src="{{mix('/js/app.js')}}"></script>

    </body>
</html>
