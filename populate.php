<?php
//Código PHP para popular a tabela com dados falsos:
require 'database.php';

$faker = Faker\Factory::create('pt_BR');
// laço de repetição para a inserção de 120 dados no banco
for ($i = 0; $i < 120; $i++) {
  $name = $faker->name;
  $phone = $faker->phoneNumber;
  $email = $faker->email;

  $sql = "INSERT INTO clients (name, phone, email) VALUES (?, ?, ?)";
  $stmt = $db->prepare($sql);
  $stmt->bind_param('sss', $name, $phone, $email);
  $stmt->execute();

  if ($stmt->error) {
    echo "Error: " . $stmt->error;
    exit;
  }
}

$stmt->close();
$db->close();
?>
