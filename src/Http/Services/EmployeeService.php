<?php

namespace Successive\Keka\Http\Services;

use  Successive\Keka\Http\Services\CurlHelper;

/**
 * Class EmployeeService
 * @package Successive\Keka\Http\Services
 */
class EmployeeService
{


    private $curlHelper;

    //Employee API's
    const ALL_EMPLOYEES_ENDPOINT = '/v1/employees';
    const EMPLOYEE_BY_ID_ENDPOINT = '/v1/employees/';
    const PROBATION_EMPLOYEES_ENDPOINT = '/v1/employees/views/probation';

    //method constants
    const  GET_METHOD = 'GET';

    public function __construct()
    {
        $this->curlHelper = new CurlHelper();
    }

    /**
     * @param bool $data
     * @return mixed
     */
    public function getEmployees($data = false)
    {
        try {
            return $this->curlHelper->CallAPI(self::GET_METHOD, self::ALL_EMPLOYEES_ENDPOINT, $data);
        }catch (\Exception $exception){
            return $exception;
        }
    }

    /**
     * get employee data
     *
     * @param $data
     * @return mixed
     */
    public function getEmployeeByEmpNo($data)
    {
        try {
            if (is_string($data)) {
                return $this->curlHelper->CallAPI(self::GET_METHOD, self::EMPLOYEE_BY_ID_ENDPOINT, ['employeenumber' => $data]);
            }
            return $this->curlHelper->CallAPI(self::GET_METHOD, self::EMPLOYEE_BY_ID_ENDPOINT, $data);
        }catch (\Exception $exception){
            return $exception;
        }
    }

    /**
     * gets all birthdays for current month
     *
     * @return array|\Exception|mixed
     */
    public function currentMonthBirthdays()
    {
        try {
            $response = json_decode($this->getEmployees(), true);

            if (array_key_exists('message', $response)) {
                return $response;
            }

            return array_filter($response, function ($record) {
                if (date('m', strtotime($record['dateOfBirth'])) === date('m')) {
                    return true;
                }
                return false;
            });
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * gets all joinees for current month
     *
     * @return array|\Exception|mixed
     */
    public function currentMonthJoinees()
    {
        try {
            $response = json_decode(
                $this->curlHelper->CallAPI(self::GET_METHOD, self::PROBATION_EMPLOYEES_ENDPOINT),
                true
            );
            if (array_key_exists('message', $response)) {
                return $response;
            }

            return array_filter($response, function ($record) {
                if (date('m', strtotime($record['joiningDate'])) === date('m')) {
                    return true;
                }
                return false;
            });
        } catch (\Exception $exception) {
            return $exception;
        }
    }

}

