<div class="container p-5">
  <div>
    <canvas id="myChart"></canvas>
  </div>
</div>

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('myChart');

    let allViews = {{ Illuminate\Support\Js::from($appartments_views) }};
    allViews = JSON.parse(allViews);

    let allMessages = {{ Illuminate\Support\Js::from($appartments_messages) }};
    allMessages = JSON.parse(allMessages);

    let datasets = [];
    let labels = setLabels('year');

    // console.log(allViews);

    allViews.forEach((appartment) => {
      const sumViews = sumViewsPerInterval('year', '2024', appartment.views);
      datasets.push({
        label: 'Views ' + appartment.title,
        data: sumViews.resData,
        borderWidth: 1,
        stack: appartment.id
      })
    })

    allMessages.forEach((appartment) => {
      const sumViews = sumViewsPerInterval('year', '2024', appartment.messages);
      datasets.push({
        label: 'Messaggi ' + appartment.title,
        data: sumViews.resData,
        borderWidth: 1,
        stack: appartment.id
      })
    })


    // console.log(views_time);

    //--- DEFINISCO IL TIPO DI GRAFICO
    // const sumViews = sumViewsPerInterval('year', '2024'); // per anno
    // const sumViews = sumViewsPerInterval('month', '11-2023'); // per mese
    // const sumViews = sumViewsPerInterval('day', '2024-05-14'); // per giorno

    // creo la tabella
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: datasets
      },
      options: {
        scales: {
          y: {
            stacked: true,
            beginAtZero: true,
            ticks: {
              stepSize: 100
            }
          },
          x: {
            stacked: true,
            max: 'Maggio'
          }
        }
      }
    });


    // FUNZIONI

    /**
     * param dateTimes: Array di stringhe (date views)
     * 
     * return: Array 
     *  [0] totale delle views
     *  [1] views formattate oggetto
     */
    function getViews(dateTimes) {
      const totViews = dateTimes.length;

      // formatto le date in oggetti con proprietà data suddivise
      const views = [];
      dateTimes.forEach(date => {
        const dateView = new Date(Date.parse(date));
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

      return [totViews, views];
    }

    /**
     * param interval: Enum Periodo ('year', 'month', 'day')
     * param date: La data da considerare ('yyyy', 'mm-yy', 'yyyy-mm-dd')
     * param views_time: Array di date in cui son state effettuate le views
     * 
     * return: Object 
     *  resData: views per data/mese/anno
     *  totViews: views totali nell'intervallo
     */
    function sumViewsPerInterval(interval, date, views_time) {
      // recuperero le date views formattate
      const getViewsRes = getViews(views_time);
      const views = getViewsRes[1];

      // inizializzo le variabili
      const viewsData = [];
      let countView = 0;
      const data = {};
      const resData = [];
      let iIndex;
      let viewParentKey;
      let viewChildKey;

      // inizializzo variabili per periodo
      if (interval === 'day') {
        iIndex = 24;
        viewParentKey = 'date';
        viewChildKey = 'hours';
      }
      if (interval === 'month') {
        iIndex = 31;
        viewParentKey = 'dateMonth';
        viewChildKey = 'day';
      }
      if (interval === 'year') {
        iIndex = 12;
        viewParentKey = 'year';
        viewChildKey = 'month';
      }

      // inizializzo dati per gli assi
      for (let i = 1; i <= iIndex; i++) {
        data[i] = {};
        data[i].x = setLabels(interval)[i - 1];
        data[i].y = 0;
      }

      // popolo i dati per l'asse y
      views.forEach((view) => {
        if (view[viewParentKey] == date) {
          data[view[viewChildKey]].y += 1;
          countView++;
        }
      });

      // aggrego i risultati
      for (const key in data) {
        resData.push(data[key]);
      }

      // ritorno i risultati
      return {
        resData,
        totViews: countView
      };

    }

    /**
     * param interval: Enum Periodo ('year', 'month', 'day')
     * 
     * return: Array delle labels
     */
    function setLabels(interval) {
      let labelArray = [];
      if (interval === 'day') {
        for (let i = 1; i <= 24; i++) {
          const h = i < 10 ? `0${i}:00` : `${i}:00`;
          labelArray.push(h);
        }
      }
      if (interval === 'month') {
        for (let i = 1; i <= 31; i++) {
          const d = i < 10 ? `0${i}` : `${i}`;
          labelArray.push(d);
        }
      }
      if (interval === 'year') {
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

      return labelArray;
    }
  </script>
@endpush
