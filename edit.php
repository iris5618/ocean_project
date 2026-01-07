<?php include 'db.php'; 
if (!isset($_SESSION['user'])) header("Location: login.php");

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM sensors WHERE id = ?");
$stmt->execute([$id]);
$s = $stmt->fetch();

if (!$s) die("找不到該感測器資料");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['sensor_name'];
    $temp = $_POST['temperature'];
    $ph = $_POST['ph_level'];
    $status = $_POST['status'];

    $sql = "UPDATE sensors SET sensor_name=?, temperature=?, ph_level=?, status=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $temp, $ph, $status, $id]);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>編輯感測器</title></head>
<body style="font-family: Arial; padding: 20px;">
    <h2>調整數位分身參數：<?= htmlspecialchars($s['sensor_name']) ?></h2>
    <form method="POST" style="line-height: 2.0;">
        感測器名稱：<input type="text" name="sensor_name" value="<?= $s['sensor_name'] ?>"><br>
        目前溫度 (°C)：<input type="number" step="0.01" name="temperature" value="<?= $s['temperature'] ?>"><br>
        目前 pH 值：<input type="number" step="0.01" name="ph_level" value="<?= $s['ph_level'] ?>"><br>
        運作狀態：
        <select name="status">
            <option value="正常" <?= $s['status']=='正常'?'selected':'' ?>>正常</option>
            <option value="異常" <?= $s['status']=='異常'?'selected':'' ?>>異常</option>
            <option value="維護中" <?= $s['status']=='維護中'?'selected':'' ?>>維護中</option>
        </select><br><br>
        <button type="submit" style="background: orange; color: white; padding: 5px 15px;">更新狀態</button>
        <a href="index.php">取消返回</a>
    </form>
</body>
</html>