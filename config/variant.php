<?php

/*
  |-----------------------------------------------------------------------------
  | Application Variant
  |-----------------------------------------------------------------------------
  |
  | These values define the variant of the application. They are used to
  | identify the site's product (like ENAM, ENAE or ENAO) and affect what
  | content is displayed and its design.
  |
  */

return [
  'name' => env('VARIANT_NAME'),

  'colors' => [
    'primary' => env('VARIANT_COLOR_PRIMARY'),
  ],

  'regular_monthly_price' => env('VARIANT_REGULAR_MONTHLY_PRICE'),
];
