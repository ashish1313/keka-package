<?php

namespace Successive\Keka\Http\Services;


use Illuminate\Support\Facades\Redis;
use  Successive\Keka\Http\Services\CurlHelper;


class EmployeeService{


    private $curlHelper;

    public function __construct()
    {
        $this->curlHelper = new CurlHelper();
    }

    //Employee API's
    const GET_ALL_EMPLOYEES_API = 'https://api.keka.com/v1/employees';
    const GET_EMPLOYEE_BY_ID_API = 'https://api.keka.com/v1/employees/';

    //method constants
    const POST_METHOD = 'POST';
    const  GET_METHOD = 'GET';

    /**
     * @param bool $data
     * @return mixed
     */
    public function getEmployees($data = false){
        return $this->curlHelper->CallAPI(self::POST_METHOD, self::GET_ALL_EMPLOYEES_API, $data);
    }

    /**
     * get employee data
     *
     * @param $data
     * @return mixed
     */
    public function getEmployeeBYId($data){
        if(is_string($data)){
            return $this->curlHelper->CallAPI(self::GET_METHOD, self::GET_EMPLOYEE_BY_ID_API, ['id' => $data]);
        }
        return $this->curlHelper->CallAPI(self::GET_METHOD, self::GET_EMPLOYEE_BY_ID_API, $data);
    }
}

