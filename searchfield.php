<?php
include 'propertydropdown.php';
global $propertyTypes, $propertyConditions, $heatingTypes;
// Helper function to maintain state
function allapottarto($result, $key) {
    return $result[$key] ?? '';
}

// Function to check selected option
function isSelected($result, $key, $value) {
    return allapottarto($result, $key) === $value ? 'selected' : '';
}

// Function to check checkbox
function isChecked($result, $key) {
    return isset($result[$key]) ? 'checked' : '';
}

// Assuming you've sanitized and assigned $_GET parameters to $result
$result = array_map('htmlspecialchars', $_GET);
?>

<script type="text/javascript">
    function resetSearch() {
        window.location.href = 'search.php';
    }
</script>

<form method="GET" action="search.php">
    <!-- Property Status -->
    <div class="form-group">
        <select class="selectpicker search-fields" name="property-status" id="property-status">
            <option value="rentandsale" <?= isSelected($result, 'property-status', 'rentandsale') ?>>Kiadó és eladó</option>
            <option value="sale" <?= isSelected($result, 'property-status', 'sale') ?>>Eladó</option>
            <option value="rent" <?= isSelected($result, 'property-status', 'rent') ?>>Kiadó</option>
        </select>
    </div>

    <!-- Property Type -->
    <div class="form-group">
        <select class="selectpicker search-fields" name="property-type">
            <option value="defaulttype" <?= isSelected($result, 'property-type', 'defaulttype') ?>>Típus</option>
            <?php foreach ($propertyTypes as $key => $value): ?>
                <option value="<?= $key ?>" <?= isSelected($result, 'property-type', $key) ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Location -->
    <div class="form-group">
        <input class="form-control search-fields" name="location" id="location" placeholder="Hely" value="<?= allapottarto($result, 'location') ?>">
    </div>

    <!-- Bedrooms -->
    <div class="form-group">
        <select class="selectpicker search-fields" name="bedrooms">
            <option value="bedroom0" <?= isSelected($result, 'bedrooms', 'bedroom0') ?>>Szobák száma</option>
            <option value="bedroom1" <?= isSelected($result, 'bedrooms', 'bedroom1') ?>>1</option>
            <option value="bedroom2" <?= isSelected($result, 'bedrooms', 'bedroom2') ?>>2</option>
            <option value="bedroom3" <?= isSelected($result, 'bedrooms', 'bedroom3') ?>>3</option>
            <option value="bedroom4" <?= isSelected($result, 'bedrooms', 'bedroom4') ?>>4</option>
        </select>
    </div>

    <!-- Bathrooms -->
    <div class="form-group">
        <select class="selectpicker search-fields" name="bathroom">
            <option value="bathroom0" <?= isSelected($result, 'bathroom', 'bathroom0') ?>>Fürdőszobák száma</option>
            <option value="bathroom1" <?= isSelected($result, 'bathroom', 'bathroom1') ?>>1</option>
            <option value="bathroom2" <?= isSelected($result, 'bathroom', 'bathroom2') ?>>2</option>
            <option value="bathroom3" <?= isSelected($result, 'bathroom', 'bathroom3') ?>>3</option>
            <option value="bathroom4" <?= isSelected($result, 'bathroom', 'bathroom4') ?>>4</option>
        </select>
    </div>

    <!--   Condition -->
    <div class="form-group">
        <select class="selectpicker search-fields" name="condition">
            <option value="defaultcondition" <?= isSelected($result, 'condition', 'defaultcondition') ?>>Állapot</option>
            <?php foreach ($propertyConditions as $key => $value): ?>
                <option value="<?= $key ?>" <?= isSelected($result, 'condition', $key) ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Checkboxes -->
    <div class="checkbox checkbox-theme checkbox-circle">
        <input id="checkboxGarage" type="checkbox" name="garage" value="1" <?= isChecked($result, 'garage') ?>>
        <label for="checkboxGarage">Garázs</label>
    </div>
    <div class="checkbox checkbox-theme checkbox-circle">
        <input id="checkboxmedence" type="checkbox" name="pool" value="1" <?= isChecked($result, 'pool') ?>>
        <label for="checkboxmedence">Medence</label>
    </div>
    <div class="checkbox checkbox-theme checkbox-circle">
        <input id="checkboxwifi" type="checkbox" name="wifi" value="1" <?= isChecked($result, 'wifi') ?>>
        <label for="checkboxwifi">Wi-Fi</label>
    </div>

    <!-- Submit Button -->
    <div class="form-group mb-0">
        <button class="search-button">Keresés</button>
    </div>
    <br>
    <!-- Reset Button -->
    <div class="form-group mb-0">
        <button class="search-button" type="button" onclick="resetSearch()">Keresés alaphelyzetbe állítása</button>
    </div>
</form>
