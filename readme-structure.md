[Tillbaka](README.md)

## Exempel på mappstruktur i en vanlig applikation

En mapp som inled med ett understreck indikerar ofta att det är en mapp som inte allmänt ska vara känd - endast till för programmeraren...

```
    public
        index.php
        home.php
        sample.php
        _includes
            header.php
            footer.php
            nav.php
            functions.php
        images
        styles
            style.css
```

## PHP includes

Inkludera en fil med ett nyckelord som *include*. Det finns olika alternativ att inkludera filer - https://www.php.net/manual/en/function.include.php


Ex:

`include "_include/functions.php`

---