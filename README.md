# Autoškola
Autoskola prvni rady xd

## zadání
### PHP class

Importujte databázi ze souboru autoskola.sql.

Rozdělte si práci ve skupinách - každý vytvoří jednu z částí - auta nebo studenti nebo instruktori:
1. class s vlastnostmi dle polí databázové tabulky
- metodu nastavHodnoty - kontrola zadaných hodnot a nastavení vlastností (pokud kontrola zachytí neodpovídající hodnotu, např. text místo čísla nebo neodpovídající formát e-mailu apod., metoda vrátí false)
- metodu vypis - výpis vlastností objektu v article
- metodu vypisOptions - výpis názvu a id v option pro select
2. php stránku s formulářem pro zadávání dat 

### vložení do databáze
Pokračujte v projektu autoškola. 🗣️🗣️🗣️
Každý ke své datové třídě (auta, instruktori, studenti) vytvořte databázovou třídu (autaDB.php, instruktoriDB.php, studentiDB.php) s konstruktorem pro PDO připojení a funkcí pro provedení insert obdobně jako pro tabulku prispevky v databázi prispevky:

```php
class PrispevekDB{
    private $spojeni;

    private $databaze = "prispevky";
    private $uzivatel = "root";
    private $heslo = "";

    public function __construct(){
        //$this->spojeni = new PDO("mysql:dbname=Prispevky;charset=UTF8;host=localhost", "root", "");
        $this->spojeni = new PDO("mysql:dbname=$this->databaze;charset=UTF8;host=localhost", $this->uzivatel, $this->heslo);
    }

    public function vlozPrispevek($prispevek) {
        $dotaz = "insert into prispevky (id,nadpis,text,id_uzivatele) values (NULL,:nadpis,:text,:id_uzivatele)";
        $sql = $this->spojeni->prepare($dotaz);
        $sql->bindParam(":nadpis", $prispevek->nadpis);
        $sql->bindParam(":text", $prispevek->text);
        $sql->bindParam(":id_uzivatele", $prispevek->id_uzivatele);

        if($sql->execute()){return $this->spojeni->lastInsertId();}  //vrací id právě vloženého záznamu
        else {return false;}
    }
}
```

Pokračujte v souboru s formulářem, v němž jste si minule nastavili objekt dle odeslaných dat. Zavolejte metodu pro vložení a tento objekt použijte jako její parametr:

```php
<h1> Příspěvky - vložení do databáze </h1>
<?php
  if(isset($_POST["ulozit"])) {     //formulář byl odeslán
    include_once "class_db/Prispevek.php";
    include_once "class_db/PrispevekDB.php";

    $prispevek = new Prispevek();   //vytvoření datového objektu
    $prispevek->nastavHodnoty($_POST["nadpis"],$_POST["text"],$_POST["datum"]);  //nastavení vlastností objektu hodnotami formuláře

    $db = new PrispevekDB();        //vytvoření spojení s databází
    $id = $db->vlozPrispevek($prispevek);   //předání datového objektu databázové metodě vložení - ta vrací id vloženého záznamu nebo false
    if($id > 0){echo "<h2>Data byla vložena</h2>\n"; }
    else {echo "<h2>Data nebyla vložena</h2>\n";}
  }
  //formulář
?>
```

### načtení z databáze
Pokračujte v projektu autoškola. !!!

Každý ve své databázové třídě přidejte metody pro:
načtení všech záznamů s parametrem pro řazení (s přednastavenou vhodnou výchozí hodnotou)
načtení jednoho záznamu s parametrem id
V datové třídě přidejte metody pro:
zobrazení vlastností objektu ve vhodné html struktuře v article, vhodně nastylované
vytvoření položek option s value id a vhodným názvem, vhodně seřazené (např. abecedně)

Po vykonání dotazu select např, z tabulky načteme záznamy pomocí:
```php
$sql->setFetchMode(PDO::FETCH_CLASS, "Auta");
return $sql->fetchAll(); //vrátí pole objektů třídy Auta
```

Načítáme-li jeden záznam, pak použijeme:
```php
$sql->setFetchMode(PDO::FETCH_CLASS, "Auta");
return $sql->fetch();   //vrátí objekt třídy Auta
```

### jízdy
Pokračujte v projektu Autoškola.

Vytvořte třídy pro tabulku jizdy.
Vytvořte formulář pro zadání jízdy:
select s option s value id_studenta a zobrazeným příjmení a jménem studenta (první optin bude mít value="" a &nbsp; jako text)
select s option s value id_instruktora a zobrazeným příjmení a jménem instruktora
select s option s value id_auta a zobrazením poznacaci_znacka, znacka a model
input datetime pro zacatek
input datetime pro zacatek
inputy radio p-plánovaná, u-ukončená, z-zrušená

Po odeslání se vytvoří objekt, v metodě pro nastavení hodnot se provede kontrola regulárními výrazy, objekt bude předán metodě pro vložení do tabulky. Vypíše se zpráva a vložený záznam jízdy se načte a pomocí metody vypíše ve strukturovaném html.

### výpis administrativa
Pokračujte v projektu Autoškola.

Každý z týmu vypracujte načtení všech záznamů z jedné z tabulek, společně pak vytvořte načtení jízd, kde použijte select s join připojených tabulek, abyste ve výpisu měli jména žáka, instruktora, název a poznávací značku auta atd.

V datové třídě vytvořte metodu pro načtení všech záznamů s možností řazení (možnosti musé být ověřeny pomocí pole).
Dále vytvořte metodu pro načtení jednoho záznamu podle id.

V datové třídě vytvořte metody pro výpis a pro výpis s odkazy na smazání a editaci, kde se v odkazu předá id záznamu.

Společně vypracujte výpis administrace jízd. Přidejte možnost řazení výpisu kliknutím na odkaz (od nejstarších, od nejnovějších, podle jmen studentů, podle jmen instruktorů, podle značky auta apod.)

### mazání
Pokračujte v projektu Autoškola.

Každý v týmu přidejte do své databázové třídy metodu pro smazání záznamu určeného pomocí id.

Vytvořte php stránku smazani-trida.php, na níž se přejde z administračního výpisu a která vypíše záznam s daným id a formulář s tlačítkem pro smazání. Po kliknutí na tlačítko se provede smazání záznamu.

Společně vypracujte smazání jízdy.