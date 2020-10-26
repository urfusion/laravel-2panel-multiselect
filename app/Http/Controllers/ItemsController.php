<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemsController extends Controller {

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function create(Request $request) {
        //function for saving item
        $response = [];
        if ($request->name) {
            $response['status'] = true;
            $response['id'] = Item::create(['name' => $request->name]);
        } else {
            $response['status'] = false;
        }
        return response()->json($response);
    }

    /**
     * 
     * @return type
     */
    public function getItems() {
        //function for getting items
        $response = Item::all();
        return response()->json($response);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function selected(Request $request) {
        //function for selected item
        $response = [];
        if ($request->name) {
            $response['status'] = true;
            $response['id'] = Item::where('name', $request->name)->update(['is_selected' => 1]);
        } else {
            $response['status'] = false;
        }
        return response()->json($response);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function unSelected(Request $request) {
        //function for un-selected item
        $response = [];
        if ($request->name) {
            $response['status'] = true;
            $response['id'] = Item::where('name', $request->name)->update(['is_selected' => 0]);
        } else {
            $response['status'] = false;
        }
        return response()->json($response);
    }

}
