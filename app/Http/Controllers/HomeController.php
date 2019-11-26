<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportSupplierStation;
use GuzzleHttp\Client;
use Spatie\ArrayToXml\ArrayToXml;
use Vyuldashev\XmlToArray\XmlToArray;
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
        $pickupDateTime = $this->request->pickup_date_time;
        $returnDateTime = $this->request->return_date_time;
        $locationCode   = $this->request->location_code;

        dd($this->hertzService->getAvailableCarsByLocation($this->request));

    }


}
