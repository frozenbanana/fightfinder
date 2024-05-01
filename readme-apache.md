[Tillbaka](README.md)

## Apache .htaccess

I en PHP Apache server finns det möjighet att använda en typ av fil som kallas för *.htaccess*. Den filen kan bland annat ange att en katalog ska kunna lista innheållet utan att det finns en förvald index fil (ex index.php)

https://httpd.apache.org/docs/2.4/howto/htaccess.html


Skapa en fil i katalogen med namnet *.htaccess*

För att visa filer och mappar anges följande i filen:

---

*.htaccess*

`Options +Indexes`;

---


Eftersom det ofta är en mkt dålig att visa en mapps innehåll enlig direktivet ovan, så se till att inte köra raden. Inled med tecken #

---

*.htaccess*

`# Options +Indexes`;

---