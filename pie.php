<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {

            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
        }

        .footer {
            background-color: green;
            color: white;
            padding: 14px;
            text-align: center;
            backdrop-filter: blur(7px);
        }

        @media only screen and (max-width: 600px) {
            .footer {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="content">

    </div>

    <div class="footer">
        Todos los derechos reservados
    </div>
</body>



</html>