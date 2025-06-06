<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Préstamos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e5e5e5;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Reporte de Préstamos</h2>
    <table>
        <thead>
            <tr>
                <th>Insumo</th>
                <th>Fecha de Préstamo</th>
                <th>Fecha de Devolución</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->insumo->nombre ?? 'N/A' }}</td>
                    <td>{{ $prestamo->fecha_prestamo }}</td>
                    <td>{{ $prestamo->fecha_devolucion ?? 'Pendiente' }}</td>
                    <td>{{ $prestamo->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
