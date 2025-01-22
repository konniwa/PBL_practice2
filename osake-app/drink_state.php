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
    <title>飲酒管理システム</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff8b5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #FFFFFF;
            border-radius: 15px;
            padding: 30px 40px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
            border: 2px solid #FF9900;
        }

        p {
            font-size: 1.5rem;
            color: #333333;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        button {
            background-color: #FF9900;
            color: #FFFFFF;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #CC7A00;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <p>飲酒量の限度: <?php echo htmlspecialchars($limit); ?> ml</p>
        <form action="state_handler.php" method="post">
            <button type="submit" name="state" value="前">飲む前</button>
            <button type="submit" name="state" value="途中">飲んでいる途中</button>
        </form>
    </div>
</body>

</html>
