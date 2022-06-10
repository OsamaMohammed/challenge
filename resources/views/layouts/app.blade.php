<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=720, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CSS Style Sheets --}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    
    <title>TheRemoteWork - Challenge</title>
</head>
<body>
    <div id="app" class="container">
        <b-navbar>
            <template #brand>
                <b-navbar-item href="/">
                    <img
                        src="https://www.remotecompany.com/assets/remote-company-logo.svg"
                        alt="Osamah S. Mohammed"
                    >
                </b-navbar-item>
            </template>
            <template #start>
                <b-navbar-item href="/">
                    Home
                </b-navbar-item>
                <b-navbar-item href="/admin">
                    Admin
                </b-navbar-item>
            </template>
        </b-navbar>
        <div class="pt-6">@yield('content')</div>
    </div>
</body>
<script src="{{ mix('/js/app.js') }}"></script>
</html>