<html>
<head>
  <title>萬年曆作業</title>
  <style>
    /*請在這裹撰寫你的CSS*/
    * {
      text-align: center;
    }
  </style>
</head>

<body>
  <h1>萬年曆</h1>
  <?php
  /*請在這裹撰寫你的萬年曆程式碼*/
  date_default_timezone_set('Asia/Taipei');
  $year = date('Y');
  $month = date('m');

  // 星期日~六做成陣列
  $daysOfWeek = array('日', '一', '二', '三', '四', '五', '六');
  echo '<pre>';
  print_r($daysOfWeek);
  echo '</pre>';

  // 創造當月一號的資料  mktime(H, i, s, m, d, Y)
  $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

  // 將當月一號的資料存成陣列
  $dateComponents = getdate($firstDayOfMonth);
  // 取得$dateComponents陣列中key=>month的值(英文月份全名)
  $monthName = $dateComponents['month'];
  // 取得$dateComponents陣列中key=>wday的值(星期0~6)
  $dayOfWeek = $dateComponents['wday'];
  echo '<pre>';
  print_r($dateComponents);
  echo '</pre>';

  // 抓當月有幾天
  $numberDays = date('t', $firstDayOfMonth);

  // 印出表格及標題
  $calendar = "<table>" .
    "<b> $monthName $year </b>" .
    "<tr>";
  foreach ($daysOfWeek as $day) {
    $calendar .= "<th>$day</th>";
  }
  $calendar .= "</tr><tr>";

  ?>

</body>
<html>