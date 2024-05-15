<div class="container p-5">
  <div>
    <canvas id="myChart"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('myChart');

    let views_time = <?php echo $appartment_views; ?>;

    sumViewsPerInterval('intervallo');

    const year = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
    const day = ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'];

    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: year,
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });



    // FUNZIONI

    //funzione per recuperare il totale delle views e le views con parametri temporali distinti a partire dalle date in formato stringa passate come parametro
    function getViews(dateTimes) {
      // calcolo il totale delle view per appartamento
      const totViews = dateTimes.length;

      // compongo un insieme di views con i campi della data separati
      const views = [];
      dateTimes.forEach(date => {
        // recupero la data della view
        const dateView = new Date(Date.parse(date));
        // la separo in vari campi di tipo numerico
        views.push({
          hours: dateView.getHours(),
          minutes: dateView.getMinutes(),
          day: dateView.getDate(),
          month: dateView.getMonth(),
          year: dateView.getFullYear(),
        });
      });
      return [totViews, views];
      // console.log(dateTimes, totViews, views);
    }

    function sumViewsPerInterval(interval) {
      const views = getViews(views_time)[1];
      const viewsData = [];
      let countView = 0;
      views.forEach(view => {
        if (interval === 'day') {
          for (let i = 0; i < 46; i + 2) {
            if (view.hours === i) {
              if (views.minutes >= 30) {
                viewsData[i + 1] = countView++;
              }
            } else {
              viewsData[i] = countView++;
            }
            countView = 0
          }
        }
        if (interval === 'week') {
          return
        }
        if (interval === 'month') {
          return
        }
        if (interval === 'year') {
          return
        }
      });
    }


    function changeTime(e, legendItem, legend) {
      console.log(e, legendItem, legend);
      const index = legendItem.datasetIndex;
      const ci = legend.chart;
      if (ci.isDatasetVisible(index)) {
        ci.hide(index);
        legendItem.hidden = true;
      } else {
        ci.show(index);
        legendItem.hidden = false;
      }
    }
    // changeTime(null, null, chart.options.plugins.legend);
  </script>

</div>