<?php

namespace Successive\Keka\Http\Services;

class KekaAuthorization{

    private $accessToken;
//    private const AUTHORIZATION_URL = 'https://app.keka.com/connect/authorize';
    private const TOKEN_URL = 'https://app.keka.com/connect/token';
    private const scope = 'kekaapi';
    private const GRANT_TYPE = 'code';

    public function setAccessToken(){

        if($this->accessToken){
            return $this->accessToken;
        }
        $clientDetails = $this->getClientDetails();
        $data = $this->getAuthorizationToken($clientDetails);

        if ($data instanceof \Exception){
            return $data;
        }

        // Access Token
//        $access_token = $data['access_token'];

        // Refresh Token
        if(array_key_exists('refresh_token', $data))
            $refresh_token = $data['refresh_token'];

        // Save the access token expiry timestamp
        $_SESSION['access_token_expiry'] = time() + $data['expires_in'];

        $_SESSION['access_token'] = $data['access_token'];


    }

    protected function getAuthorizationToken($clientDetails){
        try {
            $client_id = $clientDetails['client_id'];
            $client_secret = $clientDetails['client_secret'];
            $content = "grant_type=".self::GRANT_TYPE."&scope=".self::scope;

            $authorization = base64_encode("$client_id:$client_secret");
            $header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => self::TOKEN_URL,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $content
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            return json_decode($response);
        }catch (\Exception $exception){
            return $exception;
        }
    }

    protected function getClientDetails(){
        $clientDetails['client_id'] = env('keka_client_id', '');
        $clientDetails['client_secret'] = env('keka_secret_key', '');

        if($clientDetails['client_id'] && $clientDetails['client_secret']){
            return $clientDetails;
        }else
            throw new \Exception('Please Provide the Client Details');

    }

}
