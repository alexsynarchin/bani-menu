<?php

namespace App\Services\RKeeper;
use App\Models\Category;
use App\Models\Product;
use App\Services\RKeeper\RKeeperBaseRequest;
class RKeeperCatalog
{
    protected RKeeperBaseRequest $rKeeperBaseRequest;
    public function __construct(rKeeperBaseRequest $rKeeperBaseRequest)
    {
        $this->rKeeperBaseRequest = $rKeeperBaseRequest;
    }
    public function getCategoriesList()
    {
        $count = Category::count();
        $xml='<?xml version="1.0" encoding="UTF-8"?>
                <RK7Query >
                    <RK7CMD CMD="GetRefData" RefName="CATEGLIST" OnlyActive="true" WithChildItems="2" PropMask="*">
                    </RK7CMD>
                </RK7Query>';
        $categoriesXml = simplexml_load_string($this -> rKeeperBaseRequest->baseRequest($xml));
        $i = 0;
        foreach ($categoriesXml ->    RK7Reference -> Items -> Item as $categoryItem) {
            if($count > 0) {
                if (Category::where('r_id', $categoryItem['ItemIdent']) -> exists()) {
                   $category = Category::where('r_id', $categoryItem['ItemIdent'])->first();

                   $productsXml = $categoryItem -> RIChildItems ;
                    if(isset($productsXml -> TRK7MenuItem)) {
                        foreach ($productsXml -> TRK7MenuItem  as $productItem) {

                             $product = Product::updateOrCreate(
                                  ['r_id' => $productItem['ItemIdent']],
                                  ['title' => $productItem['Name'], 'category_id' => $category->id]);
                        }
                    }

                }
            } else {
                $category = Category::firstOrCreate([
                    'title' => $categoryItem['Name'],
                    'r_id' => $categoryItem['ItemIdent'],
                    'parent_id' => $categoryItem['Parent'],
                ]);
            }

        }
        $categories = Category::all();

        if($count === 0) {
            foreach ($categories as $category) {
                if($category->parent_id !== 0){
                    $parentCategory = Category::where('r_id', $category->parent_id) -> firstOrFail();
                    $category->parent_id = $parentCategory->id;
                    $category->save();
                }
            }
        }

        $this->getProductsPrices();
        return $categories;
    }

    public function getProductsPrices() {
        $xml='<?xml version="1.0" encoding="UTF-8"?>
                <RK7Query>
                    <RK7CMD CMD="GetOrderMenu" >
                        <Station code="1"/>
                    </RK7CMD>
                </RK7Query>';
        $productsXml = simplexml_load_string($this -> rKeeperBaseRequest->baseRequest($xml));
        foreach ($productsXml ->    Dishes  -> Item as $productItem) {
            if( Product::where('r_id', $productItem['Ident'])->exists()) {
                $product = Product::where('r_id', $productItem['Ident'])->first();
                $product -> price = $productItem['Price'] / 100;
                $product -> save();
            }
        }
    }
}
