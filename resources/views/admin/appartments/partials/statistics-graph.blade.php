<div class="container p-5">
  <h3 class="mb-5 text-center">Statistiche per appartamento</h3>
  <div class="row">
    <div class="col">
      <label for="start-date" class="form-label">Data di partenza</label>
      <input class="form-control mb-2" type="date" id="start-date">
    </div>
    <div class="col">
      <label for="end-date" class="form-label">Data di fine</label>
      <input class="form-control mb-2" type="date" id="end-date">
    </div>
    <div class="col">
      <label for="period" class="form-label">Tipo di visualizzazione</label>
      <select class="form-select mb-2" name="period" id="period">
        <option value="day">Giorni</option>
        <option value="month" selected>Mesi</option>
        <option value="year">Anni</option>
      </select>
    </div>
  </div>
  @if (isset($appartments))
    <label class="form-label mt-3">Seleziona gli appartamenti</label>
    <div class="row row-cols-3 g-3 mb-4">
      @foreach ($appartments as $appartment)
        <div class="col">
          <div data-app-id="{{ $appartment->id }}" data-app-is-active="false" class="text-center btn w-100 p-2 border border-1">{{ $appartment->title }}</div>
        </div>
      @endforeach
    </div>
  @endif
  <div>
    <div id='legend-container'></div>
    <canvas id="myChart"></canvas>
  </div>
