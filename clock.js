function startTime() {
  var today = new Date();
  var hh = today.getHours();
  var mm = today.getMinutes();
  var ss = today.getSeconds();
  mm = checkTime(mm);
  ss = checkTime(ss);
  document.getElementById('clock').innerHTML = hh + " : " + mm + " : " + ss;
  var timeoutId = setTimeout(startTime, 500);
}

function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}