<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲酒管理システム - ホーム</title>
</head>

<body>
    <h1>飲酒管理システム</h1>
    <form action="drink_state.php" method="post">
        <label>性別:</label>
        <input type="radio" id="male" name="gender" value="男性" required>
        <label for="male">男性</label>
        <input type="radio" id="female" name="gender" value="女性">
        <label for="female">女性</label>
        <br>
        <label for="age">年齢:</label>
        <input type="number" id="age" name="age" min="20" required>
        <br>
        <label for="weight">体重 (kg):</label>
        <input type="number" id="weight" name="weight" min="10" required>
        <br>
        <label for="strength">飲酒強度:</label>
        <select id="strength" name="strength" required>
            <option value="弱い">弱い</option>
            <option value="普通">普通</option>
            <option value="強い">強い</option>
        </select>
        <br>
        <button type="submit">次へ</button>
    </form>
</body>

</html>