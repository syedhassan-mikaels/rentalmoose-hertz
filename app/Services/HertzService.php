<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Spatie\ArrayToXml\ArrayToXml;

class HertzService
{
    private $dataSource = [
        'VehicleCategory' =>[
            '1' => "car",
            '2' => "van",
            '3' => "suv",
            '4' => "convertible",
            '7'=> "limousine",
            '8' => "station wagon",
            '9' => "pickup",
            '10' => "motorhome",
            '11' => "all-terrain",
            '12' => "recreational",
            '13' => "sport",
            '14' => "special",
            '15' => "pickup extended cab",
            '16' => "regular cab pickup",
            '17' => "special offer",
            '18' => "coupe",
            '19' => "monospace",
            '20' => "2 wheel vehicle",
            '21' => "roadster",
            '22' => "crossover",
            '23' => "commercial van/truck"
        ],
        'Size'=>[
            '1' =>'mini' ,
            '2' =>'subcompact' ,
            '3' =>'economy' ,
            '4' =>'compact' ,
            '5' =>'midsize' ,
            '6' =>'intermediate' ,
            '7' =>'standard' ,
            '8' =>'fullsize' ,
            '9' =>'luxury' ,
            '10' =>'premium' ,
            '23' =>'special' ,
            '32'=>'special',
            '33'=>'minielite' ,
            '34'=>'economy elite' ,
            '35'=>'compact elite' ,
            '36'=>'intermediate elite' ,
            '37'=>'standard elite' ,
            '38'=>'fullsize elite' ,
            '39'=>'premium elite' ,
            '40'=>'luxury elite' ,
            '41'=>'oversize'
        ]
    ];
    private $dumbXML = '<OTA_VehAvailRateRS
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xmlns="http://www.opentravel.org/OTA/2003/05" Target="Test" Version="2.007" SequenceNmbr="123456789">
        <Success></Success>
        <Warnings>
            <Warning Type="1" ShortText="NON RESIDENT RENTERS REQ. INTERNATIONAL DRIVERS LICENSE" RecordID="273"/>
            <Warning Type="1" ShortText="A FEE MAY APPLY IF THE VEHICLE IS DRIVEN CROSS BORDER" RecordID="902"/>
            <Warning Type="1" ShortText="RETURN LOCATION NOT 24HRS - CHECK TIMES" RecordID="040"/>
            <Warning Type="1" ShortText="FOR RENTERS UNDER 25 YRS OF AGE SEE KEYWORD AGE" RecordID="201"/>
            <Warning Type="1" ShortText="AGE RESTRICTIONS MAY APPLY CHECK POLICY" RecordID="363"/>
            <Warning Type="1" ShortText="PROVIDE VALID CREDIT OR DEBIT CARD TO RENT" RecordID="781"/>
            <Warning Type="1" ShortText="EARLY OR LATE RETURN CHARGE MAY APPLY - CHECK RENTAL TERMS" RecordID="856"/>
        </Warnings>
        <VehAvailRSCore>
            <VehRentalCore PickUpDateTime="2019-11-26T15:45:00-06:00" ReturnDateTime="2019-11-30T13:30:00-06:00">
                <PickUpLocation ExtendedLocationCode="ANGX91" LocationCode="ANGX91" CodeContext="IATA"/>
                <ReturnLocation ExtendedLocationCode="ANGX91" LocationCode="ANGX91" CodeContext="IATA"/>
            </VehRentalCore>
            <VehVendorAvails>
                <VehVendorAvail>
                    <Vendor Code="ZE"/>
                    <VehAvails>
                        <VehAvail>
                            <VehAvailCore Status="Available" IsAlternateInd="false">
                                <Vehicle PassengerQuantity="4" BaggageQuantity="2" AirConditionInd="true" TransmissionType="Manual" FuelType="Unspecified" DriveType="Unspecified" Code="MCMR" CodeContext="SIPP">
                                    <VehType VehicleCategory="1"/>
                                    <VehClass Size="1"/>
                                    <VehMakeModel Name="A FIAT 500 OR SIMILAR" Code="MCMR"/>
                                    <PictureURL>ZEFRMCMR999.jpg</PictureURL>
                                </Vehicle>
                                <RentalRate>
                                    <RateDistance Unlimited="true" DistUnitName="Km" VehiclePeriodUnitName="RentalPeriod"/>
                                    <VehicleCharges>
                                        <VehicleCharge Purpose="1" TaxInclusive="false" GuaranteedInd="true" Amount="149.20" CurrencyCode="EUR" IncludedInRate="false">
                                            <TaxAmounts>
                                                <TaxAmount Total="29.84" CurrencyCode="EUR" Percentage="20.00" Description="Tax"/>
                                            </TaxAmounts>
                                            <Calculation UnitCharge="37.30" UnitName="Day" Quantity="4"/>
                                        </VehicleCharge>
                                    </VehicleCharges>
                                    <RateQualifier ArriveByFlight="false" RateCategory="3" RateQualifier="AFHYMC"/>
                                </RentalRate>
                                <TotalCharge RateTotalAmount="149.20" EstimatedTotalAmount="179.04" CurrencyCode="EUR"/>
                                <Fees>
                                    <Fee Purpose="5" Description="LOCATION SERVICE CHARGE:" IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                    <Fee Purpose="5" Description="VEHICLE LICENSING FEE AND ROAD TAX:" IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                </Fees>
                                <Reference Type="16" ID="KEOBX5U9UD13385-2501"/>
                            </VehAvailCore>
                            <VehAvailInfo>
                                <PricedCoverages>
                                    <PricedCoverage>
                                        <Coverage CoverageType="7"/>
                                        <Charge IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                    </PricedCoverage>
                                    <PricedCoverage Required="false">
                                        <Coverage CoverageType="38"/>
                                        <Charge TaxInclusive="false" IncludedInRate="false" CurrencyCode="EUR">
                                            <Calculation UnitCharge="8.32" UnitName="Day" Quantity="1"/>
                                        </Charge>
                                    </PricedCoverage>
                                    <PricedCoverage Required="false">
                                        <Coverage CoverageType="59"/>
                                        <Charge TaxInclusive="false" IncludedInRate="false" CurrencyCode="EUR">
                                            <Calculation UnitCharge="17.49" UnitName="Day" Quantity="1"/>
                                        </Charge>
                                    </PricedCoverage>
                                    <PricedCoverage>
                                        <Coverage CoverageType="48"/>
                                        <Charge IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                    </PricedCoverage>
                                </PricedCoverages>
                            </VehAvailInfo>
                        </VehAvail>
                        <VehAvail>
                            <VehAvailCore Status="Available" IsAlternateInd="false">
                                <Vehicle PassengerQuantity="4" BaggageQuantity="2" AirConditionInd="true" TransmissionType="Manual" FuelType="Unspecified" DriveType="Unspecified" Code="MCMR" CodeContext="SIPP">
                                    <VehType VehicleCategory="1"/>
                                    <VehClass Size="1"/>
                                    <VehMakeModel Name="VIVO" Code="MCMR"/>
                                    <PictureURL>test.jpg</PictureURL>
                                </Vehicle>
                                <RentalRate>
                                    <RateDistance Unlimited="true" DistUnitName="Km" VehiclePeriodUnitName="RentalPeriod"/>
                                    <VehicleCharges>
                                        <VehicleCharge Purpose="1" TaxInclusive="false" GuaranteedInd="true" Amount="149.20" CurrencyCode="EUR" IncludedInRate="false">
                                            <TaxAmounts>
                                                <TaxAmount Total="29.84" CurrencyCode="EUR" Percentage="20.00" Description="Tax"/>
                                            </TaxAmounts>
                                            <Calculation UnitCharge="37.30" UnitName="Day" Quantity="4"/>
                                        </VehicleCharge>
                                    </VehicleCharges>
                                    <RateQualifier ArriveByFlight="false" RateCategory="3" RateQualifier="AFHYMC"/>
                                </RentalRate>
                                <TotalCharge RateTotalAmount="239.20" EstimatedTotalAmount="179.04" CurrencyCode="EUR"/>
                                <Fees>
                                    <Fee Purpose="5" Description="LOCATION SERVICE CHARGE:" IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                    <Fee Purpose="5" Description="VEHICLE LICENSING FEE AND ROAD TAX:" IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                </Fees>
                                <Reference Type="16" ID="KEOBX5U9UD13385-2501"/>
                            </VehAvailCore>
                            <VehAvailInfo>
                                <PricedCoverages>
                                    <PricedCoverage>
                                        <Coverage CoverageType="7"/>
                                        <Charge IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                    </PricedCoverage>
                                    <PricedCoverage Required="false">
                                        <Coverage CoverageType="38"/>
                                        <Charge TaxInclusive="false" IncludedInRate="false" CurrencyCode="EUR">
                                            <Calculation UnitCharge="8.32" UnitName="Day" Quantity="1"/>
                                        </Charge>
                                    </PricedCoverage>
                                    <PricedCoverage Required="false">
                                        <Coverage CoverageType="59"/>
                                        <Charge TaxInclusive="false" IncludedInRate="false" CurrencyCode="EUR">
                                            <Calculation UnitCharge="17.49" UnitName="Day" Quantity="1"/>
                                        </Charge>
                                    </PricedCoverage>
                                    <PricedCoverage>
                                        <Coverage CoverageType="48"/>
                                        <Charge IncludedInRate="true" Amount="0.00" CurrencyCode="EUR"/>
                                    </PricedCoverage>
                                </PricedCoverages>
                            </VehAvailInfo>
                        </VehAvail>
                    </VehAvails>
                    <Info>
                        <LocationDetails Name="ANGOULEME RR">
                            <Address FormattedInd="false">
                                <AddressLine>121 AVENUE GAMBETTA</AddressLine>
                                <AddressLine>ANGOULEME</AddressLine>
                                <CityName>ANGOULEME</CityName>
                                <PostalCode>16000</PostalCode>
                                <CountryName Code="FR">FRANCE</CountryName>
                            </Address>
                            <Telephone PhoneLocationType="4" PhoneTechType="1" PhoneNumber="0545957585" FormattedInd="false"/>
                            <AdditionalInfo>
                                <OperationSchedules>
                                    <OperationSchedule>
                                        <OperationTimes>
                                            <OperationTime Text="MO-FR 0800-1200 1400-1800 SA 0830-1200 1400-1700 SU CLSD"/>
                                            <OperationTime Mon="true" Start="08:00" End="12:00"/>
                                            <OperationTime Mon="true" Start="14:00" End="18:00"/>
                                            <OperationTime Tue="true" Start="08:00" End="12:00"/>
                                            <OperationTime Tue="true" Start="14:00" End="18:00"/>
                                            <OperationTime Weds="true" Start="08:00" End="12:00"/>
                                            <OperationTime Weds="true" Start="14:00" End="18:00"/>
                                            <OperationTime Thur="true" Start="08:00" End="12:00"/>
                                            <OperationTime Thur="true" Start="14:00" End="18:00"/>
                                            <OperationTime Fri="true" Start="08:00" End="12:00"/>
                                            <OperationTime Fri="true" Start="14:00" End="18:00"/>
                                            <OperationTime Sat="true" Start="08:30" End="12:00"/>
                                            <OperationTime Sat="true" Start="14:00" End="17:00"/>
                                        </OperationTimes>
                                    </OperationSchedule>
                                </OperationSchedules>
                            </AdditionalInfo>
                        </LocationDetails>
                    </Info>
                </VehVendorAvail>
            </VehVendorAvails>
        </VehAvailRSCore>
    </OTA_VehAvailRateRS>';

