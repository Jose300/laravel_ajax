<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use DataTables;

class CountriesController extends Controller
{
    //LISTADO DE PAISES
    public function index(){

        return view('countries-list');
    }


    //AGREGAR PAISES
    public function addCountry(Request $request){

        $validator = \Validator::make($request->all(),[
            'country_name'=>'required|unique:countries',
            'capital_city'=>'required',
        ]);

        if(!$validator->passes()){

            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);

        }else{

            //SE REALIZA EL GUARDADO DEL NUEVO PAIS
            $country = new Country();
            $country->country_name = $request->country_name;
            $country->capital_city = $request->capital_city;
            $query = $country->save();

            if(!$query){
                //SI HAY ALGUN ERROR RETORNAMOS EL CODIGO CON VALOR 0 Y EL MENSAJE AL JSON
                return response()->json(['code'=>0, 'msg'=>'Algo Salio Mal']);

            }else{
                //SI TODO SALE BIEN SE ENVIA EL CODIGO 1 Y EL MENSAJE DEL GUARDADO CORRECTO
                return response()->json(['code'=>1, 'msg'=>'El Nuevo País ha sido Agregado con Éxito']);
            }


        }
    }


    //OBTENER LISTADO DE TODOS LOS REGISTROS DE PAISES
    public function getCountriesList(){
        $countries = Country::all();
        return DataTables::of($countries)
                            ->addIndexColumn()
                            ->addColumn('actions', function($row){
                                return '<div class="btn-group">
                                        <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editCountryBtn">Actualizar</button>
                                        <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteCountryBtn">Eliminar</button>
                                </div>';
                            })
                            ->addColumn('checkbox', function($row){
                                  return '<input type="checkbox" name="country_checkbox" data-id="'.$row['id'].'"><label></label>';
                              })
                            ->rawColumns(['actions','checkbox'])
                            ->make(true);
    }


    public function getCountryDetails(Request $request){
        $country_id = $request->country_id;
        $countryDetails = Country::find($country_id);
        return response()->json(['details'=>$countryDetails]);
    }


    //ACTUALIZAR LA INFORMACION DEL PAIS
    public function updateCountryDetails(Request $request){
        $country_id = $request->cid;

        $validator = \Validator::make($request->all(),[
            'country_name'=>'required|unique:countries,country_name,'.$country_id,
            'capital_city'=>'required'
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
            $country = Country::find($country_id);
            $country->country_name = $request->country_name;
            $country->capital_city = $request->capital_city;
            $query = $country->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'La Informacion del País ha sido actualizada']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Error al intentar actualizar la información']);
            }
        }
    }


    // ELIMINAR PAIS
    public function deleteCountry(Request $request){
        $country_id = $request->country_id;
        $query = Country::find($country_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'El País ha sido eliminado de la Base de Datos']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Error al intentar eliminar la información']);
        }
    }


    public function deleteSelectedCountries(Request $request){
       $country_ids = $request->countries_ids;
       Country::whereIn('id', $country_ids)->delete();
       return response()->json(['code'=>1, 'msg'=>'Los Paises seleccionados han sido eliminados de la Base de Datos']); 
    }

}
