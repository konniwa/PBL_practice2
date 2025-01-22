<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲酒管理システム - ホーム</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff8b5;
            /* 背景: 明るい黄色 */
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: #ff9800;
            /* タイトル: 濃いオレンジ */
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 350px;
            /* 最大幅を指定 */
            text-align: left;
            border: 2px solid #ffcc00;
            /* 枠線: 明るい黄色 */
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            color: #444;
            /* ラベル文字: 見やすい濃いグレー */
        }

        input,
        select,
        button {
            width: calc(100% - 20px);
            /* 枠内で均等に調整 */
            margin-top: 5px;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #ffcc00;
            /* 入力枠: 明るい黄色 */
            font-size: 1rem;
            background-color: #fff;
            color: #333;
            box-sizing: border-box;
            /* 幅計算をボックスに調整 */
        }

        button {
            background-color: #ff9800;
            /* ボタン: 濃いオレンジ */
            color: #fff;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #e67e22;
            /* ボタンホバー: 少し濃いオレンジ */
            transform: scale(1.05);
        }

        input[type="radio"] {
            width: auto;
            margin-right: 5px;
        }

        .radio-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 5px;
            /* ラベルとラジオボタン間のスペース */
        }
    </style>
</head>

<body>
    <div>
        <h1>飲酒管理システム</h1>
        <form action="drink_state.php" method="post">
            <label>性別:</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="male" name="gender" value="男性" required>
                    <label for="male">男性</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="female" name="gender" value="女性">
                    <label for="female">女性</label>
                </div>
            </div>

            <label for="age">年齢:</label>
            <input type="number" id="age" name="age" min="20" required>

            <label for="weight">体重 (kg):</label>
            <input type="number" id="weight" name="weight" min="10" required>

            <label for="strength">飲酒強度:</label>
            <select id="strength" name="strength" required>
                <option value="弱い">弱い</option>
                <option value="普通">普通</option>
                <option value="強い">強い</option>
            </select>

            <button type="submit">次へ</button>
        </form>
    </div>
</body>

</html>
