<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #868686;
            border-radius: 4px;
        }

        .contact-info {
            color: #fa9a33;
        }
    </style>

    <title>Mensaje de Contacto Buro Tributario</title>
</head>

<body>
    <div class="container">
        <h1 class="contact-info">Mensaje de Contacto Buro Tributario</h1>
        <p>Este es el mensaje y el remitente:</p>
        <br>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Subject:</strong> {{ $subject }}</p>
        <p><strong>Message:</strong> {{ $mensaje }}</p> <a type="button" href="{{ url('/') }}" class="button">Ir a Buro Tributario...</a>
    </div>
</body>

</html>
