<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RKeeper\RKeeperGetOpenTables;
use Illuminate\Http\Request;

class TablesController extends Controller
{
    protected RKeeperGetOpenTables $rKeeperGetOrderTables;
    public function __construct(RKeeperGetOpenTables $rKeeperGetOrderTables)
    {
        $this ->rKeeperGetOrderTables = $rKeeperGetOrderTables;
    }
    public function getOpenTables(Request $request)
    {
        $tables = $this -> rKeeperGetOrderTables->getTables();
        return $tables;
    }
}
