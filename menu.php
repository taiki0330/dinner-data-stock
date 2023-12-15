<?php

    $str = '';
    $menu_array = [];

    $file = fopen('data/meal.csv', 'r');
    flock($file, LOCK_EX);
    if($file) {
        while($line = fgets($file)){
            $str .= "<tr><td>{$line}</td></tr>";
            // $menu_array[] = $line;
            $menu_array[] = ["date" => explode(" ", $line)[0], 
                            "main" => explode(" ", explode(" ", $line)[1])[0], 
                            "sub" => explode("\n", explode(" ", $line)[2])[0],
                        ];
        };
    };
    flock($file, LOCK_UN);
    fclose($file);
; ?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <title>Document</title>
</head>
<body>
    <fieldset>
        <legend>今までの献立一覧</legend>
        <a href="index.php">トップへ戻る</a>
        <table>
            <thead>
                <tr>献立</tr>
            </thead>
            <tbody>
                <?php echo $str; ?>
            </tbody>
        </table>
    </fieldset>
    <div class="search-form">
        <div class="main-form">
            <input type="text" id="input-str-main" placeholder="主食">
            <button class="search-main">検索</button>
            <div class="result-list-main"></div>
        </div>
        <div class="sub-form">
            <input type="text" id="input-str-sub" placeholder="副菜">
            <button class="search-sub">検索</button>
            <div class="result-list-sub"></div>
        </div>
    </div>



    <script>
        const menu_array = <?= json_encode($menu_array) ?>;
        console.log(menu_array);

        // 日付を新しい配列で定義
        const dateList = menu_array.map(date => date.date);
        console.log(dateList); // ['2023-12-09', '2023-12-10', '2023-12-11', '2023-12-12']
        
        // 主食を新しい配列で定義
        const mainList = menu_array.map(main => main.main);
        console.log(mainList); // ['野菜炒め', 'ごぼう天うどん', '唐揚げ弁当', 'ピザ']

        // 副菜を新しい配列で定義
        const subList = menu_array.map(sub => sub.sub);
        console.log(subList); // ['味噌汁', 'ほうれん草のおひたし', 'なし', 'フライドポテト']
        

        // 下記で主食(main)を検索する
        const inputStrMain = document.querySelector('#input-str-main');
        const searchBtnMain = document.querySelector('.search-main');
        const resultListMain = document.querySelector('.result-list-main');

        // 検索ボタンを押した時に発火
        inputStrMain.addEventListener('keyup', (e) => {
            e.preventDefault();
            let inputStrValueMain = inputStrMain.value; // フォームに入力する文字
            findStrMain(inputStrValueMain); // 下の処理
        })

        // 入力した文字を検索して元のオブジェクトまで参照する処理
        function findStrMain(inputStrValueMain) {
            // 入力した文字を含む文字列を検索
            const result = mainList.filter(word => word.indexOf(inputStrValueMain) != -1);
            // console.log(result); // ['ピザ']
            // 合致した文字列を含むオブジェクトデータを検索
            const res = menu_array.find((data) => data.main == result);
            // console.log(res); // {date: '2023-12-12', main: 'ピザ', sub: 'フライドポテト'}

            if (res === undefined) {
                resultListMain.textContent = "該当なし"; // undefinedのとき
                return;
            } else {
                resultListMain.textContent = `${res.date}: ${res.main}`; // データがあるとき
            }
        }

        // 下記で副菜(sub)を検索する
        const inputStrSub = document.querySelector('#input-str-sub');
        const searchBtnSub = document.querySelector('.search-sub');
        const resultListSub = document.querySelector('.result-list-sub');

        // 検索ボタンを押した時に発火
        inputStrSub.addEventListener('keyup', (e) => {
            e.preventDefault();
            let inputStrValueSub = inputStrSub.value; // フォームに入力する文字
            findStrSub(inputStrValueSub); // 下の処理
        })

        // 入力した文字を検索して元のオブジェクトまで参照する処理
        function findStrSub(inputStrValueSub) {
            // 入力した文字を含む文字列を検索
            const result = subList.filter(word => word.indexOf(inputStrValueSub) != -1);
            // console.log(result); // ['きゅうりの浅漬け']
            // 合致した文字列を含むオブジェクトデータを検索
            const res = menu_array.find((data) => data.sub == result);
            console.log(res); // {date: '2023-12-08', main: 'わかめうどん', sub: 'きゅうりの浅漬け'}

            if (res === undefined) {
                resultListSub.textContent = "該当なし"; // undefinedのとき
                return;
            } else {
                resultListSub.textContent = `${res.date}: ${res.sub}`; // データがあるとき
            }
        }
    </script>
</body>
</html>