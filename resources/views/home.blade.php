<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rick and Morty</title>
    </head>
    <body>
        <form action="{{ route('pdf.characters') }}" method="POST">
            @csrf
            <button type="submit">Скачать pdf</button>
        </form>
    </body>
</html>
