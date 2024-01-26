<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiGenralTrait;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    use ApiGenralTrait;
    public function show()
    {
        $mainCategories = MainCategory::selection()->get();
        // return response()->json($mainCategories);
        return $this->returnData('Main categories',$mainCategories,'found succesfuly');
    }

    public function getCategoryById(request $request)
    {
        $category = MainCategory::selection()->find($request->id);
        if (!$category)
            return  $this->returnError(405, 'not found');

        return $this->returnData("category with Id " . $request->id, $category, 'found successfuly');
    }

    public function changeActivtion(Request $request)
    {
        $category = MainCategory::find($request->id);
        if (!$category)
            return $this->returnError(405, 'not found');
        if ($request->active == 0 || $request->active == 1) {
            MainCategory::where('id', $request->id)->update(['active' => $request->active]);
            return $this->returnSucces(300, 'activtion status updated successfuly');
        } else
            return $this->returnError(811, 'activation code is out of range');
    }
}
