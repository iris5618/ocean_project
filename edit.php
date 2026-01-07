<?php include 'db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM sensors WHERE id = ?");
$stmt->execute([$id]);
$s = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE sensors SET sensor_name=?, temperature=?, ph_level=?, status=? WHERE id=?");
    $stmt->execute([$_POST['name'], $_POST['temp'], $_POST['ph'], $_POST['status'], $id]);
    header("Location: index.php");
}
?>
<h2>編輯數位分身參數</h2>
<form method="POST">
    名稱：<input type="text" name="name" value="<?= $s['sensor_name'] ?>"><br>
    溫度：<input type="text" name="temp" value="<?= $s['temperature'] ?>"><br>
    pH值：<input type="text" name="ph" value="<?= $s['ph_level'] ?>"><br>
    狀態：
    <select name="status">
        <option value="正常" <?= $s['status']=='正常'?'selected':'' ?>>正常</option>
        <option value="異常" <?= $s['status']=='異常'?'selected':'' ?>>異常</option>
    </select><br><br>
    <button type="submit">儲存修改</button>
    <a href="index.php">返回</a>
</form>