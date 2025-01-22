<?php

namespace App\Services;

class GenerateUniqueIdService
{
    public function generateUserId($countryCode, $userCategory)
    {
        // Step 1: Define country codes mapping
        $countryMapping = [
            'Angola' => 'AO',
            'Botswana' => 'BW',
            'Cameroon' => 'CM',
            'Congo Democratic Republic (DRC)' => 'CD',
            'Cote-divorie' => 'CI',
            'Eswatini (Swaziland)' => 'SZ',
            'Ethiopia' => 'ET',
            'Ghana' => 'GH',
            'Kenya' => 'KE',
            'Lesotho' => 'LS',
            'Malawi' => 'MW',
            'Mozambique' => 'MZ',
            'Namibia' => 'NA',
            'Nigeria' => 'NG',
            'Rwanda' => 'RW',
            'Senegal' => 'SN',
            'Sierra Leone' => 'SL',
            'Somalia' => 'SO',
            'South Africa' => 'ZA',
            'South Sudan' => 'SS',
            'Tanzania' => 'TZ',
            'Uganda' => 'UG',
            'Zambia' => 'ZM',
            'Zimbabwe' => 'ZW'
        ];

        // Step 2: Define user category codes
        $userCategoryMapping = [
            'Individual' => 'IN',
            'Aggregator' => 'AG',
            'Agro-Dealer' => 'AD',
            'Agronomist' => 'AG',
            'Apiarist' => 'AP',
            'Aquaculture' => 'AQ',
            'Building Construction' => 'BC',
            'Electrician' => 'EL',
            'Enterprise consultant' => 'EC',
            'Finance Consultant' => 'FC',
            'Green House' => 'GH',
            'Irrigation' => 'IR',
            'Laboratory' => 'LB',
            'Logistics' => 'LG',
            'Marketing' => 'MK',
            'Packaging' => 'PC',
            'Refrigeration' => 'RF',
            'Security' => 'SC',
            'Survey' => 'SV',
            'Tractor' => 'TC',
            'Training' => 'TR',
            'Value Addition' => 'VA',
            'Veterinary' => 'VT'
        ];

        // Step 3: Check if the country code and user category are valid
        $countryCode = $countryMapping[$countryCode] ?? null;
        $userCategoryCode = $userCategoryMapping[$userCategory] ?? null;

        if (!$countryCode) {
            throw new \Exception("Invalid country code.");
        }

        if (!$userCategoryCode) {
            throw new \Exception("Invalid user category.");
        }

        // Step 4: Generate a random 6-digit number
        $randomNumber = mt_rand(100000, 999999);

        // Step 5: Combine all the parts to form the User ID
        $userId = 'FN' . $countryCode . $userCategoryCode . $randomNumber;

        return $userId;
    }
}
