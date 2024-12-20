<?php
session_start();
require_once 'alcohol_data.php';

// POSTリクエストを処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['selectedAlcohols'] = $_POST['alcohols'] ?? [];
    header('Location: recommendation.php');
    exit;
}

// アルコールデータを取得
$alcohols = array_keys($alcoholData);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お酒の選択</title>
</head>
<body>
    <h1>飲みたいお酒を選択</h1>
    <form method="post">
        <?php foreach ($alcohols as $alcohol): ?>
            <label>
                <input type="checkbox" name="alcohols[]" value="<?php echo htmlspecialchars($alcohol); ?>">
                <?php echo htmlspecialchars($alcohol); ?>
            </label>
            <br>
        <?php endforeach; ?>
        <button type="submit">確定</button>
    </form>
</body>
</html>
