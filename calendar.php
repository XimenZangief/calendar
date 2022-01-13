<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>線上萬年曆</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="calendar.css">
    <script src="clock.js"></script>
    <?php
    date_default_timezone_set('Asia/Taipei'); //取得時區並在開啟時填入年月
    // $year = date('Y');
    // $month = date('m');
    if (isset($_GET['month'])) {
        $month = $_GET['month'];
        $year = $_GET['year'];
    } else {
        $month = date("m");
        $year = date("Y");
    }

    $lastmonth = $month - 1;    //事先處理上下個月的顯示
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

    // 印出表格及標題(使用 .= 處理)
    $calendar = "<table>" . "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th>$day</th>";
    }
    $calendar .= "</tr><tr>";

    // 根據$dayOfWeek的值(0~6)決定colspan要拉多長
    if ($dayOfWeek > 0) {
        $calendar .= "<td class='span' colspan= '$dayOfWeek'></td>";
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
        $calendar .= "<td  class='span' colspan= " . (7 - $dayOfWeek) . "></td>";
    }
    $calendar .= "</tr></table>";
    ?>
</head>

<body onload="startTime()">
    <header class="header">
        <a href="index.php?year=<?= $lastyear; ?>&month=<?= $lastmonth; ?>"><?= $lastmonth; ?> 月<i class="fas fa-chevron-circle-left"></i></a>
        <?= $year; ?>年<?= $month; ?>月
        <a href="index.php?year=<?= $nextyear; ?>&month=<?= $nextmonth; ?>"><i class="fas fa-chevron-circle-right"></i><?= $nextmonth; ?> 月</a>
    </header>

    <?= $calendar; ?>

    <footer class="footer">
        <?= date(" Y / n / j ", time()); ?>&nbsp;&nbsp;&nbsp;<span id="clock">88:88:88</span>
    </footer>
</body>

</html>