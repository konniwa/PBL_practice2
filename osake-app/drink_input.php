<?php
session_start();
require_once 'alcohol_data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // セッションから限度量を取得
    $limit = $_SESSION['drink_limit'] ?? 0;

    // 飲んだお酒の種類と杯数を取得
    $amounts = $_POST['amounts'] ?? [];

    // 飲んだ量を計算
    $consumed = 0;
    foreach ($amounts as $alcohol => $cups) {
        if (isset($alcoholData[$alcohol])) {
            $cups = (int) $cups; // 数値に変換
            $consumed += $cups * $alcoholData[$alcohol]['quantity']; // 純アルコール量計算
        }
    }

    // 残り限度量を計算
    $limit -= $consumed;
    if ($limit < 0) {
        $limit = 0; // マイナスにならないように
    }

    // セッションに更新された限度量を保存
    $_SESSION['drink_limit'] = $limit;

    // 飲みたいお酒を選ぶ画面にリダイレクト
    header('Location: drink_selection.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲んだお酒の選択</title>
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
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 400px;
            border: 2px solid #ffcc00;
        }

        h1 {
            color: #ff9800;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1rem;
            color: #444;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
            border: 2px solid #ffcc00;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            margin-left: 10px;
        }

        button {
            background-color: #ff9800;
            color: #fff;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #e67e22;
            transform: scale(1.05);
        }

        .cup-unit {
            margin-left: 5px;
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>飲んだお酒の種類と杯数を入力</h1>
        <form method="post">
            <?php foreach ($alcoholData as $alcohol => $amount): ?>
                <label for="<?php echo htmlspecialchars($alcohol); ?>">
                    <?php echo htmlspecialchars($alcohol); ?>:
                    <input type="number" id="<?php echo htmlspecialchars($alcohol); ?>" name="amounts[<?php echo htmlspecialchars($alcohol); ?>]" min="0" step="1" value="0">
                    <span class="cup-unit">杯</span>
                </label>
            <?php endforeach; ?>
            <button type="submit">次へ</button>
        </form>
    </div>
</body>

</html>
