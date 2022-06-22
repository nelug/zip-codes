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
        "key" => intval($st->d_asenta_cpcons),
        "name" => strtoupper($st->d_asenta),
        "zone_type" => strtoupper($st->d_zona),
        "settlement_type" => [
          "name" => $st->d_tipo_asenta
        ]
      ];
      array_push($settlements, $arr);
    }

    $arreglo = [
      "zip_code" => $id,
      "locality" => strtoupper($codes[0]['d_ciudad']),
      "federal_entity" =>  [
        "key" =>  intval($codes[0]['c_estado']),
        "name" =>  strtoupper($codes[0]['d_estado']),
        "code" =>  null
      ],
      'settlements' => $settlements,
      "municipality" => [
        "key" => intval($codes[0]['c_mnpio']),
        "name" => strtoupper($codes[0]['d_mnpio'])
      ]
    ];

    return  response($arreglo, 200);
  }
}
