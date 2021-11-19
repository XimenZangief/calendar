<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <style>
        body {
            background: url("./SFV.png");
            background-size: cover;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            text-align: center;
            font-family: 'Courier New', 'Courier', 'monospace';
            font-size: 1.5rem;
            font-weight: bold;
            opacity: 0.8;
        }

        .header {
            width: 100%;
            background-color: skyblue;
            color: wheat;
            padding: 0;
            font-size: 5.5rem;
            text-shadow: 2px 2px 5px grey;
            box-shadow: 2px 0px 10px black;
        }

        table {
            background: lightskyblue;
            width: 750px;
            height: 500px;
            margin: 10px auto 0;
            padding: 20px;
        }

        td {
            background: lightgrey;
            opacity: 0.9;
            width: calc(750px / 7);
            height: calc(500px / 5);
            border: 1px double black;
        }

        td:hover {
            border: 1px double black;
            border-radius: 30px;
            background-color: black;
            color: whitesmoke;
            cursor: cell;
            padding: 0;
        }

        .holiday {
            background-color: pink;
        }

        .specialday {
            background-color: lightcoral;
            color: yellow;
            text-shadow: 0.1em 0.1em 0.2em black;
            box-shadow: 0.1em 0.1em 0.2em black;
        }

        .holiday:hover,
        .specialday:hover {
            background-color: skyblue;
            color: red;
            text-shadow: black 2px 2px;
        }

        a {
            text-decoration: none;
            font-size: 2rem;
        }

        .footer {
            width: 100%;
            position: fixed;
            opacity: 0.8;
            bottom: 0px;
            background-color: #555;
            color: white;
            padding: 10px;
            font-size: 1.5rem;
        }
    </style>
    <?php
    date_default_timezone_set('Asia/Taipei');
    // $year = date('Y');
    // $month = date('m');
    if (isset($_GET['month'])) {
        $month = $_GET['month'];
        $year = $_GET['year'];
    } else {
        $month = date("m");
        $year = date("Y");
    }

    $lastmonth = $month - 1;
    $lastyear = $year;
    $nextmonth = $month + 1;
    $nextyear = $year;

    if ($month == 1) {
        $lastmonth = 12;
        $lastyear = $year - 1;
        $nextmonth = $month + 1;
        $nextyear = $year;
    } else if ($month == 12) {
        $lastmonth = $month - 1;
        $lastyear = $year;
        $nextmonth = 1;
        $nextyear = $year + 1;
    }


    // 星期日~六做成陣列
    $daysOfWeek = array('日', '一', '二', '三', '四', '五', '六');
    // echo '<pre>';
    // print_r($daysOfWeek);
    // echo '</pre>';

    // 創造當月一號的資料  mktime(H, i, s, m, d, Y)
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    // 將當月一號的資料存成陣列
    $dateComponents = getdate($firstDayOfMonth);
    // 取得$dateComponents陣列中key=>month的值(英文月份全名)
    $monthName = $dateComponents['month'];
    // 取得$dateComponents陣列中key=>wday的值(星期0~6)
    $dayOfWeek = $dateComponents['wday'];
    // echo '<pre>';
    // print_r($dateComponents);
    // echo '</pre>';

    // 抓當月有幾天
    $numberDays = date('t', $firstDayOfMonth);
    $specialDate = [
        '7-21' => '　隆　', '2-14' => '　肯　', '8-22' => '巴蒂 ', '7-2' => '沙卡特', '3-1' => '　春麗',
        '12-23' => '凱爾 ', '11-3' => '本田 ', '6-1' => '老桑 ', '2-12' => '布蘭卡', '11-22' => '塔爾錫', '9-4' => '拳王 ',
        '1-27' => '爪子 ', '4-17' => '將軍 ', '1-6' => '倩咪 ', '7-3' => '蘿絲 ', '11-25' => '火影彈', '3-15' => '春日櫻',
        '4-18' => '科迪 ', '9-15' => '卡琳 ', '3-15' => 'R.MIKA', '5-15' => 'ALEX', '12-6' => '伊吹 ', '1-1' => '茱莉 ',
        '12-7' => 'POISON', '1-11' => '古代人', '6-7' => '拉希德', '7-30' => '菈菈 ', '2-2' => '　方　', '9-3' => '　ED　',
        '10-16' => '阿比蓋', '12-29' => '是空 ', '5-25' => 'FALKE', '4-1' => '露西亞', '3-3' => 'AKIRA'
    ];

    // 印出表格及標題
    $calendar = "<table>" . "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th>$day</th>";
    }
    $calendar .= "</tr><tr>";

    // 根據$dayOfWeek的值(0~6)決定colspan要拉多長
    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan= '$dayOfWeek' ></td>";
    }
    for ($i = 1; $i <= $numberDays; $i++, $dayOfWeek++) {
        // $dayOfWeek達到7即歸零換行
        if ($dayOfWeek == 7) {
            $calendar .= "</tr><tr>";
            $dayOfWeek = 0;
        }
        if (is_numeric($i)) {
            $date = date("$month-") . $i;
        }
        if (isset($date) && array_key_exists($date, $specialDate)) {
            $calendar .= "<td class='specialday'> &nbsp;$i&nbsp; $specialDate[$date]生日</td>";
        } else {
            if (($dayOfWeek == 0) || ($dayOfWeek == 6)) {
                $calendar .= "<td class='holiday'> $i </td>";
            } else {
                $calendar .= "<td> $i </td>";
            }
        }
    }
    // 補足剩餘的空格
    if ($dayOfWeek != 7) {
        $calendar .= "<td colspan= " . (7 - $dayOfWeek) . "></td>";
    }
    $calendar .= "</tr></table>";
    ?>
    <script>
        function display_time() {
            var now = new Date();
            var hh = now.getHours();
            var mm = now.getMinutes();
            var ss = now.getSeconds();
            hh = check(hh);
            mm = check(mm);
            ss = check(ss);
            document.getElementById("clock").innerHTML = hh + ":" + mm + ":" + ss;
        }

        function check(a) {
            if (a < 10) return "0" + a;
            else return a;
        }

        window.onload = function() {
            setInterval(display_time, 500);
        }
    </script>
</head>

<body>
    <header class="header">
        <a href="index.php?year=<?= $lastyear; ?>&month=<?= $lastmonth; ?>"><?= $lastmonth; ?>月<i class="fas fa-chevron-circle-left"></i></a>
        <?= $year; ?>年<?= $month; ?>月
        <a href="index.php?year=<?= $nextyear; ?>&month=<?= $nextmonth; ?>"><i class="fas fa-chevron-circle-right"></i><?= $nextmonth; ?>月</a>
    </header>

    <?= $calendar; ?>

    <footer class="footer">
        現在是 <?= date("Y/n/j", time()); ?> <span id="clock">88:88:88</span>
    </footer>

</body>

</html>