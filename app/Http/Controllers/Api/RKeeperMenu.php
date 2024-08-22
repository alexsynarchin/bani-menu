<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RKeeper\RKeeperGetOrderMenu;
use Illuminate\Http\Request;

class RKeeperMenu extends Controller
{
    protected RKeeperGetOrderMenu $rKeeperGetOrderMenu;
    public function __construct(RKeeperGetOrderMenu $rKeeperGetOrderMenu)
    {
        $this->rKeeperGetOrderMenu = $rKeeperGetOrderMenu;
    }

    public function index()
    {
        dd($this->rKeeperGetOrderMenu->execute());
    }
}
