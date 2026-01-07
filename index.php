<?php include 'db.php'; 
if (!isset($_SESSION['user'])) header("Location: login.php");
$stmt = $pdo->query("SELECT * FROM sensors");
$sensors = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>感測器列表</title>
<style>
    table { width: 90%; margin: 20px auto; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #0077be; color: white; }
    .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    .btn-add { background: green; color: white; }
    .btn-edit { background: orange; color: white; }
    .btn-del { background: red; color: white; }
</style>
</head>
<body>
    <h2 style="text-align:center;">數位分身監控面板 (海洋永續治理)</h2>
    <div style="text-align:center;">
        歡迎, <?php echo $_SESSION['user']; ?> | 
        <a href="create.php" class="btn btn-add">新增感測器</a> | 
        <a href="logout.php">登出</a>
    </div>
    <table>
        <tr>
            <th>ID</th><th>感測器名稱</th><th>地點</th><th>溫度 (°C)</th><th>pH值</th><th>狀態</th><th>最後更新</th><th>操作</th>
        </tr>
        <?php foreach ($sensors as $s): ?>
        <tr>
            <td><?= $s['id'] ?></td>
            <td><?= $s['sensor_name'] ?></td>
            <td><?= $s['location'] ?></td>
            <td><?= $s['temperature'] ?></td>
            <td><?= $s['ph_level'] ?></td>
            <td><?= $s['status'] ?></td>
            <td><?= $s['last_update'] ?></td>
            <td>
                <a href="edit.php?id=<?= $s['id'] ?>" class="btn btn-edit">編輯</a>
                <a href="delete.php?id=<?= $s['id'] ?>" class="btn btn-del" onclick="return confirm('確定刪除?')">刪除</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>