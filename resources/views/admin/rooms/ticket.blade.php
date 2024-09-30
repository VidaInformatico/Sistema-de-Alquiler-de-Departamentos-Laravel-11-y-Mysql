<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 180pt;
            padding: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        body {
            padding: 5px;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 5mm;
        }

        .header img {
            width: 50mm;
        }

        .section {
            margin-bottom: 5mm;
        }

        .section h2 {
            font-size: 14px;
            margin: 0;
        }

        .section p {
            margin: 2px 0;
        }

        .line {
            border-top: 1px solid #000;
            margin: 5mm 0;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="header">
            {{-- <img src="{{ public_path('logo.png') }}" alt="Logo"> --}}
            <h4>Nombre de la Empresa</h4>
            <br>
            <p>Dirección de la Empresa</p>
            <p>Teléfono: (123) 456-7890</p>
            <p>Fecha: {{ $payment->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="section">
            <h2>Propiedad</h2>
            <p><strong>Nombre:</strong> {{$payment->rent->room->property->name}}</p>
            <p><strong>Cuidad:</strong> {{$payment->rent->room->property->city}}</p>
            <p><strong>Dirección:</strong> {{$payment->rent->room->property->address}}</p>
        </div>

        <div class="section">
            <h2>Alquiler</h2>
            <p><strong>Fecha de Inicio:</strong> {{ $payment->rent->created_at->format('d/m/Y') }}</p>
            <p><strong>Fecha de Fin:</strong> {{ $payment->rent->created_at->format('d/m/Y') }}</p>
            <p><strong>Monto:</strong> {{ number_format($payment->rent->room->rentalprice, 2) }}</p>
        </div>

        <div class="section">
            <h2>Pago</h2>
            <p><strong>Fecha de Pago:</strong> {{ $payment->created_at->format('d/m/Y') }}</p>
            <p><strong>Monto:</strong> {{ number_format($payment->amount, 2) }}</p>
        </div>

        <div class="line"></div>

        <div class="footer">
            <p>Gracias por su pago</p>
            <p>Visite nuestro sitio web: <a href="http://www.ejemplo.com">www.ejemplo.com</a></p>
        </div>
    </div>
</body>

</html>
