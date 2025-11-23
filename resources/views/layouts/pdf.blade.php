<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document PDF')</title>
    <style>
        @page {
            margin: 2cm;
            size: landscape;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
        }
        
        /* Correction pour les polices dans DomPDF */
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/DejaVuSans.ttf') }}) format('truetype');
        }
        
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: bold;
            font-weight: bold;
            src: url({{ storage_path('fonts/DejaVuSans-Bold.ttf') }}) format('truetype');
        }
        
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: italic;
            font-weight: normal;
            src: url({{ storage_path('fonts/DejaVuSans-Oblique.ttf') }}) format('truetype');
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>