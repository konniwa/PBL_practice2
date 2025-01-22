<?php
function calculateAlcoholLimit($gender, $weight, $strength, $hours = 1)
{
    $baseLimit = ($gender === '男性') ? 42 : 32; // 男性42g、女性32g
    $adjustedLimit = $baseLimit * ($weight / 70);
    switch ($strength) {
        case '弱い':
            $adjustedLimit *= 0.2;
            break;
        case '強い':
            $adjustedLimit *= 1.2;
            break;
        // '普通'はデフォルトのままで変更しない
    }
    return round($adjustedLimit * $hours, 2);
}
?>
