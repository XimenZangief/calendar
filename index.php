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
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            text-align: center;
            font-family: 'Courier New', 'Courier', 'monospace';
            font-size: 1.5rem;
            font-weight: bold;
        }

        .month-change {
            width: 60%;
            background-color: skyblue;
            border-radius: 20px 20px;
            color: wheat;
            padding: 50px 0;
            margin: 1rem auto;
            font-size: 5.5rem;
            text-shadow: 2px 2px 5px grey;
        }
        table {
            width: 60vw;
            height: 50vh;
            margin: 20px auto 0;
            padding: 20px;
        }

        td {
            padding: 10px;
            border: 1px double black;
            font-size: 1.5rem;
        }

        td:hover {
            border: 1px double black;
            border-radius: 30px;
            background-color: black;
            color: whitesmoke;
            cursor: cell;
            font-size: 1.5em;
            padding: 0;
        }

        .holiday {
            background-color: pink;
        }
        .holiday:hover{
            background-color: skyblue;
            color:red;
            text-shadow: black 2px 2px;
        }

        a {
            text-decoration: none;
            font-size: 2rem;
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
        if (($dayOfWeek == 0) || ($dayOfWeek == 6)) {
            $calendar .= "<td class='holiday'> $i </td>";
        } else {
            $calendar .= "<td> $i </td>";
        }
    }
    // 補足剩餘的空格
    if ($dayOfWeek != 7) {
        $calendar .= "<td colspan= " . (7 - $dayOfWeek) . "></td>";
    }
    $calendar .= "</tr></table>";
    ?>
</head>

<body>
    <div class="month-change">
        <a href="index.php?year=<?= $lastyear; ?>&month=<?= $lastmonth; ?>"><?= $lastmonth ;?>月<i class="fas fa-chevron-circle-left"></i></a>
        <?=$year;?>年<?=$month;?>月
        <a href="index.php?year=<?= $nextyear; ?>&month=<?= $nextmonth; ?>"><i class="fas fa-chevron-circle-right"></i><?= $nextmonth ;?>月</a>
    </div>
    <?= $calendar; ?>
</body>

</html>