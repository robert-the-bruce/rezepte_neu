<?php

if (isset($_POST['speichern'])) {

    $name = $_POST['name'];
    $anzahl = $_POST['anzahl'];

    $query = 'select zutat_has_einheit.zuei_id, concat_ws(" ", einheit.ein_name, zutat.zut_name ) from zutat_has_einheit natural join (zutat, einheit);';

    try {
        $stmt = $con->prepare($query);

        $stmt->execute();

        $einhzutat = [];

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $einhzutat[] = $row;
        }


    } catch (exception $e) {
        $e->getMessage();
    }

    ?>

    <form method="POST">
        <div class="container">
            <div class="ten column">
                <h3><?php echo $name ?></h3>
                <p>Wählen Sie die Zutaten und geben Sie die entsprechende Menge ein.</p>
                <?php for ($i = 0; $i < $anzahl; $i++) { ?>
                    <label for="menge">Zutat <?php echo $i + 1 ?>- Menge</label>
                    <input class="u-half-width" name="menge[]" type="number" id="menge">
                    <select name="einheitzutat[]">
                        <?php for ($j = 0; $j < sizeof($einhzutat); $j++) { ?>
                            <option value="<?php echo $einhzutat[$j][0] ?>"><?php echo $einhzutat[$j][1] ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>

                <label for="exampleMessage">Zubereitung</label>
                <textarea class="u-full-width" name="zubereitung" placeholder="Bitte Zubereitung eingeben..."
                          id="exampleMessage"></textarea>
                <input  name="name" value="<?php echo $name ?>" type="hidden">
                <input  name="anzahl" value="<?php echo $anzahl ?>" type="hidden">
                <input class="button-primary" name="entg_speichern" type="submit" value="speichern">
            </div>
        </div>
    </form>


    <?php

} elseif (isset($_POST['entg_speichern'])) {

$name = $_POST['name'];
$zubereitung = $_POST['zubereitung'];
$menge = $_POST['menge'];
$einheitzutat = $_POST['einheitzutat'];
$anzahl = $_POST['anzahl'];

    try {

        $query = 'Insert into rezept(rez_name) values(?);';

        $stmt = $con->prepare($query);

        $param = array($name);

        $stmt->execute($param);
        $lastID = $con->lastInsertId();

        $query  = 'Insert into zubereitung(zub_beschreibung, rez_id) value (?, ?);';

        $stmt = $con->prepare($query);

        $param = [$zubereitung, $lastID];

        $stmt->execute($param);
        $lastIDZubereitung = $con->lastInsertId();


        for($i = 0; $i < $anzahl; $i++) {
            $query = 'insert into zubereitung_has_zutat_has_einheit values(?, ?, ?)';
            $zubereitungeinheit = array($lastIDZubereitung, $einheitzutat[$i], $menge[$i]);

            $stmt = $con->prepare($query);

            $stmt->execute($zubereitungeinheit);
        }


    } catch (exception $e) {
        $e->getMessage();
    }

} else {

?>
<form method="POST">
    <div class="container">
        <div class="row">
            <div class="ten columns">
                <h3>Neues Rezept</h3>
                <p>Geben Sie den Rezeptnamen, die Anzahl der Zutaten ein!
                    Klicken Sie anschließend auf speichern und sie werden dann weitergeleitet um Zubereitung und Zutaten einzugeben.</p>
            </div>
        </div>
        <div class="row">
            <div class="ten columns">
                <label for="name">Rezeptname</label>
                <input class="u-full-width" name="name" type="text" placeholder="Rezeptname" id="name" required>

                <label for="anzahl">Anzahl der Zutaten</label>
                <input class="u-full-width" name="anzahl" type="number" placeholder="Anzahl" id="anzahl" required>

                <input class="button-primary" name="speichern" type="submit" value="speichern">
            </div>
        </div>
    </div>
</form>
<?php
}