<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Document</title>
</head>
<body>
<div>
    <div class="container">
        <div class="row">
  <div class=" col-12 col-lg-6  ">
    <div class="card ">
      <div class="card-body">
        
      <h5 class="card-title ">Special title treatment</h5>
      <canvas id="myChart" class=" "></canvas>
      </div>
    </div>
  </div>
  
  
        </div>
  
</div>
<script>
  const ctx = document.getElementById('myChart');
  const MONTHS = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December'
];

function months(config) {
  var cfg = config || {};
  var count = cfg.count || 12;
  var section = cfg.section;
  var values = [];
  var i, value;

  for (i = 0; i < count; ++i) {
    value = MONTHS[Math.ceil(i) % 12];
    values.push(value.substring(0, section));
  }

  return values;
}
  const labels = months({count: 12});


new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels ,
      datasets: [{
        label: 'Sales',
        data: [12, 19, 3, 5000, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        }
      }
    }
  });
</script>
</body>
</html>