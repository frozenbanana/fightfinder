[Tillbaka](README.md)

## Kommando för att beskriva en struktur

En tabell som finns i en databas kan beskrivas (skapas) utifrån en speciell syntax.

I pmpMyAdmin, ge kommandot `SHOW CREATE TABLE` följt av tabellens namn, ex

`SHOW CREATE TABLE spring_sign`

Se till att hela resultatet presenteras (anges under options). Exempel på resultat:

```sql
CREATE TABLE `spring_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
```



## SQL exempel

```php
// visa info om databasen...
$sql = "SELECT VERSION()";

// kör fråga med pdo koppling
$query = $pdo->query($sql);
$row = $query->fetch();

print_r2($row);
```

---


### SELECT

Med nyckelordet SELECT data hämtas. 

```sql
-- hämta allt med *
$sql = "SELECT * FROM `spring_sign` WHERE id >= 1";

-- välj vissa kolumner
$sql = "SELECT description FROM `spring_sign` WHERE id >= 1";

-- ändra ordning efter en viss kolumn: ASC / DESC (ascending, descending - stigande och fallande ordning)
$sql = "SELECT * FROM `spring_sign` WHERE id >= 1 ORDER BY description DESC";

-- ett unikt id
$sql = "SELECT * FROM `spring_sign` WHERE id = 2";

-- en del av en text sträng
$sql = "SELECT * FROM `spring_sign` WHERE description LIKE '%umlor%'";
```

Exempel på att använda PDO - PHP Data Objects - för att hämta data med SQL *SELECT*. 


- PDO::fetch() - hämta en rad av data 
- PDO::fetchAll() - hämta flera rader av data 

#### PDO::query - SQL utan platshållare 

```php
// PDO::query 
// prepares and executes SQL statement without placeholder 
$sql = "SELECT * FROM `spring_sign` WHERE id = 1";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

print_r($rows);
```

#### PDO::prepare - SQL med frågetecken som platshållare

```php
$id = 1;

// PDO::prepare 
// prepares a statement with a placeholder using a question mark
$sql = "SELECT * FROM `spring_sign` WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id);
$rows = $stmt->fetchAll();

print_r($rows);
```

#### PDO::prepare - SQL med namngivna platshållare

```php
$id = 1;

// PDO::prepare 
// prepares a statement with named placeholder  - starts with a colon :
$sql = "SELECT * FROM `spring_sign` WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$rows = $stmt->fetchAll();

print_r($rows);
```

#### PDO::prepare - SQL med namngivna platshållare och kontroll av variabel

```php
// PDO::prepare 
// prepares a statement with named placeholder 
// using bindValue to make sure data type is correct
$sql = "SELECT * FROM `spring_sign` WHERE id = :id";
$stmt = $pdo->prepare($sql);

// use bindValue
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

print_r2($rows);
```

---


### SQL INSERT

Med SQL INSERT läggs ny data in i en tabell.

Exempelkod

```php

$description = "Vårvärmen!";

// SQL syntax för att spara data  - obs - se platsållare nedan (bättre alternativ) 
$sql = "INSERT INTO `spring_sign` (`description`) VALUES ('$description')";
$result = $pdo->exec($sql);

// exempel på att använda namngiven platshållare för variabler
$sql = "INSERT INTO `spring_sign` (`description`) VALUES (:description)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue('description', $description, PDO::PARAM_STR);
$result = $stmt->execute();

```

---




### SQL UPDATE

Ett formulär skapas för att möjliggöra uppdatering. För att uppdatera en post används ofta ett input fält som är dolt för postens id. 

```php
<input type="hidden" name="id" value="<?= $id ?>">
```

Validera variabler som ska användas.


```php

$description = $_POST['description'];
$date = $_POST['date'];
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// ev annan validering...

// uppdatera med namngiven platshållare för variabler
$sql = "UPDATE `spring_sign` SET `description` = :description, `date` = :date WHERE `id` = :id";
$stmt = $pdo->prepare($sql);

// bind värden - koppla platshållare till variabler
$stmt->bindValue('description', $description, PDO::PARAM_STR);
$stmt->bindValue('date', $date, PDO::PARAM_STR);
$stmt->bindValue('id', $id, PDO::PARAM_INT);

$result = $stmt->execute();

```



### SQL DELETE

Loren ipsum...


---
---
---


## SQL injections

![Bobby tables](screens/bobby-tables.png)

OBS - var medveten om att med SQL kan äventyra en hel databas med dess innehåll - *SQL injections*

Följande kommando raderar en namngiven tabell (tabellen och innehållet försvinner)

`DROP TABLE spring_sign`

I SQL kan en extra instruktion skrivas, i koden nedan väljs viss data ut ... varpå allt innehåll inklusive tabellen är ett minne blott... 

```php
$sql = "SELECT * FROM `spring_sign` WHERE description LIKE '%umlor%' OR DROP TABLE spring_sign";
```


Vad händer om man som programmerare missar SQL injections ett formulärfält där ngn kan ange ngt...
...och ngn anger ett extra SQL kommando, med semikolon ges en ny instruktion till metoden exec()

```php
$description = "14; DROP TABLE spring_sign";
$sql = "SELECT * FROM `spring_sign` WHERE id = $description";
$result = $pdo->exec($sql); 
// ... tabellen och allt innehåll raderat...   
```


För att förhindra den här typen av kod används prepared statements - platshållare

---
