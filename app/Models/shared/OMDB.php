<?php

namespace App\Models\shared;

use Exception;

class OMDB
{
    public static function GetMovieData($title) : array {
        $apiKey = getenv('OMDB_API_KEY');
        if(!$apiKey) {
            throw new Exception("OMDB_API_KEY not defined");
        }

        // URL encode the title to handle spaces and special characters
        $encodedTitle = urlencode($title);
        $url = "https://www.omdbapi.com/?t={$encodedTitle}&apikey={$apiKey}";

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute the request
        $responseBody = curl_exec($ch);

        // Check for errors
        if(curl_errno($ch)){
            curl_close($ch);
            throw new Exception("cURL error: " . curl_error($ch));
        }
        curl_close($ch);

        // Decode JSON response
        $jsonObject = json_decode($responseBody, true);

        // Prepare default image URL
        $defaultImage = "https://media.istockphoto.com/id/1472933890/vector/no-image-vector-symbol-missing-available-icon-no-gallery-for-this-moment-placeholder.jpg?s=612x612&w=0&k=20&c=Rdn-lecwAj8ciQEccm0Ep2RX50FCuUJOaEM8qQjiLL0=";

        $data = array();

        // Handle Poster
        if (isset($jsonObject['Poster']) && $jsonObject['Poster'] !== 'N/A') {
            $data['poster'] = $jsonObject['Poster'];
        } else {
            $data['poster'] = $defaultImage;
        }

        // Handle Plot
        if (isset($jsonObject['Plot'])) {
            $data['plot'] = $jsonObject['Plot'];
        } else {
            $data['plot'] = "";
        }

        return $data;
    }
}
