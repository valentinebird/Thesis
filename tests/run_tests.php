<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// IMPORTANT: Secure this script to prevent unauthorized access.

// The command to run PHPUnit
//$command = 'php /home/thebwvas/madar-szakdolgozat.online/vendor/bin/phpunit /home/thebwvas/madar-szakdolgozat.online/tests/ConnectionTest.php';
$command = 'php /home/thebwvas/madar-szakdolgozat.online/vendor/bin/phpunit --bootstrap /home/thebwvas/madar-szakdolgozat.online/vendor/autoload.php /home/thebwvas/madar-szakdolgozat.online/tests/ConnectionTest.php';

ob_start();
passthru($command, $return_var);
$output = ob_get_clean();

if ($return_var !== 0) {
    echo "Error executing PHPUnit tests. Return code: $return_var";
} else {
    echo "<pre>" . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
}
?>
