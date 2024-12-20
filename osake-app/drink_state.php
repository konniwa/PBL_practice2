<?php
session_start();
require_once 'functions.php';

// 性別、年齢、体重、飲酒強度を取得
$gender = $_POST['gender'] ?? null;
$age = $_POST['age'] ?? null;
$weight = $_POST['weight'] ?? null;
$strength = $_POST['strength'] ?? null;

// 必要なデータが揃っている場合、限度量を計算してセッションに保存
if ($gender && $age && $weight && $strength) {
    $hours = 2; // デフォルトの時間設定
    $limit = calculateAlcoholLimit($gender, $weight, $strength, $hours);
    $_SESSION['drink_limit'] = $limit;
} else {
    echo "エラー: 必要な情報が不足しています。";
    exit;
}

// 飲む前・飲んでいる途中の選択画面
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲酒管理システム - 状態選択</title>
</head>

<body>
    <h1>飲酒管理システム</h1>
    <p>飲酒量の限度: <?php echo htmlspecialchars($limit); ?> ml</p>
    <form action="state_handler.php" method="post">
        <button type="submit" name="state" value="前">飲む前</button>
        <button type="submit" name="state" value="途中">飲んでいる途中</button>
    </form>
</body>

</html>
