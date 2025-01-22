<?php
session_start();
require_once 'alcohol_data.php';

// 必要なデータを取得
$state = $_SESSION['state'] ?? '前';
$limit = $_SESSION['drink_limit'] ?? 0;
$selectedAlcohols = $_SESSION['selectedAlcohols'] ?? [];

// 飲酒可能な組み合わせを計算するロジック
function calculateCombinations($selectedAlcohols, $alcoholData, $limit)
{
    $results = [];
    $items = [];
    foreach ($selectedAlcohols as $alcohol) {
        if (isset($alcoholData[$alcohol])) {
            $items[] = [
                'name' => $alcohol,
                'amount' => $alcoholData[$alcohol]['quantity']
            ];
        }
    }
    function findCombinations(
        $index,
        $items,
        $currentCombination,
        $currentSum,
        $limit,
        &$results
    ) {
        if ($currentSum > $limit) {
            return;
        }
        if (!empty($currentCombination)) {
            $results[] = $currentCombination;
        }
        for ($i = $index; $i < count($items); $i++) {
            $item = $items[$i];
            $newCombination = $currentCombination;
            $newCombination[$item['name']] = ($newCombination[$item['name']] ??
                0) + 1;
            findCombinations($i, $items, $newCombination, $currentSum +
                $item['amount'], $limit, $results);
        }
    }
    findCombinations(0, $items, [], 0, $limit, $results);
    return filterMaxCombinations($results);
}

// **最大の組み合わせのみを保持する関数**
function filterMaxCombinations($combinations)
{
    $filteredResults = [];
    foreach ($combinations as $combination) {
        $shouldAdd = true;
        foreach ($filteredResults as $index => $existing) {
            if (isSubset($combination, $existing)) {
                $shouldAdd = false;
                break;
            } elseif (isSubset($existing, $combination)) {
                unset($filteredResults[$index]);
            }
        }
        if ($shouldAdd) {
            $filteredResults[] = $combination;
        }
    }
    return array_values($filteredResults);
}

// **組み合わせが他の組み合わせの部分集合かどうかを判定**
function isSubset($small, $large)
{
    foreach ($small as $drink => $count) {
        if (!isset($large[$drink]) || $large[$drink] < $count) {
            return false;
        }
    }
    return true;
}

// 飲酒可能な組み合わせを計算
$combinations = calculateCombinations(
    $selectedAlcohols,
    $alcoholData,
    $limit
);
// ランダムに並べ替え
shuffle($combinations);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>おすすめの組み合わせ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 1.2em;
            color: #555;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #fff;
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>おすすめの組み合わせ</h1>
    <p>残り飲酒量の限度: <?php echo htmlspecialchars($limit); ?> ml</p>
    <?php if (!empty($combinations)): ?>
        <ul>
            <?php foreach ($combinations as $combination): ?>
                <li>
                    <?php
                    $displayText = [];
                    foreach ($combination as $alcohol => $cups) {
                        $displayText[] = htmlspecialchars($alcohol) . ": " . $cups . " 杯";
                    }
                    echo implode(" ", $displayText);
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>もう飲酒は控えましょう｡ 限度を超えています｡ </p>
    <?php endif; ?>
    <a href="index.php">ホームに戻る</a>
</body>

</html>
