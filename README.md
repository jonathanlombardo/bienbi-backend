# BienBì

### About BienBì

The app provide a quick and easy way to connect host and guest of short-term letting. Host will be able to sign-up and add all appartments that he wants to rent out. He can add one or several service for each appartment, geolocate it, traks views and messages and he can also pay for one of provided plan in order to highlight the appartment.

---

### Tecnologies

The app is developed with <b>[Laravel and Blade](https://laravel.com/)</b> and it provides several API in order to connect a third part frontend.

-   Style

    The app is styled via [SASS SCSS](https://sass-lang.com/) thanks to [Vite](https://vitejs.dev/) preprocessor. [Boostrap](https://getbootstrap.com/) styles and scripts are also integrated.

-   Geolocation

    The geolocation was implemented through [TomTom APIs and SDKs](https://developer.tomtom.com/) in order to provide a reliable position.

-   Payments

    All payment transaction was implemented via [Braintree](https://www.braintreepayments.com/it) that offers a safety way to pay.

-   Statistics

    Statistics graphs was implemented using [Chart.js](https://www.chartjs.org/)

---

### Init project

<p>Project already contain Boostrapp an Scss. Run following command in order to init project correctly</p>

> remember to set a .env file

#### Init and run frontend

`npm i` <br>
`npm run dev`

#### Init and run backend

`composer i`<br>
`php artisan key:generate`<br>
`php artisan serve`

#### Use Braintree

In order to use Braintree payment system add `gatewayInfo.php` file in /`app/config` path setted as below:

```php
<?php

return [
  'environment' => 'sandbox',
  'merchantId' => 'YOUR_MERCHANT_ID',
  'publicKey' => 'YOUR_PUBLIC_KEY',
  'privateKey' => 'YOUR_PRIVATE_KEY'
];
```
