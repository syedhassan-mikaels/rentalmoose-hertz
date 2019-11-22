<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportSupplierStation;
use GuzzleHttp\Client;
use Spatie\ArrayToXml\ArrayToXml;
use Vyuldashev\XmlToArray\XmlToArray;


class HomeController extends Controller
{
    private $request;


    public function __construct(Request $request)
    {
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

        $xmlStruct = [
            'rootElement'=> [
                'rootElementName' => 'OTA_VehAvailRateRQ',
                '_attributes' => [
                    'xmlns' => 'http://www.opentravel.org/OTA/2003/05',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'xsi:schemaLocation' => 'http://www.opentravel.org/OTA/2003/05 OTA_VehAvailRateRQ.xsd',
                    'Version'=>'2.007',
                    'SequenceNmbr'=>'123456789',
                    'MaxResponses'=>'5'
                ],
            ],
            'childElements'=> [
                'POS' => [
                    'Source'=>[
                        '_attributes' => [
                            'ISOCountry'=>'PK' ,
                            'AgentDutyCode'=>'M18R5E14N20'
                        ],
                        'RequestorID'=>[
                            '_attributes' => [
                                'Type'=>'4' ,
                                'ID'=>'T927'
                            ],
                            'CompanyName'=>[
                                '_attributes' => [
                                    'Code'=>'CP' ,
                                    'CodeContext'=>'6UAC'
                                ]
                            ]
                        ]
                    ]
                ],
                'VehAvailRQCore' => [
                    '_attributes' => [
                        'Status'=>'All'
                    ],
                    'VehRentalCore'=>[
                        '_attributes' => [
                            'PickUpDateTime'=>'2019-11-26T15:45:00',
                            'ReturnDateTime'=>'2019-11-30T13:30:00',
                        ],
                        'PickUpLocation'=>[
                            'LocationCode'=>'ANGX91',
                            'CodeContext'=>'IATA'
                        ],
                        'ReturnLocation'=>[
                            'LocationCode'=>'ANGX91',
                            'CodeContext'=>'IATA'
                        ]
                    ]
                ]
            ]
        ];
        $xmlInput = ArrayToXml::convert($xmlStruct['childElements'],$xmlStruct['rootElement']);
        /*echo ($xmlInput);
        exit;*/
        $options = [
            'headers' => [
                'Content-Type' => 'application/xml',
                'Accept' => 'application/xml',
            ],
            'body' => $xmlInput
        ];

        $client = new \GuzzleHttp\Client();
        $apiRequest = $client->request('POST', 'https://vv.xqual.hertz.com/ota2007a', $options);
        $response = $apiRequest->getBody()->getContents();
        //dd(XmlToArray::convert($response));
        return $response;

    }


}
