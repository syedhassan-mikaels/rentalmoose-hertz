<?php

namespace App\Http\Controllers;

use App\Jobs\HertzVehicleSync;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;
use HertzService;


class HomeController extends Controller
{
    private $request;
    private $hertzService;


    public function __construct(Request $request)
    {
        $this->hertzService = new HertzService();
        $this->request = $request;
    }

    public function displayCarStationForm(){
        return view('importCarStations');
    }

    public function uploadCarStation(){

        $file = $this->request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension !== 'txt'){
            $errors['file'] = 'This is not a .txt file!';
            return redirect()->back()->withInput()->withErrors($errors);
        }
        $uploadedFile = $this->saveFile();

        /*if( Storage::disk('public')->has($uploadedFile) ){
            ImportSupplierStation::dispatch( $uploadedFile, 2 );
        }*/
    }

    private function saveFile(){
        $file = $this->request->file('file');
        $filename = $file->getClientOriginalName();
        $folderPath = "/suppliers/hertz/stations";
        //$file->storeAs("/public".$folderPath, $filename);
        return Storage::disk('public')->put($folderPath,$file);

    }


    public function getAvailableCarsByLocation(){
        $params = [
            'pickup_date_time' => $this->request->pickup_date_time,
            'return_date_time' => $this->request->return_date_time,
            'location_code' => $this->request->location_code,
        ];
        HertzVehicleSync::dispatch($params);

    }


}
