<?php

namespace Successive\Keka\Http\Services;

/**
 * Class CurlHelper
 * @package Successive\Keka\Http\Services
 */
class CurlHelper
{
    /**
     * @var KekaAuthorization
     */
    private $kekaAuthorization;

    /**
     * CurlHelper constructor.
     */
    public function __construct()
    {
        $this->kekaAuthorization = new KekaAuthorization();
    }


    /**
     *
     * @param $method
     * @param $url
     * @param bool $data
     * @return mixed
     * @throws \Exception
     */
    public function CallAPI($method, $url, $data = false)
    {
        if (isset($_SESSION['access_token_expiry'])) {
            if (time() > $_SESSION['access_token_expiry']){
                $this->kekaAuthorization->setAccessToken();
            }
        }else
            $this->kekaAuthorization->setAccessToken();

        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        $header = array("Authorization: Bearer {$_SESSION['access_token']}");

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

}
