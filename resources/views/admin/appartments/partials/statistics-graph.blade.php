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
      dateTimes.forEach((date) => {
        // const dateView = new Date(Date.parse(date));
        // const obj = {};
        // obj.hours = dateView.getHours();
        // obj.minutes = dateView.getMinutes();
        // obj.day = dateView.getDate();
        // obj.month = dateView.getMonth() + 1;
        // obj.year = dateView.getFullYear();
        // obj.date = obj.year + '-' + (obj.month < 10 ? '0' + obj.month : obj.month) + '-' + (obj.day < 10 ? '0' + obj.day : obj.day);
        // obj.dateMonth = (obj.month < 10 ? '0' + obj.month : obj.month) + '-' + obj.year;
        // obj.dateTime = obj.date + ' ' + obj.hours + ':' + obj.minutes;

        views.push(parseDateObj(date));
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

    function getDateDiffObj(date1, date2) {
      const maxDate = parseDateObj(date1 >= date2 ? date1 : date2);
      const minDate = parseDateObj(date1 < date2 ? date1 : date2);

      const years = [];
      let year = minDate.year;
      while (year <= maxDate.year) {
        years.push(year);
        year++;
      }

      return years;
    }

    function parseDateObj(date) {
      const dateView = new Date(Date.parse(date));
      const obj = {};
      obj.hours = dateView.getHours();
      obj.minutes = dateView.getMinutes();
      obj.day = dateView.getDate();
      obj.month = dateView.getMonth() + 1;
      obj.year = dateView.getFullYear();
      obj.date = obj.year + '-' + (obj.month < 10 ? '0' + obj.month : obj.month) + '-' + (obj.day < 10 ? '0' + obj.day : obj.day);
      obj.dateMonth = (obj.month < 10 ? '0' + obj.month : obj.month) + '-' + obj.year;
      obj.dateTime = obj.date + ' ' + (obj.hours < 10 ? '0' + obj.hours : obj.hours) + ':' + (obj.minutes < 10 ? '0' + obj.minutes : obj.minutes);

      return obj;
    }

    function twoDigits(n) {
      return n < 10 ? '0' + n : n;
    }

    function getDateDiffObj(date1, date2) {
      const maxDate = parseDateObj(date1 >= date2 ? date1 : date2);
      const minDate = parseDateObj(date1 < date2 ? date1 : date2);

      const years = [];
      const months = [];
      const days = [];
      const hours = [];

      let year = minDate.year;
      while (year <= maxDate.year) {
        years.push(year);
        year++;
      }

      years.forEach((year) => {

        let month = minDate.year >= year ? minDate.month : 1;

        while ((month <= 12 && year < maxDate.year) || (month <= maxDate.month)) {
          months.push(year + '-' + twoDigits(month));
          month++;
        }
      })

      months.forEach((month) => {
        let day = minDate.dateMonth >= month ? minDate.day : 1;

        const strMonth = month.substring(5, 7)
        let nDays;
        let m30 = ['11', '04', '06', '09'];
        let m28 = ['02'];

        if (m30.includes(strMonth)) {
          nDays = 30;
        } else if (m28.includes(strMonth)) {
          if (parseInt(month.substring(0, 4)) % 4 == 0) {
            nDays = 29
          } else {
            nDays = 28
          }
        } else {
          nDays = 31;
        }

        while ((day <= nDays && month < maxDate.dateMonth) || (day <= maxDate.day)) {
          days.push(month + '-' + twoDigits(day));
          day++;
        }

      })

      return {
        years,
        months,
        days,
      };
    }
  </script>
@endpush
