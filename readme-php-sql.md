[Tillbaka](README.md)

## SQL - PHP

Kod för att koppla en databas till aplikationen

```php
$host = "mysql";
$database = "db_learn";
$user = "db_user";
$passw = "db_password";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $passw);
} catch (PDOException $e) {
    echo "Database connection exception $e";
}
```

Instruktionen för att koppla till en databas kan med fördel placeras i en egen fil, ex med ett namn som  *database.php*