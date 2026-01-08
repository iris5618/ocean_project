<?php 
include 'newd.php'; 

// 檢查是否登入，未登入者跳轉回登入頁面
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 接收表單傳來的數據
    $name = $_POST['sensor_name'];
    $loc = $_POST['location'];
    $temp = $_POST['temperature'];
    $ph = $_POST['ph_level'];
    $sal = $_POST['salinity'];
    $status = $_POST['status'];
    
    // 從 Session 獲取當前管理員 ID (這就是連線到 users 表的關鍵)
    // 如果 login.php 還沒改，可以先暫時寫死為 1，但建議 login.php 要存 $_SESSION['user_id']
    $manager_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

    try {
        // SQL 語法：新增感測器，並關聯到目前的管理者
        $sql = "INSERT INTO sensors (sensor_name, location, temperature, ph_level, salinity, status, manager_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $loc, $temp, $ph, $sal, $status, $manager_id]);
        
        // 新增成功後跳轉回主首頁
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        $error = "新增失敗：" . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增感測器 - 海洋數位分身系統</title>
    <style>
        body { font-family: "Microsoft JhengHei", Arial, sans-serif; background: #f4f7f6; padding: 40px; }
        .container { max-width: 500px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin: auto; }
        h2 { color: #0077be; border-bottom: 2px solid #0077be; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background: #218838; }
        .btn-back { color: #666; text-decoration: none; margin-left: 10px; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">
    <h2>🌊 建立感測器數位分身</h2>
    <p>請輸入實體感測器的對應參數：</p>

    <?php if(isset($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>感測器名稱</label>
            <input type="text" name="sensor_name" placeholder="例如：東沙環礁感測器-01" required>
        </div>

        <div class="form-group">
            <label>佈署位置</label>
            <input type="text" name="location" placeholder="例如：20.7°N, 116.7°E">
        </div>

        <div class="form-group">
            <label>模擬溫度 (°C)</label>
            <input type="number" step="0.1" name="temperature" value="25.5">
        </div>

        <div class="form-group">
            <label>模擬 pH 值</label>
            <input type="number" step="0.01" name="ph_level" value="8.10">
        </div>

        <div class="form-group">
            <label>模擬鹽度 (psu)</label>
            <input type="number" step="0.1" name="salinity" value="35.0">
        </div>

        <div class="form-group">
            <label>目前運作狀態</label>
            <select name="status">
                <option value="正常">正常</option>
                <option value="異常">異常</option>
                <option value="維護中">維護中</option>
            </select>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn-submit">確認新增至系統</button>
            <a href="index.php" class="btn-back">取消返回</a>
        </div>
    </form>
</div>

</body>
</html>
