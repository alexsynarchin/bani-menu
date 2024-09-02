<?php

namespace App\Services\RKeeper;
use App\Services\RKeeper\RKeeperBaseRequest;
class RKeeperGetEmployees
{
    protected RKeeperBaseRequest $rKeeperBaseRequest;
    public function __construct(rKeeperBaseRequest $rKeeperBaseRequest)
    {
        $this->rKeeperBaseRequest = $rKeeperBaseRequest;
    }

    public function getEmployees()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <RK7Query>
                <RK7CMD CMD="GetRefData" RefName="EMPLOYEES" />
            </RK7Query>
        ';
        $employees = [];
        $employeesXML = simplexml_load_string($this -> rKeeperBaseRequest->baseRequest($xml));
        foreach ($employeesXML  ->    RK7Reference -> Items -> Item as $employeeItem) {
            if($employeeItem['Status']  == 'rsActive' && $employeeItem['Code']) {
                $employees[] = [
                    'name' => (string) $employeeItem['Name'],
                    'r_code' => (int) $employeeItem['Code'],
                ];
            }
        }
        return $employees;
    }
}
