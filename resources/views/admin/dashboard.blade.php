@extends('layouts.main')

@section('maincontent')
  <div class="container">
    <h2 class="fs-4 text-secondary my-4">
      {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
      <div class="col">
        <div class="card">
          <div class="card-header">{{ __('User Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            {{ __('You are logged in!') }}
          </div>
        </div>
      </div>
    </div>
    @include('admin.appartments.partials.statistics-graph')
  </div>
@endsection

@push('scripts')
  {{-- <script>
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

    console.log(getDateDiffObj('2024-01-15 13:00', '2024-03-02 13:00'))
  </script> --}}
@endpush
