<?php
$result = array_map('htmlspecialchars', $_GET);

// Helper function to maintain state
function allapottarto($result, $key) {
    return isset($result[$key]) ? $result[$key] : '';
}
?>

<form method="GET" action="search.php">
    <div class="form-group">
        <select class="selectpicker search-fields" name="property-status" id="property-status">
            <option value="rentandsale">Kiadó és eladó</option>
            <option value="sale">Eladó</option>
            <option value="rent">Kiadó</option>
        </select>
    </div>
    <div class="form-group">
        <select class="selectpicker search-fields" name="property-type">
            <option value="defaulttype">Típus</option>
            <option value="Apartment">Apartment</option>
            <option value="Családi ház">Családi ház</option>
            <option value="Lakás">Lakás</option>
            <option value="Panel lakás">Panel lakás</option>
            <option value="Garázs">Garázs</option>
            <option value="Tanya">Tanya</option>
            <option value="Nyaraló">Nyaraló</option>
            <option value="Iroda">Iroda</option>

        </select>
    </div>
    <div class="form-group">
        <input class="form-control search-fields" name="location" id="location" placeholder="Hely">
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <select class="selectpicker search-fields" name="bedrooms">
                    <option value="bedroom0">Szobák száma</option>
                    <option value="bedroom1">1</option>
                    <option value="bedroom2">2</option>
                    <option value="bedroom3">3</option>
                    <option value="bedroom4">4</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <select class="selectpicker search-fields" name="bathroom">
                    <option value="bathroom0">Fürdőszobák száma</option>
                    <option value="bathroom1">1</option>
                    <option value="bathroom2">2</option>
                    <option value="bathroom3">3</option>
                    <option value="bathroom4">4</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <select class="selectpicker search-fields" name="balcony">
            <option value="defaultcondition">Állapot</option>
            <option value="Új">Új</option>
            <option value="Újszerű">Újszerű</option>
            <option value="Felújított">Felújított</option>
            <option value="Használt">Használt</option>
            <option value="Romos">Romos</option>
        </select>

    </div>
    <div class="range-slider">
        <label>Méret</label>
        <div data-min="0" data-max="1000" data-min-name="min_area" data-max-name="max_area"
             data-unit="m&#178;" class="range-slider-ui ui-slider" aria-disabled="false"></div>
        <div class="clearfix"></div>
    </div>
    <div class="range-slider">
        <label>Ár</label>
        <div data-min="0" data-max="500000" data-min-name="min_price" data-max-name="max_price"
             data-unit="Forint" class="range-slider-ui ui-slider" aria-disabled="false"></div>
        <div class="clearfix"></div>
    </div>
    <a class="show-more-options" data-toggle="collapse" data-target="#options-content">
        <i class="fa fa-plus-circle"></i> Egyéb opciók
    </a>
    <div id="options-content" class="collapse">
        <label class="margin-t-10">Tulajdonságok</label>
        <div class="s-border"></div>
        <div class="m-border"></div>
        <div class="checkbox checkbox-theme checkbox-circle">
            <input id="checkboxGarage" type="checkbox" name="garage" value="1">
            <label for="checkboxGarage">Garázs</label>
        </div>
        <div class="checkbox checkbox-theme checkbox-circle">
            <input id="checkboxmedence" type="checkbox" name="pool" value="1">
            <label for="checkboxmedence">Medence</label>
        </div>
        <div class="checkbox checkbox-theme checkbox-circle">
            <input id="checkboxwifi" type="checkbox" name="wifi" value="1">
            <label for="checkboxwifi">Wi-Fi</label>
        </div>

    </div>
    <div class="form-group mb-0">
        <button class="search-button">Keresés</button>
    </div>
</form>