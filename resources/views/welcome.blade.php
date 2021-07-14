<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link href = "{{ asset('css/style.css') }}" rel = "stylesheet">
    <script src = "{{ asset('js/app.js')}}" defer></script>
    <title>Document</title>
</head>

<body>
<div id = "app">
    <div id = "overlay" @click = "closeModal"></div>
    <App :active-modal = "modal"></App>
</div>
</body>

</html>
