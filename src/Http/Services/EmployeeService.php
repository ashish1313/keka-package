<?php

namespace Successive\Keka\Http\Services;


use  Successive\Keka\Http\Services\CurlHelper;


class EmployeeService{


    private $kekaAuthorization;

    public function __construct()
    {
        $this->kekaAuthorization = new KekaAuthorization();
    }

    //Employee API's
    const GET_ALL_EMPLOYEES_API = 'https://api.keka.com/v1/employees';
    const GET_EMPLOYEE_BY_ID_API = 'https://api.keka.com/v1/employees/';

    //method constants
    const POST_METHOD = 'POST';
    const  GET_METHOD = 'GET';

    public function getEmployees($data = false){
//        $this->kekaAuthorization->setAccessToken();
//        if(time() > $_SESSION['access_token_expiry'] || isset($_SESSION['access_token_expiry']) ){
//            $this->kekaAuthorization->setAccessToken();
//        }
//        print_r($_SESSION); die('in here');
        return CurlHelper::CallAPI(self::POST_METHOD, self::GET_ALL_EMPLOYEES_API, $data);
    }

    public static function getEmployeeBYId($data){
        if(is_string($data)){
            return CurlHelper::CallAPI(self::GET_METHOD, self::GET_EMPLOYEE_BY_ID_API, ['id' => $data]);
        }
        return CurlHelper::CallAPI(self::GET_METHOD, self::GET_EMPLOYEE_BY_ID_API, $data);
    }
}

