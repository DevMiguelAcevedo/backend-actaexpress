<!DOCTYPE html>
<html>

<head>
    <title>Bienvenido a ActasExpress</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a ActasExpress!</h1>
        </div>

        <div class="content">
            <p>Hola {{ $user->name }},</p>
            <p>Tu registro ha sido exitoso con el rol de: <strong>{{ implode(', ', $user->roles) }}</strong>.</p>

            <h3>Tus credenciales:</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Contraseña temporal:</strong> {{ $password }}</p>

            <p>Por seguridad, te recomendamos cambiar tu contraseña después de iniciar sesión.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} ActasExpress. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>