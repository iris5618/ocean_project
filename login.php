<?php include 'db.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['user_id'] = $user['id']; // 存入 ID 供關聯使用
        header("Location: index.php");
    }else { $error = "帳號或密碼錯誤！"; }
}
?>
<!DOCTYPE html>
<html>
<head><title>登入 - 海洋治理框架</title></head>
<body style="font-family: Arial; background: #f0f8ff; text-align: center; padding-top: 50px;">
    <h2>🌊 海洋環境感測管理系統</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="帳號" required><br><br>
        <input type="password" name="password" placeholder="密碼" required><br><br>
        <button type="submit">登入</button>
    </form>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>