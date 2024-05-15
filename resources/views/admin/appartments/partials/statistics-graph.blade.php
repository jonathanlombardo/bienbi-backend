<div class="container p-5">
  <div>
    <canvas id="myChart"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('myChart');
    let views_time = {{ Illuminate\Support\Js::from($appartment_views) }};
    views_time = JSON.parse(views_time);

    console.log(views_time);

    //--- DEFINISCO IL TIPO DI GRAFICO
    const sumViews = sumViewsPerInterval('year', '2024');
    // const sumViews = sumViewsPerInterval('month', '11-2023');
    // const sumViews = sumViewsPerInterval('day', '2024-05-14');

    // creo la tabella
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: sumViews.labels,
        datasets: [{
          label: 'Visualizzazioni 2024',
          data: sumViews.resData,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 100
            }
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

        console.log(date);
        // la separo in vari campi di tipo numerico
        views.push({
          hours: dateView.getHours(),
          minutes: dateView.getMinutes(),
          day: dateView.getDate(),
          month: dateView.getMonth() + 1,
          year: dateView.getFullYear(),
          date: dateView.getFullYear() + '-' + (dateView.getMonth() < 10 ? '0' + (dateView.getMonth() + 1) : dateView.getMonth() + 1) + '-' + (dateView.getDate() < 10 ? '0' + dateView.getDate() : dateView.getDate()),
          dateMonth: (dateView.getMonth() < 10 ? '0' + (dateView.getMonth() + 1) : dateView.getMonth() + 1) + '-' + dateView.getFullYear()
        });
      });
      // console.log(dateTimes, totViews, views);
      return [totViews, views];
    }


    function sumViewsPerInterval(interval, date) {
      const getViewsRes = getViews(views_time);
      const views = getViewsRes[1];
      const viewsData = [];
      let countView = 0;
      const data = {};
      const resData = [];
      // const resLabel = [];

      let iIndex;
      let viewParentKey;
      let viewChildKey;
      let labelArray = [];

      if (interval === 'day') {
        iIndex = 24;
        viewParentKey = 'date';
        viewChildKey = 'hours';
        for (let i = 1; i <= iIndex; i++) {
          const h = i < 10 ? `0${i}:00` : `${i}:00`;
          labelArray.push(h);
        }
      }
      if (interval === 'month') {
        iIndex = 31;
        viewParentKey = 'dateMonth';
        viewChildKey = 'day';
        for (let i = 1; i <= iIndex; i++) {
          const d = i < 10 ? `0${i}` : `${i}`;
          labelArray.push(d);
        }
      }
      if (interval === 'year') {
        iIndex = 12;
        viewParentKey = 'year';
        viewChildKey = 'month';
        labelArray = [
          "Gennaio",
          "Febbraio",
          "Marzo",
          "Aprile",
          "Maggio",
          "Giugno",
          "Luglio",
          "Agosto",
          "Settembre",
          "Ottobre",
          "Novembre",
          "Dicembre"
        ]
      }


      for (let i = 1; i <= iIndex; i++) {
        data[i] = {};
        data[i].x = labelArray[i - 1];
        data[i].y = 0;
      }
      views.forEach((view) => {
        if (view[viewParentKey] == date) {
          data[view[viewChildKey]].y += 1;
          countView++;
        }
      });


      for (const key in data) {
        resData.push(data[key]);
      }

      const labels = resData.map((res) => {
        return res.x;
      })

      console.log(labelArray)

      return {
        resData,
        labels: labelArray,
        totViews: countView
      };

    }
  </script>

</div>