    public function getAvailableCarsByLocation($request){

        $pickupDateTime = $request->pickup_date_time;
        $returnDateTime = $request->return_date_time;
        $locationCode   = $request->location_code;

        $xmlArrayStruct = [
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
        $xmlPayload = ArrayToXml::convert( $xmlArrayStruct['childElements'], $xmlArrayStruct['rootElement'] );
        $options = [
            'headers' => [
                'Content-Type' => 'application/xml',
                'Accept' => 'application/xml',
            ],
            'body' => $xmlPayload
        ];

        $client = new \GuzzleHttp\Client();
        $apiRequest = $client->request('POST', 'https://vv.xqual.hertz.com/ota2007a', $options);
        $xmlResponse = $apiRequest->getBody()->getContents();

        $xmlConvertedArray = xmlToArray($xmlResponse);
        $records = $this->xmlMapperToDBColumn($xmlConvertedArray);

        //dd($records);
        DB::table('vehicles')->insert($records);
        //dd("Inserted");
        //return $response;

    }

    private function xmlMapperToDBColumn($data){
        $mapping = [
            "VehAvailRSCore.VehRentalCore.PickUpLocation.@attributes.LocationCode" => [
                "colName" => "station_code",
                "nestedChild"=> []
            ],
            "VehAvailRSCore.VehVendorAvails.VehVendorAvail.VehAvails.VehAvail" => [
                "colName" => null,
                "nestedChild"=> [
                    "VehAvailCore.Vehicle.VehMakeModel.@attributes.Name"=> [ "colName"=> "title"],
                    "VehAvailCore.Vehicle.VehMakeModel.@attributes.Code"=> [ "colName"=> "category_code"],
                    "VehAvailCore.Vehicle.PictureURL"=> [ "colName"=> "image" ],

                    "VehAvailCore.Vehicle.VehType.@attributes.VehicleCategory"=> [ "colName"=> "category" ], //id like 1,2 ,3
                    "VehAvailCore.Vehicle.VehType.@attributes.DoorCount"=> [ "colName"=> "doors" ], //id like 1,2 ,3

                    "VehAvailCore.Vehicle.VehClass.@attributes.Size"=> [ "colName"=> "type"], //id like 1,2 ,3

                    "VehAvailCore.Vehicle.@attributes.FuelType"=> [ "colName"=> "fuel_type"],
                    "VehAvailCore.Vehicle.@attributes.AirConditionInd"=> [ "colName"=> "air_conditioned"],
                    "VehAvailCore.Vehicle.@attributes.TransmissionType"=> [ "colName"=> "transmission"],
                    "VehAvailCore.Vehicle.@attributes.BaggageQuantity"=> [ "colName"=> "baggage"],
                    "VehAvailCore.Vehicle.@attributes.PassengerQuantity"=> [ "colName"=> "seats"],

                    "VehAvailCore.TotalCharge.@attributes.CurrencyCode"=> [ "colName"=> "currency"],
                    //"VehAvailCore.TotalCharge.@attributes.EstimatedTotalAmount"=> "currency",
                    //"VehAvailCore.TotalCharge.@attributes.RateTotalAmount"=> "currency",
                    "VehAvailCore.RentalRate.VehicleCharges.VehicleCharge.Calculation.@attributes.UnitCharge"=> [ "colName"=> "per_day_amount"],
                ]
            ],
        ];
        $mappedData = [];
        foreach ($mapping as $key => $val){
            $columnName = $val["colName"];
            $nestedChilds = $val["nestedChild"];
            if(isset($columnName)){
                $mappedData['general'][ $columnName ] = arrayValueByDottedKey( $key, $data );
            }
            if( is_array($nestedChilds)  && count($nestedChilds)>0){
                $columnName = $val["colName"];
                $itemData = arrayValueByDottedKey( $key, $data );

                foreach ( $nestedChilds as $nestedChildKey => $nestedChildVal ){


                    if( isAssocArray($itemData) ){
                        $mergedParentKey = $key.".".$nestedChildKey;
                        $columnName = $nestedChildVal["colName"];
                        if( isset($columnName) ) $mappedData['items'][0][ $columnName ] = arrayValueByDottedKey( $mergedParentKey, $data );
                    }else{
                        foreach( $itemData as $itemKey => $itemVal ){
                            $mergedParentKey = $key.".".$itemKey.".".$nestedChildKey;
                            $columnName = $nestedChildVal["colName"];

                            if( isset($columnName) ) $mappedData['items'][ $itemKey ][ $columnName ] = arrayValueByDottedKey( $mergedParentKey, $data );
                        }
                    }
                }
            }
        }
        $mappedData = collect($mappedData['items'])->transform(function($item) use($mappedData){

            collect($mappedData['general'])->each(function($generalItem,$generalIndex) use(&$item){
                $item[$generalIndex] = $generalItem;
            });
            $item['created_at'] = now()->format("Y-m-d H:i:s");
            $item['air_conditioned'] = $item['air_conditioned']?1:0;
            $item['supplier_id'] = 2;
            $item['doors'] = $item['doors']??0;
            $item['pcode'] = $item['pcode']??'';
            $item['pfamily'] = $item['pfamily']??'';
            $item['rating'] = $item['rating']??0;
            $item['category'] = isset($item['category'])? ucwords($this->dataSource['VehicleCategory'][ $item['category'] ]) : '';
            $item['type'] = isset($item['type'])? ucwords($this->dataSource['Size'][ $item['type'] ]) : '';

            return $item;

        })->toArray();
        return $mappedData;
        //dd(( $data));
        //dd(getValueByKey('family.spouse.name', $developer, 'Matt Stauffer'));

        //collect($mapping);

    }

}


?>
