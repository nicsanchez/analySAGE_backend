<?php

namespace App\AO\PersonalInformation;

use DB;

class PersonalInformationAO
{
    public static function storePersonalInformation($data){
        return DB::table('personal_information')->insertGetId($data);
    }

    public static function updatePersonalInformation($id,$data){
        DB::table('personal_information')->where('id',$id)->update($data);
    }

    public static function getPersonalDataByDocument($identification){
        return DB::table('personal_information')->where('identification',$identification)->get();
    }
}
