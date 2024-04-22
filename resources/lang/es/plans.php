<?php

/*
 |--------------------------------------------------------------------------
 | Plans Language Lines
 |--------------------------------------------------------------------------
 |
 | Plans localization strings.
 | Replace the `null`s with the site's data.
 |
 */

return [
  'plan' => 'Plan|Planes',
  'count' => ':count plan|:count planes',

  'active-plan-count' => ':count plan activo|:count planes activos',

  'activate' => 'Activar plan',
  'create' => 'Crear plan',
  'deactivate' => 'Desactivar plan',
  'new' => 'Nuevo plan',

  'access-limited' => 'Acceso limitado',
  'access-total' => 'Acceso total',
  'active-status' => 'Estado',
  'active-status.active' => 'Activo',
  'active-status.inactive' => 'Inactivo',
  'basic' => 'Plan Básico',
  'go-to-public-page' => 'Ir a página de compra',
  'information' => 'Información',
  'monthly-price' => 'Costo mensual',
  'months' => 'Meses',
  'name' => 'ID',
  'no-expiration-date' => 'Sin fecha de expiración',
  'premium' => 'Plan Premium',
  'premium-benefits' => 'Ventajas del Plan Premium',
  'premium-benefits.description' => 'Accede a todas las funcionalidades de nuestra plataforma.',
  'premium-purchase-again' => 'Extender tu Plan Premium',
  'premium-purchase-again.description' => 'Extiende la duración del plan y sigue accediendo a todas las funcionalidades de ' . env('APP_NAME') . '.',
  'premium-upgrade-to' => 'Cambiar al Plan Premium',
  'premium-upgrade-to.description' => 'Accede a todas las funcionalidades de  ' . env('APP_NAME') . '.',
  'public-status.public' => 'Público',
  'public-status.private' => 'Privado',
  'title' => 'Título',
  'usage-count' => ':count uso|:count usos',
  'usages' => 'Usos',

  'features' => [
    'premium' => [
      'unlimited-casual-exams' => 'Exámenes estándar de 10, 50 y 100 preguntas sin límite',
      'unlimited-balanced-exams' => 'Exámenes realistas de 50 y 100 preguntas sin límite',
      'unlimited-category-exams' => 'Exámenes especializados sin límite',
      'full-exam-review' => 'Revisión de resultados completa',
      'full-statistics' => 'Análisis de progreso detallado',
    ],
  ],

  'form' => [
    'monthly-price' => [
      'label' => 'Costo mensual',
      'help' => 'En un plan privado, usualmente es S/ 0,00.',
    ],
    'months' => [
      'label' => 'Meses',
    ],
    'name' => [
      'label' => 'ID',
      'help' => 'Identificador único. En un plan público, conforma la URL. Sólo debe contener letras minúsculas, números y guiones ("-").',
      'placeholder' => 'x-meses-123abc',
    ],
    'public' => [
      'label' => 'Público o privado',
      'help' => 'Planes públicos pueden ser comprados por usuarios en la página web. Planes privados sólo pueden ser asignados manualmente por un administrador.',
      'public' => 'Público',
      'private' => 'Privado',
    ],
    'title' => [
      'label' => 'Título',
      'help' => 'En un plan público, es el nombre del "producto" que compra el usuario. No es necesario que sea único.',
      'placeholder' => 'Plan Premium (x meses)',
    ],
  ],

  'create-modal' => [
    'description-line-1' => 'Por favor asegúrate que todos los datos sean correctos antes de continuar.',
    'description-line-2' => 'El plan se creará en modo "inactivo". Lo deberás activar antes de que pueda ser usado.',
  ],
];
