<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'country_name' => 'Afghanistan',
                'country_code' => 'AF',
                'international_dialing' => '+93',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'country_name' => 'Aland Islands',
                'country_code' => 'AX',
                'international_dialing' => '+358',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'country_name' => 'Albania',
                'country_code' => 'AL',
                'international_dialing' => '+355',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'country_name' => 'Algeria',
                'country_code' => 'DZ',
                'international_dialing' => '+213',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'country_name' => 'American Samoa',
                'country_code' => 'AS',
                'international_dialing' => '+1-684',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'country_name' => 'Andorra',
                'country_code' => 'AD',
                'international_dialing' => '+376',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'country_name' => 'Angola',
                'country_code' => 'AO',
                'international_dialing' => '+244',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'country_name' => 'Anguilla',
                'country_code' => 'AI',
                'international_dialing' => '+1-264',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            8 => 
            array (
                'id' => 9,
                'country_name' => 'Antarctica',
                'country_code' => 'AQ',
                'international_dialing' => '+672',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            9 => 
            array (
                'id' => 10,
                'country_name' => 'Antigua and Barbuda',
                'country_code' => 'AG',
                'international_dialing' => '+1-268',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            10 => 
            array (
                'id' => 11,
                'country_name' => 'Argentina',
                'country_code' => 'AR',
                'international_dialing' => '+54',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            11 => 
            array (
                'id' => 12,
                'country_name' => 'Armenia',
                'country_code' => 'AM',
                'international_dialing' => '+374',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            12 => 
            array (
                'id' => 13,
                'country_name' => 'Aruba',
                'country_code' => 'AW',
                'international_dialing' => '+297',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            13 => 
            array (
                'id' => 14,
                'country_name' => 'Australia',
                'country_code' => 'AU',
                'international_dialing' => '+61',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            14 => 
            array (
                'id' => 15,
                'country_name' => 'Austria',
                'country_code' => 'AT',
                'international_dialing' => '+43',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            15 => 
            array (
                'id' => 16,
                'country_name' => 'Azerbaijan',
                'country_code' => 'AZ',
                'international_dialing' => '+994',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            16 => 
            array (
                'id' => 17,
                'country_name' => 'Bahamas',
                'country_code' => 'BS',
                'international_dialing' => '+1-242',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            17 => 
            array (
                'id' => 18,
                'country_name' => 'Bahrain',
                'country_code' => 'BH',
                'international_dialing' => '+973',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            18 => 
            array (
                'id' => 19,
                'country_name' => 'Bangladesh',
                'country_code' => 'BD',
                'international_dialing' => '+880',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            19 => 
            array (
                'id' => 20,
                'country_name' => 'Barbados',
                'country_code' => 'BB',
                'international_dialing' => '+1-246',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            20 => 
            array (
                'id' => 21,
                'country_name' => 'Belarus',
                'country_code' => 'BY',
                'international_dialing' => '+375',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            21 => 
            array (
                'id' => 22,
                'country_name' => 'Belgium',
                'country_code' => 'BE',
                'international_dialing' => '+32',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            22 => 
            array (
                'id' => 23,
                'country_name' => 'Belize',
                'country_code' => 'BZ',
                'international_dialing' => '+501',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            23 => 
            array (
                'id' => 24,
                'country_name' => 'Benin',
                'country_code' => 'BJ',
                'international_dialing' => '+229',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            24 => 
            array (
                'id' => 25,
                'country_name' => 'Bermuda',
                'country_code' => 'BM',
                'international_dialing' => '+1-441',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            25 => 
            array (
                'id' => 26,
                'country_name' => 'Bhutan',
                'country_code' => 'BT',
                'international_dialing' => '+975',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            26 => 
            array (
                'id' => 27,
                'country_name' => 'Bolivia',
                'country_code' => 'BO',
                'international_dialing' => '+591',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            27 => 
            array (
                'id' => 28,
                'country_name' => 'Bonaire, Saint Eustatius and Saba ',
                'country_code' => 'BQ',
                'international_dialing' => '+599',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            28 => 
            array (
                'id' => 29,
                'country_name' => 'Bosnia and Herzegovina',
                'country_code' => 'BA',
                'international_dialing' => '+387',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            29 => 
            array (
                'id' => 30,
                'country_name' => 'Botswana',
                'country_code' => 'BW',
                'international_dialing' => '+267',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            30 => 
            array (
                'id' => 32,
                'country_name' => 'Brazil',
                'country_code' => 'BR',
                'international_dialing' => '+55',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            31 => 
            array (
                'id' => 34,
                'country_name' => 'British Virgin Islands',
                'country_code' => 'VG',
                'international_dialing' => '+1',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            32 => 
            array (
                'id' => 35,
                'country_name' => 'Brunei',
                'country_code' => 'BN',
                'international_dialing' => '+673',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            33 => 
            array (
                'id' => 36,
                'country_name' => 'Bulgaria',
                'country_code' => 'BG',
                'international_dialing' => '+359',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            34 => 
            array (
                'id' => 37,
                'country_name' => 'Burkina Faso',
                'country_code' => 'BF',
                'international_dialing' => '+226',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            35 => 
            array (
                'id' => 38,
                'country_name' => 'Burundi',
                'country_code' => 'BI',
                'international_dialing' => '+257',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            36 => 
            array (
                'id' => 39,
                'country_name' => 'Cambodia',
                'country_code' => 'KH',
                'international_dialing' => '+855',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            37 => 
            array (
                'id' => 40,
                'country_name' => 'Cameroon',
                'country_code' => 'CM',
                'international_dialing' => '+237',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            38 => 
            array (
                'id' => 41,
                'country_name' => 'Canada',
                'country_code' => 'CA',
                'international_dialing' => '+1',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            39 => 
            array (
                'id' => 42,
                'country_name' => 'Cape Verde',
                'country_code' => 'CV',
                'international_dialing' => '+238',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            40 => 
            array (
                'id' => 43,
                'country_name' => 'Cayman Islands',
                'country_code' => 'KY',
                'international_dialing' => '+1-345',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            41 => 
            array (
                'id' => 44,
                'country_name' => 'Central African Republic',
                'country_code' => 'CF',
                'international_dialing' => '+236',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            42 => 
            array (
                'id' => 45,
                'country_name' => 'Chad',
                'country_code' => 'TD',
                'international_dialing' => '+235',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            43 => 
            array (
                'id' => 46,
                'country_name' => 'Chile',
                'country_code' => 'CL',
                'international_dialing' => '+56',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            44 => 
            array (
                'id' => 47,
                'country_name' => 'China',
                'country_code' => 'CN',
                'international_dialing' => '+86',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            45 => 
            array (
                'id' => 50,
                'country_name' => 'Colombia',
                'country_code' => 'CO',
                'international_dialing' => '+57',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            46 => 
            array (
                'id' => 51,
                'country_name' => 'Comoros',
                'country_code' => 'KM',
                'international_dialing' => '+269',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            47 => 
            array (
                'id' => 52,
                'country_name' => 'Cook Islands',
                'country_code' => 'CK',
                'international_dialing' => '+682',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            48 => 
            array (
                'id' => 53,
                'country_name' => 'Costa Rica',
                'country_code' => 'CR',
                'international_dialing' => '+506',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            49 => 
            array (
                'id' => 54,
                'country_name' => 'Croatia',
                'country_code' => 'HR',
                'international_dialing' => '+385',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            50 => 
            array (
                'id' => 55,
                'country_name' => 'Cuba',
                'country_code' => 'CU',
                'international_dialing' => '+53',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            51 => 
            array (
                'id' => 56,
                'country_name' => 'Curacao',
                'country_code' => 'CW',
                'international_dialing' => '+599',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            52 => 
            array (
                'id' => 57,
                'country_name' => 'Cyprus',
                'country_code' => 'CY',
                'international_dialing' => '+357',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            53 => 
            array (
                'id' => 58,
                'country_name' => 'Czech Republic',
                'country_code' => 'CZ',
                'international_dialing' => '+420',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            54 => 
            array (
                'id' => 59,
                'country_name' => 'Democratic Republic of the Congo',
                'country_code' => 'CD',
                'international_dialing' => '+243',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            55 => 
            array (
                'id' => 60,
                'country_name' => 'Denmark',
                'country_code' => 'DK',
                'international_dialing' => '+45',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            56 => 
            array (
                'id' => 61,
                'country_name' => 'Djibouti',
                'country_code' => 'DJ',
                'international_dialing' => '+253',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            57 => 
            array (
                'id' => 62,
                'country_name' => 'Dominica',
                'country_code' => 'DM',
                'international_dialing' => '+1-767',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            58 => 
            array (
                'id' => 63,
                'country_name' => 'Dominican Republic',
                'country_code' => 'DO',
                'international_dialing' => '+1-809 and +1-829',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            59 => 
            array (
                'id' => 64,
                'country_name' => 'East Timor',
                'country_code' => 'TL',
                'international_dialing' => '+670',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            60 => 
            array (
                'id' => 65,
                'country_name' => 'Ecuador',
                'country_code' => 'EC',
                'international_dialing' => '+593 ',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            61 => 
            array (
                'id' => 66,
                'country_name' => 'Egypt',
                'country_code' => 'EG',
                'international_dialing' => '+20',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            62 => 
            array (
                'id' => 67,
                'country_name' => 'El Salvador',
                'country_code' => 'SV',
                'international_dialing' => '+503',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            63 => 
            array (
                'id' => 68,
                'country_name' => 'Equatorial Guinea',
                'country_code' => 'GQ',
                'international_dialing' => '+240',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            64 => 
            array (
                'id' => 69,
                'country_name' => 'Eritrea',
                'country_code' => 'ER',
                'international_dialing' => '+291',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            65 => 
            array (
                'id' => 70,
                'country_name' => 'Estonia',
                'country_code' => 'EE',
                'international_dialing' => '+372',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            66 => 
            array (
                'id' => 71,
                'country_name' => 'Ethiopia',
                'country_code' => 'ET',
                'international_dialing' => '+251',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            67 => 
            array (
                'id' => 73,
                'country_name' => 'Faroe Islands',
                'country_code' => 'FO',
                'international_dialing' => '+298',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            68 => 
            array (
                'id' => 74,
                'country_name' => 'Fiji',
                'country_code' => 'FJ',
                'international_dialing' => '+679',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            69 => 
            array (
                'id' => 75,
                'country_name' => 'Finland',
                'country_code' => 'FI',
                'international_dialing' => '+358',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            70 => 
            array (
                'id' => 76,
                'country_name' => 'France',
                'country_code' => 'FR',
                'international_dialing' => '+33',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            71 => 
            array (
                'id' => 77,
                'country_name' => 'French Guiana',
                'country_code' => 'GF',
                'international_dialing' => '+594',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            72 => 
            array (
                'id' => 78,
                'country_name' => 'French Polynesia',
                'country_code' => 'PF',
                'international_dialing' => '+689',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            73 => 
            array (
                'id' => 79,
                'country_name' => 'French Southern Territories',
                'country_code' => 'TF',
                'international_dialing' => '+262',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            74 => 
            array (
                'id' => 80,
                'country_name' => 'Gabon',
                'country_code' => 'GA',
                'international_dialing' => '+241',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            75 => 
            array (
                'id' => 81,
                'country_name' => 'Gambia',
                'country_code' => 'GM',
                'international_dialing' => '+220',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            76 => 
            array (
                'id' => 82,
                'country_name' => 'Georgia',
                'country_code' => 'GE',
                'international_dialing' => '+995',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            77 => 
            array (
                'id' => 83,
                'country_name' => 'Germany',
                'country_code' => 'DE',
                'international_dialing' => '+49',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            78 => 
            array (
                'id' => 84,
                'country_name' => 'Ghana',
                'country_code' => 'GH',
                'international_dialing' => '+233',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            79 => 
            array (
                'id' => 85,
                'country_name' => 'Gibraltar',
                'country_code' => 'GI',
                'international_dialing' => '+350',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            80 => 
            array (
                'id' => 86,
                'country_name' => 'Greece',
                'country_code' => 'GR',
                'international_dialing' => '+30',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            81 => 
            array (
                'id' => 87,
                'country_name' => 'Greenland',
                'country_code' => 'GL',
                'international_dialing' => '+299',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            82 => 
            array (
                'id' => 88,
                'country_name' => 'Grenada',
                'country_code' => 'GD',
                'international_dialing' => '+1-473',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            83 => 
            array (
                'id' => 89,
                'country_name' => 'Guadeloupe',
                'country_code' => 'GP',
                'international_dialing' => '+590',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            84 => 
            array (
                'id' => 90,
                'country_name' => 'Guam',
                'country_code' => 'GU',
                'international_dialing' => '+1-671',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            85 => 
            array (
                'id' => 91,
                'country_name' => 'Guatemala',
                'country_code' => 'GT',
                'international_dialing' => '+502',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            86 => 
            array (
                'id' => 92,
                'country_name' => 'Guernsey',
                'country_code' => 'GG',
                'international_dialing' => '+44',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            87 => 
            array (
                'id' => 93,
                'country_name' => 'Guinea',
                'country_code' => 'GN',
                'international_dialing' => '+224',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            88 => 
            array (
                'id' => 94,
                'country_name' => 'Guinea-Bissau',
                'country_code' => 'GW',
                'international_dialing' => '+245',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            89 => 
            array (
                'id' => 95,
                'country_name' => 'Guyana',
                'country_code' => 'GY',
                'international_dialing' => '+592',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            90 => 
            array (
                'id' => 96,
                'country_name' => 'Haiti',
                'country_code' => 'HT',
                'international_dialing' => '+509',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            91 => 
            array (
                'id' => 98,
                'country_name' => 'Honduras',
                'country_code' => 'HN',
                'international_dialing' => '+504',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            92 => 
            array (
                'id' => 99,
                'country_name' => 'Hong Kong',
                'country_code' => 'HK',
                'international_dialing' => '+852',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            93 => 
            array (
                'id' => 100,
                'country_name' => 'Hungary',
                'country_code' => 'HU',
                'international_dialing' => '+36',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            94 => 
            array (
                'id' => 101,
                'country_name' => 'Iceland',
                'country_code' => 'IS',
                'international_dialing' => '+354',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            95 => 
            array (
                'id' => 102,
                'country_name' => 'India',
                'country_code' => 'IN',
                'international_dialing' => '+91',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            96 => 
            array (
                'id' => 103,
                'country_name' => 'Indonesia',
                'country_code' => 'ID',
                'international_dialing' => '+62',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            97 => 
            array (
                'id' => 104,
                'country_name' => 'Iran',
                'country_code' => 'IR',
                'international_dialing' => '+98',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            98 => 
            array (
                'id' => 105,
                'country_name' => 'Iraq',
                'country_code' => 'IQ',
                'international_dialing' => '+964',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            99 => 
            array (
                'id' => 106,
                'country_name' => 'Ireland',
                'country_code' => 'IE',
                'international_dialing' => '+353',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            100 => 
            array (
                'id' => 107,
                'country_name' => 'Isle of Man',
                'country_code' => 'IM',
                'international_dialing' => '+44',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            101 => 
            array (
                'id' => 108,
                'country_name' => 'Israel',
                'country_code' => 'IL',
                'international_dialing' => '+353',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            102 => 
            array (
                'id' => 109,
                'country_name' => 'Italy',
                'country_code' => 'IT',
                'international_dialing' => '+39',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            103 => 
            array (
                'id' => 110,
            'country_name' => 'Ivory Coast(Cote D\'Ivoire)',
                'country_code' => 'CI',
                'international_dialing' => '+225',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            104 => 
            array (
                'id' => 111,
                'country_name' => 'Jamaica',
                'country_code' => 'JM',
                'international_dialing' => '+1-876',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            105 => 
            array (
                'id' => 112,
                'country_name' => 'Japan',
                'country_code' => 'JP',
                'international_dialing' => '+81',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            106 => 
            array (
                'id' => 113,
                'country_name' => 'Jersey',
                'country_code' => 'JE',
                'international_dialing' => '+44',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            107 => 
            array (
                'id' => 114,
                'country_name' => 'Jordan',
                'country_code' => 'JO',
                'international_dialing' => '+962',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            108 => 
            array (
                'id' => 115,
                'country_name' => 'Kazakhstan',
                'country_code' => 'KZ',
                'international_dialing' => '+7',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            109 => 
            array (
                'id' => 116,
                'country_name' => 'Kenya',
                'country_code' => 'KE',
                'international_dialing' => '+254',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            110 => 
            array (
                'id' => 117,
                'country_name' => 'Kiribati',
                'country_code' => 'KI',
                'international_dialing' => '+686',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            111 => 
            array (
                'id' => 118,
                'country_name' => 'Kosovo',
                'country_code' => 'XK',
                'international_dialing' => '+383',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            112 => 
            array (
                'id' => 119,
                'country_name' => 'Kuwait',
                'country_code' => 'KW',
                'international_dialing' => '+965',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            113 => 
            array (
                'id' => 120,
                'country_name' => 'Kyrgyzstan',
                'country_code' => 'KG',
                'international_dialing' => '+996',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            114 => 
            array (
                'id' => 121,
                'country_name' => 'Laos',
                'country_code' => 'LA',
                'international_dialing' => '+856',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            115 => 
            array (
                'id' => 122,
                'country_name' => 'Latvia',
                'country_code' => 'LV',
                'international_dialing' => '+371',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            116 => 
            array (
                'id' => 123,
                'country_name' => 'Lebanon',
                'country_code' => 'LB',
                'international_dialing' => '+961',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            117 => 
            array (
                'id' => 124,
                'country_name' => 'Lesotho',
                'country_code' => 'LS',
                'international_dialing' => '+266',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            118 => 
            array (
                'id' => 125,
                'country_name' => 'Liberia',
                'country_code' => 'LR',
                'international_dialing' => '+231',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            119 => 
            array (
                'id' => 126,
                'country_name' => 'Libya',
                'country_code' => 'LY',
                'international_dialing' => '+218',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            120 => 
            array (
                'id' => 127,
                'country_name' => 'Liechtenstein',
                'country_code' => 'LI',
                'international_dialing' => '+423',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            121 => 
            array (
                'id' => 128,
                'country_name' => 'Lithuania',
                'country_code' => 'LT',
                'international_dialing' => '+370',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            122 => 
            array (
                'id' => 129,
                'country_name' => 'Luxembourg',
                'country_code' => 'LU',
                'international_dialing' => '+352',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            123 => 
            array (
                'id' => 130,
                'country_name' => 'Macao',
                'country_code' => 'MO',
                'international_dialing' => '+853',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            124 => 
            array (
                'id' => 131,
                'country_name' => 'Macedonia',
                'country_code' => 'MK',
                'international_dialing' => '+389',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            125 => 
            array (
                'id' => 132,
                'country_name' => 'Madagascar',
                'country_code' => 'MG',
                'international_dialing' => '+261',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            126 => 
            array (
                'id' => 133,
                'country_name' => 'Malawi',
                'country_code' => 'MW',
                'international_dialing' => '+265',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            127 => 
            array (
                'id' => 134,
                'country_name' => 'Malaysia',
                'country_code' => 'MY',
                'international_dialing' => '+60',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            128 => 
            array (
                'id' => 135,
                'country_name' => 'Maldives',
                'country_code' => 'MV',
                'international_dialing' => '+960',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            129 => 
            array (
                'id' => 136,
                'country_name' => 'Mali',
                'country_code' => 'ML',
                'international_dialing' => '+223',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            130 => 
            array (
                'id' => 137,
                'country_name' => 'Malta',
                'country_code' => 'MT',
                'international_dialing' => '+356',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            131 => 
            array (
                'id' => 138,
                'country_name' => 'Marshall Islands',
                'country_code' => 'MH',
                'international_dialing' => '+692',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            132 => 
            array (
                'id' => 139,
                'country_name' => 'Martinique',
                'country_code' => 'MQ',
                'international_dialing' => '+596',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            133 => 
            array (
                'id' => 140,
                'country_name' => 'Mauritania',
                'country_code' => 'MR',
                'international_dialing' => '+222',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            134 => 
            array (
                'id' => 141,
                'country_name' => 'Mauritius',
                'country_code' => 'MU',
                'international_dialing' => '+230',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            135 => 
            array (
                'id' => 142,
                'country_name' => 'Mayotte',
                'country_code' => 'YT',
                'international_dialing' => '+269',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            136 => 
            array (
                'id' => 143,
                'country_name' => 'Mexico',
                'country_code' => 'MX',
                'international_dialing' => '+52',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            137 => 
            array (
                'id' => 144,
                'country_name' => 'Micronesia',
                'country_code' => 'FM',
                'international_dialing' => '+691',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            138 => 
            array (
                'id' => 145,
                'country_name' => 'Moldova',
                'country_code' => 'MD',
                'international_dialing' => '+373',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            139 => 
            array (
                'id' => 146,
                'country_name' => 'Monaco',
                'country_code' => 'MC',
                'international_dialing' => '+377',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            140 => 
            array (
                'id' => 147,
                'country_name' => 'Mongolia',
                'country_code' => 'MN',
                'international_dialing' => '+976',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            141 => 
            array (
                'id' => 148,
                'country_name' => 'Montenegro',
                'country_code' => 'ME',
                'international_dialing' => '+382',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            142 => 
            array (
                'id' => 149,
                'country_name' => 'Montserrat',
                'country_code' => 'MS',
                'international_dialing' => '+1-664',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            143 => 
            array (
                'id' => 150,
                'country_name' => 'Morocco',
                'country_code' => 'MA',
                'international_dialing' => '+212',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            144 => 
            array (
                'id' => 151,
                'country_name' => 'Mozambique',
                'country_code' => 'MZ',
                'international_dialing' => '+258',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            145 => 
            array (
                'id' => 152,
                'country_name' => 'Myanmar',
                'country_code' => 'MM',
                'international_dialing' => '+95',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            146 => 
            array (
                'id' => 153,
                'country_name' => 'Namibia',
                'country_code' => 'NA',
                'international_dialing' => '+264',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            147 => 
            array (
                'id' => 154,
                'country_name' => 'Nauru',
                'country_code' => 'NR',
                'international_dialing' => '+674',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            148 => 
            array (
                'id' => 155,
                'country_name' => 'Nepal',
                'country_code' => 'NP',
                'international_dialing' => '+977',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            149 => 
            array (
                'id' => 156,
                'country_name' => 'Netherlands',
                'country_code' => 'NL',
                'international_dialing' => '+31',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            150 => 
            array (
                'id' => 157,
                'country_name' => 'Netherlands Antilles',
                'country_code' => 'AN',
                'international_dialing' => '+599',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            151 => 
            array (
                'id' => 158,
                'country_name' => 'New Caledonia',
                'country_code' => 'NC',
                'international_dialing' => '+687',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            152 => 
            array (
                'id' => 159,
                'country_name' => 'New Zealand',
                'country_code' => 'NZ',
                'international_dialing' => '+64',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            153 => 
            array (
                'id' => 160,
                'country_name' => 'Nicaragua',
                'country_code' => 'NI',
                'international_dialing' => '+505',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            154 => 
            array (
                'id' => 161,
                'country_name' => 'Niger',
                'country_code' => 'NE',
                'international_dialing' => '+227',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            155 => 
            array (
                'id' => 162,
                'country_name' => 'Nigeria',
                'country_code' => 'NG',
                'international_dialing' => '+234',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            156 => 
            array (
                'id' => 165,
                'country_name' => 'North Korea',
                'country_code' => 'KP',
                'international_dialing' => '+850',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            157 => 
            array (
                'id' => 166,
                'country_name' => 'Northern Mariana Islands',
                'country_code' => 'MP',
                'international_dialing' => '+1-670',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            158 => 
            array (
                'id' => 167,
                'country_name' => 'Norway',
                'country_code' => 'NO',
                'international_dialing' => '+47',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            159 => 
            array (
                'id' => 168,
                'country_name' => 'Oman',
                'country_code' => 'OM',
                'international_dialing' => '+968',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            160 => 
            array (
                'id' => 169,
                'country_name' => 'Pakistan',
                'country_code' => 'PK',
                'international_dialing' => '+92',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            161 => 
            array (
                'id' => 170,
                'country_name' => 'Palau',
                'country_code' => 'PW',
                'international_dialing' => '+680',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            162 => 
            array (
                'id' => 171,
                'country_name' => 'Palestinian Territory',
                'country_code' => 'PS',
                'international_dialing' => '+970',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            163 => 
            array (
                'id' => 172,
                'country_name' => 'Panama',
                'country_code' => 'PA',
                'international_dialing' => '+507',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            164 => 
            array (
                'id' => 173,
                'country_name' => 'Papua New Guinea',
                'country_code' => 'PG',
                'international_dialing' => '+675',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            165 => 
            array (
                'id' => 174,
                'country_name' => 'Paraguay',
                'country_code' => 'PY',
                'international_dialing' => '+595',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            166 => 
            array (
                'id' => 175,
                'country_name' => 'Peru',
                'country_code' => 'PE',
                'international_dialing' => '+51',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            167 => 
            array (
                'id' => 176,
                'country_name' => 'Philippines',
                'country_code' => 'PH',
                'international_dialing' => '+63',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            168 => 
            array (
                'id' => 178,
                'country_name' => 'Poland',
                'country_code' => 'PL',
                'international_dialing' => '+48',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            169 => 
            array (
                'id' => 179,
                'country_name' => 'Portugal',
                'country_code' => 'PT',
                'international_dialing' => '+351',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            170 => 
            array (
                'id' => 180,
                'country_name' => 'Puerto Rico',
                'country_code' => 'PR',
                'international_dialing' => '+1',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            171 => 
            array (
                'id' => 181,
                'country_name' => 'Qatar',
                'country_code' => 'QA',
                'international_dialing' => '+974',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            172 => 
            array (
                'id' => 182,
                'country_name' => 'Republic of the Congo',
                'country_code' => 'CG',
                'international_dialing' => '+243',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            173 => 
            array (
                'id' => 183,
                'country_name' => 'Reunion',
                'country_code' => 'RE',
                'international_dialing' => '+262',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            174 => 
            array (
                'id' => 184,
                'country_name' => 'Romania',
                'country_code' => 'RO',
                'international_dialing' => '+40',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            175 => 
            array (
                'id' => 185,
                'country_name' => 'Russia',
                'country_code' => 'RU',
                'international_dialing' => '+7',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            176 => 
            array (
                'id' => 186,
                'country_name' => 'Rwanda',
                'country_code' => 'RW',
                'international_dialing' => '+250',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            177 => 
            array (
                'id' => 189,
                'country_name' => 'Saint Kitts and Nevis',
                'country_code' => 'KN',
                'international_dialing' => '+1-869',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            178 => 
            array (
                'id' => 190,
                'country_name' => 'Saint Lucia',
                'country_code' => 'LC',
                'international_dialing' => '+1-758',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            179 => 
            array (
                'id' => 191,
                'country_name' => 'Saint Martin',
                'country_code' => 'MF',
                'international_dialing' => '+1-721',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            180 => 
            array (
                'id' => 193,
                'country_name' => 'Saint Vincent and the Grenadines',
                'country_code' => 'VC',
                'international_dialing' => '+1-784',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            181 => 
            array (
                'id' => 194,
                'country_name' => 'Samoa',
                'country_code' => 'WS',
                'international_dialing' => '+685',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            182 => 
            array (
                'id' => 195,
                'country_name' => 'San Marino',
                'country_code' => 'SM',
                'international_dialing' => '+378',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            183 => 
            array (
                'id' => 196,
                'country_name' => 'Sao Tome and Principe',
                'country_code' => 'ST',
                'international_dialing' => '+239',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            184 => 
            array (
                'id' => 197,
                'country_name' => 'Saudi Arabia',
                'country_code' => 'SA',
                'international_dialing' => '+966',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            185 => 
            array (
                'id' => 198,
                'country_name' => 'Senegal',
                'country_code' => 'SN',
                'international_dialing' => '+221',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            186 => 
            array (
                'id' => 199,
                'country_name' => 'Serbia',
                'country_code' => 'RS',
                'international_dialing' => '+381',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            187 => 
            array (
                'id' => 201,
                'country_name' => 'Seychelles',
                'country_code' => 'SC',
                'international_dialing' => '+248',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            188 => 
            array (
                'id' => 202,
                'country_name' => 'Sierra Leone',
                'country_code' => 'SL',
                'international_dialing' => '+232',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            189 => 
            array (
                'id' => 203,
                'country_name' => 'Singapore',
                'country_code' => 'SG',
                'international_dialing' => '+65',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            190 => 
            array (
                'id' => 204,
                'country_name' => 'Sint Maarten',
                'country_code' => 'SX',
                'international_dialing' => '+1-721',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            191 => 
            array (
                'id' => 205,
                'country_name' => 'Slovakia',
                'country_code' => 'SK',
                'international_dialing' => '+421',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            192 => 
            array (
                'id' => 206,
                'country_name' => 'Slovenia',
                'country_code' => 'SI',
                'international_dialing' => '+386',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            193 => 
            array (
                'id' => 207,
                'country_name' => 'Solomon Islands',
                'country_code' => 'SB',
                'international_dialing' => '+677',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            194 => 
            array (
                'id' => 208,
                'country_name' => 'Somalia',
                'country_code' => 'SO',
                'international_dialing' => '+252',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            195 => 
            array (
                'id' => 209,
                'country_name' => 'South Africa',
                'country_code' => 'ZA',
                'international_dialing' => '+27',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            196 => 
            array (
                'id' => 211,
                'country_name' => 'South Korea',
                'country_code' => 'KR',
                'international_dialing' => '+82',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            197 => 
            array (
                'id' => 212,
                'country_name' => 'South Sudan',
                'country_code' => 'SS',
                'international_dialing' => '+211',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            198 => 
            array (
                'id' => 213,
                'country_name' => 'Spain',
                'country_code' => 'ES',
                'international_dialing' => '+34',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            199 => 
            array (
                'id' => 214,
                'country_name' => 'Sri Lanka',
                'country_code' => 'LK',
                'international_dialing' => '+94',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            200 => 
            array (
                'id' => 215,
                'country_name' => 'Sudan',
                'country_code' => 'SD',
                'international_dialing' => '+249',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            201 => 
            array (
                'id' => 216,
                'country_name' => 'Suriname',
                'country_code' => 'SR',
                'international_dialing' => '+597',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            202 => 
            array (
                'id' => 218,
                'country_name' => 'Swaziland',
                'country_code' => 'SZ',
                'international_dialing' => '+268',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            203 => 
            array (
                'id' => 219,
                'country_name' => 'Sweden',
                'country_code' => 'SE',
                'international_dialing' => '+46',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            204 => 
            array (
                'id' => 220,
                'country_name' => 'Switzerland',
                'country_code' => 'CH',
                'international_dialing' => '+41',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            205 => 
            array (
                'id' => 221,
                'country_name' => 'Syria',
                'country_code' => 'SY',
                'international_dialing' => '+963',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            206 => 
            array (
                'id' => 222,
                'country_name' => 'Taiwan',
                'country_code' => 'TW',
                'international_dialing' => '+886',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            207 => 
            array (
                'id' => 223,
                'country_name' => 'Tajikistan',
                'country_code' => 'TJ',
                'international_dialing' => '+992',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            208 => 
            array (
                'id' => 224,
                'country_name' => 'Tanzania',
                'country_code' => 'TZ',
                'international_dialing' => '+255',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            209 => 
            array (
                'id' => 225,
                'country_name' => 'Thailand',
                'country_code' => 'TH',
                'international_dialing' => '+66',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            210 => 
            array (
                'id' => 226,
                'country_name' => 'Togo',
                'country_code' => 'TG',
                'international_dialing' => '+228',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            211 => 
            array (
                'id' => 228,
                'country_name' => 'Tonga',
                'country_code' => 'TO',
                'international_dialing' => '+676',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            212 => 
            array (
                'id' => 229,
                'country_name' => 'Trinidad and Tobago',
                'country_code' => 'TT',
                'international_dialing' => '+1-868',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            213 => 
            array (
                'id' => 230,
                'country_name' => 'Tunisia',
                'country_code' => 'TN',
                'international_dialing' => '+216',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            214 => 
            array (
                'id' => 231,
                'country_name' => 'Turkey',
                'country_code' => 'TR',
                'international_dialing' => '+90',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            215 => 
            array (
                'id' => 232,
                'country_name' => 'Turkmenistan',
                'country_code' => 'TM',
                'international_dialing' => '+993',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            216 => 
            array (
                'id' => 233,
                'country_name' => 'Turks and Caicos Islands',
                'country_code' => 'TC',
                'international_dialing' => '+1-649',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            217 => 
            array (
                'id' => 235,
                'country_name' => 'U.S. Virgin Islands',
                'country_code' => 'VI',
                'international_dialing' => '+1-340',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            218 => 
            array (
                'id' => 236,
                'country_name' => 'Uganda',
                'country_code' => 'UG',
                'international_dialing' => '+256',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            219 => 
            array (
                'id' => 237,
                'country_name' => 'Ukraine',
                'country_code' => 'UA',
                'international_dialing' => '+380',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            220 => 
            array (
                'id' => 238,
                'country_name' => 'United Arab Emirates',
                'country_code' => 'AE',
                'international_dialing' => '+971',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            221 => 
            array (
                'id' => 239,
                'country_name' => 'United Kingdom',
                'country_code' => 'GB',
                'international_dialing' => '+44',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            222 => 
            array (
                'id' => 240,
                'country_name' => 'United States',
                'country_code' => 'US',
                'international_dialing' => '+1',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            223 => 
            array (
                'id' => 242,
                'country_name' => 'Uruguay',
                'country_code' => 'UY',
                'international_dialing' => '+598',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            224 => 
            array (
                'id' => 243,
                'country_name' => 'Uzbekistan',
                'country_code' => 'UZ',
                'international_dialing' => '+998',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            225 => 
            array (
                'id' => 245,
                'country_name' => 'Vatican',
                'country_code' => 'VA',
                'international_dialing' => '+418',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            226 => 
            array (
                'id' => 246,
                'country_name' => 'Venezuela',
                'country_code' => 'VE',
                'international_dialing' => '+58',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            227 => 
            array (
                'id' => 247,
                'country_name' => 'Vietnam',
                'country_code' => 'VN',
                'international_dialing' => '+84',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            228 => 
            array (
                'id' => 249,
                'country_name' => 'Western Sahara',
                'country_code' => 'EH',
                'international_dialing' => '+212',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            229 => 
            array (
                'id' => 250,
                'country_name' => 'Yemen',
                'country_code' => 'YE',
                'international_dialing' => '+967',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            230 => 
            array (
                'id' => 251,
                'country_name' => 'Zambia',
                'country_code' => 'ZM',
                'international_dialing' => '+260',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
            231 => 
            array (
                'id' => 252,
                'country_name' => 'Zimbabwe',
                'country_code' => 'ZW',
                'international_dialing' => '+263',
                'is_deleted' => 0,
                'updated_at' => '2017-02-21 17:12:35',
                'created_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}