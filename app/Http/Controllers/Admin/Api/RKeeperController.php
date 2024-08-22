<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Services\RKeeper\RKeeperCatalog;
use Illuminate\Http\Request;

class RKeeperController extends Controller
{
    protected RKeeperCatalog $rKeeperCatalog;
    public function __construct(RKeeperCatalog $rKeeperCatalog)
    {
        $this->rKeeperCatalog = $rKeeperCatalog;
    }
    public function synchronizeMenu(Request $request)
    {
        $catalog = $this-> rKeeperCatalog->getCategoriesList();
        return $catalog;
    }
}
