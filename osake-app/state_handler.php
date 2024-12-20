<?php
session_start();
require_once 'alcohol_data.php';

// state の値を確認
if (isset($_POST['state'])) {
    $state = $_POST['state'];
    $_SESSION['state'] = $state; // 状態をセッションに保存

    if ($state === '前') {
        // 飲む前 → 飲みたいお酒を選ぶ画面へ
        header('Location: drink_selection.php');
        exit;
    } elseif ($state === '途中') {
        // 飲んでいる途中 → 飲んだお酒入力画面へ
        header('Location: drink_input.php');
        exit;
    } else {
        echo "エラー: 不正な状態が選択されました。";
        exit;
    }
} else {
    echo "エラー: 状態が選択されていません。";
    exit;
}
