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
            align-items: center;
            font-size: 1.1rem;
            gap: 10px;
            color: #444;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #ff9800;
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

        .container .box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .box img {
            width: 50px;  /* 画像サイズを調整 */
            height: 50px;
            object-fit: cover;
        }

        .box p {
            font-size: 1.1rem;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>飲みたいお酒を選択</h1>
        <form method="post">
            <?php foreach ($alcohols as $alcohol): ?>
                <div class="box">
                    <label>
                        <input type="checkbox" name="alcohols[]" value="<?php echo htmlspecialchars($alcohol); ?>">
                        <img src="<?php echo $alcoholData[$alcohol]['image']; ?>" alt="<?php echo htmlspecialchars($alcohol); ?>">
                        <p><?php echo htmlspecialchars($alcohol); ?></p>
                    </label>
                </div>
            <?php endforeach; ?>
            <button type="submit">確定</button>
        </form>
    </div>
</body>
</html>
