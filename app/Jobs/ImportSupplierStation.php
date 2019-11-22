<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use DB;

class ImportSupplierStation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fileName;
    private $fileHeaderColumnList = [];
    private $mappedColumn = [

        'supplier_locations'=>[
            "cols"=>[
                'Country' => 'country_code',
                'State' => 'state',
                'City' => 'city',
            ]

        ],

        'supplier_stations'=>[
            "cols"=>[
                'Description (Location Name)' => 'name',
                'Oag Code' => 'code',
                'Latitude' => 'lat',
                'Longitude' => 'lng',
                'Phone' => 'contact',
                'Zip Code' => 'postal_code',
                'Address1' => 'address',
                'Country' => 'country_code',
                'City' => 'city',
            ],
            "allow_misc"=>true
        ],

    ];
    private $columnData = [
        'default'=>[],
        'supplier_locations'=>[],
        'supplier_stations'=>[],
    ];
    private $supplierID;
    private $chunkLength = 25;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $supplierID)
    {
        $this->fileName = $fileName;
        $this->supplierID = $supplierID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    /*public function debug($val){
        echo "<pre>";
        print_r($val);
        exit;
    }*/

    public function handle()
    {
        $rawFileContent = Storage::disk('public')->get($this->fileName);
        $lineSplittedFileContent = preg_split("/\r?\n|\r/", $rawFileContent);
        $header = [];

        foreach ( $lineSplittedFileContent as $index=> $line ){

            $row = explode("|",$line);
            if( !is_array($row) && count($row)<=0 ) continue;

            if( count($header)<=0 ){
                $header = $row;
                $this->fileHeaderColumnList = $header;
                continue;
            }

            if( count($header) === count($row) ){
                $defaultColumnMappedData = array_combine( $header, $row );
                //Column Mapping
                foreach ( array_keys($this->columnData) as $keyIndex ){
                    $this->columnDataMapperByIndex($keyIndex, $defaultColumnMappedData);
                }
                //$this->data[ 'default' ][] = $defaultColumnMappedData;
            }

        }
        //$this->debug( $this->columnData[ 'default' ] );
        //Insert Data into DB
        collect($this->columnData)
            ->filter(function ($item, $key) {
                return $key!=="default";
            })
            ->each(function($item,$tableKeyIndex){
                collect($item)
                    ->chunk($this->chunkLength)
                    ->each(function($itemList) use($tableKeyIndex) {
                        DB::table($tableKeyIndex)->insert($itemList->toArray());
                        //dd($tableKeyIndex);
                    });
            });


    }

    private function columnDataMapperByIndex($tableKeyIndex , $data){

        if( array_key_exists($tableKeyIndex, $this->columnData ) && array_key_exists($tableKeyIndex, $this->mappedColumn ) ){
            $tableColumnNames = array_values( $this->mappedColumn[$tableKeyIndex]["cols"] );
            $fileColumnNames = array_keys( $this->mappedColumn[$tableKeyIndex]["cols"] );
            $updatedData = [];

            foreach ( $tableColumnNames as $columnName ){
                $foundColumnIndex = array_search( $columnName, $this->mappedColumn[$tableKeyIndex]["cols"] ) ;
                $updatedData[$columnName] = $data[ $foundColumnIndex ];
            }
            //Added SupplierID index
            $updatedData['supplier_id'] = $this->supplierID;

            if( array_key_exists("allow_misc" , $this->mappedColumn[$tableKeyIndex] ) ){
                $miscColumnNames = array_diff($this->fileHeaderColumnList, $fileColumnNames);
                $miscData = [];
                foreach ($miscColumnNames as $col){
                    $miscData[$col] = $data[$col];
                }
                $updatedData['misc_data'] = json_encode($miscData);
            }

            $this->columnData[$tableKeyIndex][] = $updatedData;
        }else{
            $this->columnData[$tableKeyIndex][] = $data;
        }
    }
}
