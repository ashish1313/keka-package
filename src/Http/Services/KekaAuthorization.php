<?php

namespace Successive\Keka\Http\Services;

/**
 * Class KekaAuthorization
 * @package Successive\Keka\Http\Services
 */
class KekaAuthorization
{

    private const TOKEN_URL = 'https://app.keka.com/connect/token';
    private const scope = 'kekaapi';
    private const GRANT_TYPE = 'kekaapi';


    /**
     *get the access token and set it into session
     *
     * @return bool
     * @throws \Exception
     */
    public function setAccessToken()
    {

        $clientDetails = $this->getClientDetails();
        $data = $this->getAuthorizationToken($clientDetails);

        if (array_key_exists('error', $data)) {
            throw new \Exception($data['error']);
        }

        if (array_key_exists('access_token', $data) && array_key_exists('expires_in', $data)) {
            session_start();
            // Save the access token expiry timestamp
            $_SESSION['access_token_expiry'] = time() + $data['expires_in'];

            $_SESSION['access_token'] = $data['access_token'];
            return true;
        } else {
            throw new \Exception('Response does not contain either Access token or Expiry time');
        }
    }

    /**
     * get the access token
     *
     * @param $clientDetails
     * @return \Exception|mixed
     */
    public function getAuthorizationToken($clientDetails)
    {
        try {
            $client_id = $clientDetails['keka_client_id'];
            $client_secret = $clientDetails['keka_secret_key'];
            $content = "grant_type=" . self::GRANT_TYPE . "&scope=" . self::scope . '&apikey=' . $clientDetails['apikey'];
            $authorization = base64_encode("$client_id:$client_secret");
            $header = array("Authorization: Basic {$authorization}",
                "Content-Type: application/x-www-form-urlencoded",
                "Host: app.keka.com");

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
            return json_decode($response, true);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * get the client details from project's env
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getClientDetails()
    {
//        $clientDetails['keka_client_id'] = config('keka.keka_client_id');
//        $clientDetails['keka_secret_key'] = config('keka.keka_secret_key');
//        $clientDetails['apikey'] = config('keka.api_key');
        $clientDetails['keka_client_id'] = 'd25c85ab-76de-4df0-af0b-5bb72491c3b1';
        $clientDetails['keka_secret_key'] = 'iIHVhbUiDyQeiedcQNfW';
        $clientDetails['apikey'] = 'xnxL4TmblPYFNhTtT9UCrUeRledrXGKpKXKu5qYgJsY=';
        if ($clientDetails['keka_client_id'] && $clientDetails['keka_secret_key'] && $clientDetails['apikey']) {
            return $clientDetails;
        } else
            throw new \Exception('Please Provide the Keka Client Details');

    }

}
