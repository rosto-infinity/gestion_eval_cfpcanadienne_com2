<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Exports PDF</title>
  <style>
    /* Style général */
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      color: #333;
    }

    /* En-tête */
    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h1 {
      font-size: 24px;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .header p {
      font-size: 14px;
      color: #7f8c8d;
    }

    /* Section Total */
    .total {
      background-color: #ecf0f1;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      font-size: 16px;
      color: #34495e;
    }

    /* Tableau */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table th, table td {
      padding: 12px;
      text-align: left;
    }

    table th {
      background-color: #3498db;
      color: white;
      font-weight: bold;
    }

    table tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    table tr:hover {
      background-color: #f1f1f1;
    }

    /* Pied de page (optionnel) */
    .footer {
      text-align: center;
      margin-top: 30px;
      font-size: 12px;
      color: #7f8c8d;
    }
  </style>
</head>
<body>
   <div class="header">
    <h1>Inventaires des Produits</h1>
    <p>Généré le : {{ $date }}</p>
   </div>

   <div class="total">
    Total des produits : {{ $products->count() }} <br>
    Valeur totale de l'inventaire : {{ $totalValue }} CFA
   </div>

   <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->category}}</td>
                <td>{{ $product->price }} CFA</td>
            </tr>
            @endforeach
        </tbody>
   </table>

   <!-- Pied de page optionnel -->
   <div class="footer">
    Document généré automatiquement par le système
   </div>
</body>
</html>
