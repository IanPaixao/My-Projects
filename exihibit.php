<?php

require 'database.php';

// Definindo parâmetros da paginação
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Consultando dados da página atual
$sql = "SELECT * FROM clients LIMIT {$per_page} OFFSET {$offset}";
$result = $db->query($sql);

if ($result->num_rows === 0) {
  echo "Nenhum cliente encontrado.";
  exit;
}

$clients = [];
while ($row = $result->fetch_assoc()) {
  $clients[] = $row;
}

$result->close();

// Calculando o número total de páginas
$total_pages = ceil($db->query("SELECT COUNT(*) FROM clients")->fetch_row()[0] / $per_page);

// Gerando links de paginação
$pagination = '';
if ($page > 1) {
  $pagination .= '<a href="?page=1">&laquo; Início</a>';
}

for ($i = max(1, $page - 2); $i <= min($page + 2, $total_pages); $i++) {
  if ($i === $page) {
    $pagination .= '<span class="current">' . $i . '</span>';
  } else {
    $pagination .= '<a href="?page=' . $i . '">' . $i . '</a>';
  }
}

if ($page < $total_pages) {
  $pagination .= '<a href="?page=' . $total_pages . '">&raquo; Final</a>';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listagem de Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h1>Listagem de Clientes</h1>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Telefone</th>
          <th>Email</th>
          <th>Criado em</th>
          <th>Atualizado em</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clients as $client): ?>
          <tr>
            <td><?php echo $client['id']; ?></td>
            <td><?php echo $client['name']; ?></td>
            <td><?php echo $client['phone']; ?></td>
            <td><?php echo $client['email']; ?></td>
            <td><?php echo $client['created_at']; ?></td>
            <td><?php echo $client['updated_at']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination">
      <?php echo $pagination; ?>
    </div>
  </div>
</body>
</html>
