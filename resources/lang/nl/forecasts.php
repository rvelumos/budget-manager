<?php

return [
    'title' => 'Voorspellingen',
    'index_title' => 'Overzicht van voorspellingen',
    'create_title' => 'Voorspelling toevoegen',
    'edit_title' => 'Voorspelling bewerken',
    'show_title' => 'Details van voorspelling',
    'no_data_message' => 'Geen voorspellingen gevonden.',

    'fields' => [
        'forecast_period_start' => 'Startdatum',
        'forecast_period_end' => 'Einddatum',
        'expected_income' => 'Verwacht inkomen',
        'expected_expenses' => 'Verwachte uitgaven',
        'net_forecast' => 'Netto voorspelling',
        'accuracy_rate' => 'Nauwkeurigheidspercentage',
        'categories' => 'Categorieën',
    ],

    'actions' => [
        'create' => 'Toevoegen',
        'edit' => 'Bewerken',
        'delete' => 'Verwijderen',
        'view' => 'Bekijken',
        'back' => 'Terug naar overzicht',
    ],

    'messages' => [
        'created' => 'Voorspelling succesvol toegevoegd.',
        'updated' => 'Voorspelling succesvol bijgewerkt.',
        'deleted' => 'Voorspelling succesvol verwijderd.',
        'not_found' => 'Voorspelling niet gevonden.',
    ],

    'errors' => [
        'forecast_limit_exceeded' => 'U kunt niet meer dan 10 voorspellingen maken.',
        'invalid_period' => 'De startdatum moet vóór de einddatum liggen.',
    ],
];
