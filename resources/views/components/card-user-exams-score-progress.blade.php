<div class="card mb-4">
  <div class="card-body">
    <h3 class="mb-3">{{ $headline }}</h3>

    @if ($user->exams->whereNotNull("completed_at")->count() < 2)
    <span class="text-muted">Completa al menos 2 exámenes para ver tu progreso.</span>
    @elseif ($chartData->count() < 2)
    <span class="text-muted">Completa más exámenes para ver tu progreso.</span>
    @else

    <div class="chart-lg">
      <canvas id="chart-user-exams-score-progress"></canvas>
    </div>
    @endif
  </div>
</div>

<script>
  function drawUserExamsScoreProgressChart() {
    if (typeof Chart !== "undefined") {
      var chartData = JSON.parse('{!! $chartData !!}');
      var ctx = document.getElementById('chart-user-exams-score-progress');

      var config = {
        type: 'line',
        data: {
          datasets: [{
            backgroundColor: "rgba(2, 85, 81, 0.25)",
            borderColor: "#02555b",
            borderWidth: 2,
            fill: true,
            label: 'Puntuación',
            pointBackgroundColor: '#02555b',
            data: chartData.map(({
              x,
              y
            }) => ({
              x: new Date(x),
              y: y
            })),
          }]
        },
        options: {
          legend: {
            display: false,
          },
          tooltips: {
            enabled: false,
          },
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            xAxes: [{
              type: 'time',
              distribution: 'series',
              time: {
                displayFormats: {
                  'day': 'DD/MM/YYYY',
                  'week': 'DD/MM/YYYY',
                  'month': 'MM/YYYY',
                  'quarter': 'MM/YYYY',
                  'year': 'MM/YYYY',
                },
                minUnit: 'day',
              }
            }],
            yAxes: [{
              ticks: {
                callback: function(value, index, values) {
                  return value + '%';
                },
                suggestedMax: 100,
              }
            }]
          }
        }
      };

      new Chart(ctx, config);
    } else {
      setTimeout(drawUserExamsScoreProgressChart, 250);
    }
  };

  drawUserExamsScoreProgressChart();
</script>
