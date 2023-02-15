<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;

Route::get('/', function () {
    return view('/countries-list');
});

//CARGA DEL INDEX
Route::get('/countries-list',[CountriesController::class, 'index'])->name('countries.list');
//AGREGAR NUEVO PAIS
Route::post('/add-country',[CountriesController::class, 'addCountry'])->name('add.country');
//LISTADO DE TODOS LOS PAISES
Route::get('/getCountriesList',[CountriesController::class, 'getCountriesList'])->name('get.countries.list');
//ACTUALIZAR PAIS
Route::post('/getCountryDetails',[CountriesController::class, 'getCountryDetails'])->name('get.country.details');
Route::post('/updateCountryDetails',[CountriesController::class, 'updateCountryDetails'])->name('update.country.details');
//ELIMINAR PAIS
Route::post('/deleteCountry',[CountriesController::class,'deleteCountry'])->name('delete.country');
Route::post('/deleteSelectedCountries',[CountriesController::class,'deleteSelectedCountries'])->name('delete.selected.countries');