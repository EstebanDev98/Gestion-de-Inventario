<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Insumos</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Reporte de Insumos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Código de Referencia</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($insumos as $insumo)
                <tr>
                    <td>{{ $insumo->nombre }}</td>
                    <td>{{ $insumo->codigo_referencia }}</td>
                    <td>{{ $insumo->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
