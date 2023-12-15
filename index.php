<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <title>PHP project</title>
</head>
<body>
    <h3 class="today-dinner">今日の献立を入力</h3>
        <form action="filing.php" method="POST" enctype="multipart/form-data">
            <input type="date" name="date" class="date">
            <div class="main-dinner">
                <label for="main">主食</label>
                <input type="text" name="main">
            </div>
            <div class="sub-dinner">
                <label for="sub">副菜</label>
                <input type="text" name="sub">
            </div>

            <button>登録</button>
        </form>    
    <h4>過去の献立を見る</h4>
        <a href="menu.php">一覧表示</a>    
</body>
</html>