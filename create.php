<?php include 'db.php'; 
if (!isset($_SESSION['user'])) header("Location: login.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['sensor_name'];
    $loc = $_POST['location'];
    $temp = $_POST['temperature'];
    $ph = $_POST['ph_level'];
    $sal = $_POST['salinity'];
    $status = $_POST['status'];

    $sql = "INSERT INTO sensors (sensor_name, location, temperature, ph_level, salinity, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $loc, $temp, $ph, $sal, $status]);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>新增感測器</title></head>
<body style="font-family: Arial; padding: 20px;">
    <h2>建立新的海洋感測器實體 (Digital Twin)</h2>
    <form method="POST" style="line-height: 2.0;">
        感測器名稱：<input type="text" name="sensor_name" required><br>
        佈署位置：<input type="text" name="location" placeholder="例如：北太平洋 A1 區"><br>
        模擬溫度 (°C)：<input type="number" step="0.01" name="temperature" value="25.00"><br>
        模擬 pH 值：<input type="number" step="0.01" name="ph_level" value="8.10"><br>
        模擬鹽度 (psu)：<input type="number" step="0.01" name="salinity" value="35.00"><br>
        運作狀態：
        <select name="status">
            <option value="正常">正常</option>
            <option value="異常">異常</option>
            <option value="維護中">維護中</option>
        </select><br><br>
        <button type="submit" style="background: green; color: white; padding: 5px 15px;">確認新增</button>
        <a href="index.php">取消返回</a>
    </form>
</body>
</html>