<?php
require __DIR__ . '/vendor/autoload.php';

if ($argc != 2) {
    echo "Uso: php csv-generator.php [total-linhas]\n";
    exit(1);
}

function generatecsv(int $totalRows)
{
    $faker = fake('pt_BR');

    $csv = fopen('contacts.csv', 'w');
    fputcsv($csv, ['nome', 'contato']);
    for ($i = 0; $i < $totalRows; $i++) {
        $isPrime = $i % 2 === 0;
        $contact = $isPrime ? $faker->phoneNumber : $faker->email;
        fputcsv($csv, [sprintf('%s', $faker->name), sprintf('%s', $contact)]);
    }
    fclose($csv);
}
$totalRows = $argv[1];

generatecsv($totalRows);
