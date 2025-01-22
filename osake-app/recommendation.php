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
            background: #fff8b5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 500px; /* 幅を小さく調整 */
            border: 2px solid #ffcc00;
        }

        h1 {
            color: #ff9800;
            font-size: 1.5rem; /* 小さめの見出し */
            margin-bottom: 15px;
        }

        p {
            font-size: 1rem; /* 説明文を小さめに */
            margin-bottom: 15px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #fff;
            border: 1px solid #ddd;
            margin: 8px 0; /* 間隔を調整 */
            padding: 10px; /* 内側の余白を小さく */
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px; /* アイテム間の余白を調整 */
        }

        li img {
            width: 40px; /* 画像サイズを小さく */
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }

        li span {
            font-size: 1rem; /* テキストサイズを小さく */
            color: #555;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #fff;
            background-color: #ff9800;
            padding: 8px 15px; /* ボタンをコンパクトに */
            border-radius: 5px;
            font-size: 1rem; /* ボタンテキストのサイズを調整 */
            transition: background-color 0.3s, transform 0.2s;
        }

        a:hover {
            background-color: #e67e22;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>おすすめの組み合わせ</h1>
        <p>残り飲酒量の限度: <?php echo htmlspecialchars($limit); ?> ml</p>
        <?php if (!empty($combinations)): ?>
            <ul>
                <?php foreach ($combinations as $combination): ?>
                    <li>
                        <?php
                        foreach ($combination as $alcohol => $cups) {
                            $image = $alcoholData[$alcohol]['image'] ?? ''; // 画像パスを取得
                            echo '<img src="' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($alcohol) . '">';
                            echo '<span>' . htmlspecialchars($alcohol) . ": " . $cups . " 杯</span>";
                        }
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>もう飲酒は控えましょう｡ 限度を超えています｡ </p>
        <?php endif; ?>
        <a href="index.php">ホームに戻る</a>
    </div>
</body>

</html>
