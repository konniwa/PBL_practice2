<?php
session_start();
require_once 'alcohol_data.php';

// 必要なデータを取得
$state = $_SESSION['state'] ?? '前';
$limit = $_SESSION['drink_limit'] ?? 0;
$selectedAlcohols = $_SESSION['selectedAlcohols'] ?? []; // セッションから取得

// 飲酒量限度を計算するロジック

function calculateCombinations($selectedAlcohols, $alcoholData, $limit) {
    $results = [];

    // 対象となるお酒のリストを準備
    $items = [];
    foreach ($selectedAlcohols as $alcohol) {
        if (isset($alcoholData[$alcohol])) {
            $items[] = [
                'name' => $alcohol,
                'amount' => $alcoholData[$alcohol]
            ];
        }
    }

    // 再帰的に組み合わせを探索
    function findCombinations($index, $items, $currentCombination, $currentSum, $limit, &$results) {
        if ($currentSum > $limit) {
            return; // 限度を超えたら終了
        }
        if (!empty($currentCombination)) {
            $results[] = [
                'combination' => $currentCombination,
                'total' => $currentSum
            ];
        }

        for ($i = $index; $i < count($items); $i++) {
            $item = $items[$i];
            $newCombination = $currentCombination;
            $newCombination[$item['name']] = ($newCombination[$item['name']] ?? 0) + 1;
            findCombinations($i, $items, $newCombination, $currentSum + $item['amount'], $limit, $results);
        }
    }

    findCombinations(0, $items, [], 0, $limit, $results);

    // 結果に合致する全ての組み合わせを返す
    return array_map(function ($result) {
        return $result['combination'];
    }, $results);
}



// 飲酒可能な組み合わせを計算
$combinations = calculateCombinations($selectedAlcohols, $alcoholData, $limit);

// ランダムに並べ替え
shuffle($combinations);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>おすすめの組み合わせ</title>
</head>

<body>
    <h1>おすすめの組み合わせ</h1>
    <p>残り飲酒量の限度: <?php echo htmlspecialchars($limit); ?> ml</p>

    <?php if (!empty($combinations)): ?>
        <ul>
            <?php foreach ($combinations as $combination): ?>
                <li>
                    <?php foreach ($combination as $alcohol => $cups): ?>
                        <?php echo htmlspecialchars($alcohol) . ": " . $cups . " 杯"; ?>
                    <?php endforeach; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>もう飲酒は控えましょう。限度を超えています。</p>
    <?php endif; ?>

    <a href="index.php">ホームに戻る</a>
</body>

</html>