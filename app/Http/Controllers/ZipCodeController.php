<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Codes;

class ZipCodeController extends Controller
{
  /**
   * Show the profile for a given user.
   *
   * @param  int  $id
   * @return \Illuminate\View\View
   */
  public function show($id)
  {
    $codes = Codes::whereDCodigo($id)->get();
    if (count($codes)==0) {
      return 'Zip code not found..';
    }

    $settlements = [];
    foreach ($codes as  $st) {
      $arr = [
        "key" => $st->d_asenta_cpcons,
        "name" => $st->d_asenta,
        "zone_type" => $st->d_zona,
        "settlement_type" => [
          "name" => $st->d_tipo_asenta
        ]
      ];
      array_push($settlements, $arr);
    }

    $arreglo = [
      "zip_code" => $id,
      "locality" => $codes[0]['d_ciudad'],
      "federal_entity" =>  [
        "key" =>  $codes[0]['c_estado'],
        "name" =>  $codes[0]['d_estado'],
        "code" =>  null
      ],
      'settlements' => $settlements,
      "municipality" => [
        "key" => $codes[0]['c_mnpio'],
        "name" => $codes[0]['d_mnpio']
      ]
    ];

    return $arreglo;
  }
}
