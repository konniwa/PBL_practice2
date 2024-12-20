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
            $consumed += $cups * $alcoholData[$alcohol]; // 純アルコール量計算
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
</head>

<body>
    <h1>飲んだお酒の種類と杯数を入力</h1>
    <form method="post">
        <?php foreach ($alcoholData as $alcohol => $amount): ?>
            <label for="<?php echo htmlspecialchars($alcohol); ?>"><?php echo htmlspecialchars($alcohol); ?>:</label>
            <input type="number" id="<?php echo htmlspecialchars($alcohol); ?>"
                name="amounts[<?php echo htmlspecialchars($alcohol); ?>]" min="0" step="1" value="0">
            杯<br>
        <?php endforeach; ?>
        <button type="submit">次へ</button>
    </form>
</body>

</html>