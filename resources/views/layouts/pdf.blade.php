<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        body {
            font-family: DejaVu Sans;
        }

        .page-break { page-break-after: always; }

        .clearfix::after {
            content: "";
            clear: both;
            display: block;
        }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')
</body>
</html>