</div>

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const route = {{ Illuminate\Support\Js::from(Route::current()->getName()) }}
    const isShow = route === 'admin.appartments.show';

    const ctx = document.getElementById('myChart');
    const viewsColors = [
      "#FF450080",
      "#0047AB80",
      "#32CD3280",
      "#FFD70080",
      "#80008080",
      "#00FFFF80",
      "#FF00FF80",
      "#FFA50080",
      "#4169E180",
      "#50C87880",
      "#FFF44F80",
      "#DC143C80",
      "#40E0D080",
      "#E6E6FA80",
      "#C0C0C080"
    ];

    const messagesColors = [
      "#FF250080",
      "#0027AB80",
      "#32AD3280",
      "#FFB70080",
      "#80208080",
      "#00DFFF80",
      "#FF20FF80",
      "#FFC50080",
      "#4149E180",
      "#50A87880",
      "#FFD44F80",
      "#DC343C80",
      "#40C0D080",
      "#E6C6FA80",
      "#C0A0C080"
    ];

    function removeHexOpacity(color) {
      color = color.substring(0, 7);
      color += 'FF'
      return color
    }


    const dtEndInput = document.getElementById('end-date');
    const dtStartInput = document.getElementById('start-date');
    const periodSelect = document.getElementById('period');
    const periodOpts = document.querySelectorAll('select#period > option');
    const appartmentEls = document.querySelectorAll('[data-app-id]');
    const appartmentBorderEls = document.querySelectorAll('[data-border-app-id]');

    let dtEnd = {{ Illuminate\Support\Js::from($dtEnd) }}
    let dtStart = {{ Illuminate\Support\Js::from($dtStart) }}

    dtEndInput.value = dtEnd.substring(0, 10);
    dtStartInput.value = dtStart.substring(0, 10);

    let allViews = {{ Illuminate\Support\Js::from($appartments_views) }};
    allViews = JSON.parse(allViews);

    let allMessages = {{ Illuminate\Support\Js::from($appartments_messages) }};
    allMessages = JSON.parse(allMessages);

    let datasets = [];
    let labels = setLabels('month', dtStart, dtEnd);

    allMessages.forEach((appartment, index) => {
      const sumViews = sumViewsPerInterval('month', dtStart, dtEnd, appartment.messages);
      let i = index
      while (viewsColors[i] === undefined) {
        i = i - viewsColors.length;
      }
      console.log(appartment.id)
      datasets.push({
        type: 'line',
        label: 'Messaggi ' + appartment.title,
        data: sumViews.resData,
        borderWidth: 1,
        hidden: !isShow,
        borderColor: removeHexOpacity(messagesColors[i]),
        backgroundColor: removeHexOpacity(messagesColors[i]),
        borderWidth: 4,
      })
    })

    allViews.forEach((appartment, index) => {
      const sumViews = sumViewsPerInterval('month', dtStart, dtEnd, appartment.views, 10);
      let i = index
      while (viewsColors[i] === undefined) {
        i = i - viewsColors.length;
      }

      // console.log(appartment.id)
      datasets.push({
        label: 'Views ' + appartment.title,
        data: sumViews.resData,
        borderWidth: 1,
        hidden: !isShow,
        borderColor: viewsColors[i],
        backgroundColor: viewsColors[i],
      })
    })

    // creo la tabella
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: datasets
      },
      options: {
        plugins: {
          legend: {
            display: isShow,
          }
        },
        scales: {
          y: {

            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          },
          x: {

            // max: 'Maggio'
          }
        }
      }
    });

    dtEndInput.addEventListener('change', function() {
      const dtStart = dtStartInput.value;
      const dtEnd = dtEndInput.value;
      let interval;
      periodOpts.forEach((opt) => {
        if (opt.selected) interval = opt.value;
      })
      updateData(chart, interval, dtStart, dtEnd);
    })

    dtStartInput.addEventListener('change', function() {
      const dtStart = dtStartInput.value;
      const dtEnd = dtEndInput.value;
      let interval;
      periodOpts.forEach((opt) => {
        if (opt.selected) interval = opt.value;
      })
      updateData(chart, interval, dtStart, dtEnd);
    })

    periodSelect.addEventListener('change', function() {
      const dtStart = dtStartInput.value;
      const dtEnd = dtEndInput.value;
      let interval;
      periodOpts.forEach((opt) => {
        if (opt.selected) interval = opt.value;
      })
      updateData(chart, interval, dtStart, dtEnd);
    })

    appartmentEls.forEach((appEl, index) => {
      appEl.addEventListener('click', function() {
        const id = appEl.getAttribute('data-app-id');
        const messagesDataset = chart.data.datasets[index];
        const viewsDataset = chart.data.datasets[index + appartmentEls.length];
        let viewsColor = viewsDataset.backgroundColor
        let messagesColor = viewsColor

        if (viewsDataset.hidden && messagesDataset.hidden) {
          appEl.setAttribute('data-app-is-active', 'true');
          appEl.style.backgroundColor = viewsColor;
          appEl.style.fontWeight = 'bold';
        } else {
          appEl.setAttribute('data-app-is-active', 'false');
          appEl.style.removeProperty('background-color');
          appEl.style.removeProperty('font-weight');

        }

        viewsDataset.hidden = !viewsDataset.hidden;
        messagesDataset.hidden = !messagesDataset.hidden;

        console.log(viewsDataset.backgroundColor);
        chart.update();
      })
    })



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
    function sumViewsPerInterval(interval, date1, date2, views_time, modifier = 1) {
      // recuperero le date views formattate
      const getViewsRes = getViews(views_time);
      const views = getViewsRes[1];

      // recupero l'oggetto dell'intervallo
      const maxDate = date1 >= date2 ? date1 : date2;
      const minDate = date1 < date2 ? date1 : date2;
      const period = getDateDiffObj(minDate, maxDate);

      // inizializzo le variabili
      const viewsData = [];
      let countView = 0;
      const data = [];
      const resData = [];
      let iIndex;
      let viewParentKey;
      let viewChildKey;

      // inizializzo variabili per periodo
      if (interval === 'day') {
        iIndex = period.days.length;
        parentKey = 'days';
        childKey = 'date';
      }
      if (interval === 'month') {
        iIndex = period.months.length;
        parentKey = 'months';
        childKey = 'dateMonth';
      }
      if (interval === 'year') {
        iIndex = period.years.length;
        parentKey = 'years';
        childKey = 'year';
      }

      // inizializzo dati per gli assi
      for (let i = 0; i < iIndex; i++) {
        data[i] = {};
        data[i].x = period[parentKey][i];
        data[i].y = 0;
      }

      // popolo i dati per l'asse y
      views.forEach((view) => {
        if (view.date <= maxDate && view.date >= minDate) {
          const periodIndex = period[parentKey].indexOf(view[childKey]);
          data[periodIndex].y += modifier;
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
    function setLabels(interval, date1, date2) {
      let labelArray = [];
      const maxDate = date1 >= date2 ? date1 : date2;
      const minDate = date1 < date2 ? date1 : date2;
      const period = getDateDiffObj(minDate, maxDate);

      if (interval === 'day') {
        iIndex = period.days.length;
        parentKey = 'days';
      }
      if (interval === 'month') {
        iIndex = period.months.length;
        parentKey = 'months';
      }
      if (interval === 'year') {
        iIndex = period.years.length;
        parentKey = 'years';
      }

      for (let i = 0; i < iIndex; i++) {
        labelArray.push(period[parentKey][i]);
      }

      return labelArray;
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
      obj.dateMonth = obj.year + '-' + (obj.month < 10 ? '0' + obj.month : obj.month);
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

    function updateData(chart, interval, dtStart, dtEnd) {
      chart.data.labels = setLabels(interval, dtStart, dtEnd)
      const datasets = [];

      allMessages.forEach((appartment, index) => {
        const sumViews = sumViewsPerInterval(interval, dtStart, dtEnd, appartment.messages);
        const appEl = document.querySelector(`[data-app-id="${appartment.id}"]`);
        const active = (appEl ? appEl.getAttribute('data-app-is-active') : 'true') === 'true';
        let i = index
        while (viewsColors[i] === undefined) {
          i = i - viewsColors.length;
        }
        datasets.push({
          type: 'line',
          label: 'Messaggi ' + appartment.title,
          data: sumViews.resData,
          borderWidth: 1,
          hidden: !active,
          borderColor: removeHexOpacity(messagesColors[i]),
          backgroundColor: removeHexOpacity(messagesColors[i]),
          borderWidth: 4,
        })
      })

      allViews.forEach((appartment, index) => {
        const sumViews = sumViewsPerInterval(interval, dtStart, dtEnd, appartment.views, 10);
        const appEl = document.querySelector(`[data-app-id="${appartment.id}"]`);
        const active = (appEl ? appEl.getAttribute('data-app-is-active') : 'true') === 'true';
        let i = index
        while (viewsColors[i] === undefined) {
          i = i - viewsColors.length;
        }
        datasets.push({
          label: 'Views ' + appartment.title,
          data: sumViews.resData,
          borderWidth: 1,
          hidden: !active,
          borderColor: viewsColors[i],
          backgroundColor: viewsColors[i],
        })
      })



      chart.data.datasets = datasets;

      chart.update();
    }

    //---
  </script>
@endpush
