<?php
function kartuToRfid($nomorKartu)
{
    // Step 1: Decimal ke HEX (8 digit, uppercase)
    $hex = strtoupper(str_pad(dechex((int)$nomorKartu), 8, '0', STR_PAD_LEFT));
    // contoh: E348CD5A

    // Step 2: Reverse per byte (little endian)
    return substr($hex, 6, 2)
         . substr($hex, 4, 2)
         . substr($hex, 2, 2)
         . substr($hex, 0, 2);
}

// TEST
echo kartuToRfid("3813199194"); // 5ACD48E3
echo PHP_EOL;
echo kartuToRfid("3813199194"); // 53B9C08B
echo PHP_EOL;
echo kartuToRfid("3813199194"); // B162BE8B
