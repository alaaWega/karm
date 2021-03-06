<?php

namespace App\Services;
use App\Models\MealAddition;
use App\Models\MealImage;
use App\Models\MealSize;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\Datatables\Datatables as Datatables;
use App\Models\Meal;
use App\Services\UtilityService;

class MealService
{
    private $utilityService;
    public function __construct(UtilityService $utilityService){
        $this->utilityService = $utilityService;
    }

    /**
     * List all Meals.
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function listMeals()
    {
        return Meal::get();
    }

    /**
     * Datatebles
     * @param $Meals
     * @return datatable.
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function datatables($meals)
    {
        $tableData = Datatables::of($meals)
            ->addColumn('is_active', function (Meal $meal){
                if($meal->is_active)
                    return '<span class="label label-sm label-primary"> نشط </span>';
                else
                    return '<span class="label label-sm label-warning">غير نشط</span>';
            })
            ->addColumn('category', function (Meal $meal){
                    return $meal->getCategory->name;
            })
            ->addColumn('images', function (Meal $meal){
                if(count($meal->getImages) > 0)
                    return '<a href="meal-images/'.$meal->id.'"> <span class="label label-sm label-primary"> عرض الصور </span></a>';
                else
                    return '<a href="meal-images/'.$meal->id.'"> <span class="label label-sm label-success"> أضافة صور </span></a>';
            })
            ->addColumn('sizes', function (Meal $meal){
                if(count($meal->getSizes) > 0)
                    return '<a href="meal-sizes/'.$meal->id.'"> <span class="label label-sm label-primary"> عرض الأحجام </span></a>';
                else
                    return '<a href="meal-sizes/'.$meal->id.'"> <span class="label label-sm label-success"> أضافة حجم </span></a>';
            })
            ->addColumn('additions', function (Meal $meal){
                if(count($meal->getAdditions) > 0)
                    return '<a href="meal-additions/'.$meal->id.'"> <span class="label label-sm label-primary"> عرض الأضافات </span></a>';
                else
                    return '<a href="meal-additions/'.$meal->id.'"> <span class="label label-sm label-success"> أضافة </span></a>';
            })
            ->addColumn('actions', function ($data)
            {
                return view('partials.actionBtns')->with('controller','meals')
                    ->with('id', $data->id)
                    ->render();
            })->rawColumns(['actions', 'is_active', 'images', 'sizes', 'additions'])->make(true);

        return $tableData ;
    }

    public function datatables_($images)
    {
        $tableData = Datatables::of($images)
            ->editColumn('image', '<a href="javascript:;"><img src="{{ config("app.baseUrl").$image }}" class="image" width="50px" height="50px"></a>')
            ->setRowId('id')
            ->addColumn('actions', function ($data)
            {
                return view('meal-images.actionBtns')->with('controller','meal-images')
                    ->with('id', $data->id)
                    ->render();
            })->rawColumns(['actions', 'image'])->make(true);

        return $tableData ;
    }

    public function datatablesSizes($sizes)
    {
        $tableData = Datatables::of($sizes)
            ->addColumn('actions', function ($data)
            {
                return view('meal-sizes.actionBtns')->with('controller','meal-sizes')
                    ->with('id', $data->id)
                    ->render();
            })->rawColumns(['actions'])->make(true);

        return $tableData ;
    }

    public function datatablesAdditions($additions)
    {
        $tableData = Datatables::of($additions)
            ->addColumn('meal', function (MealAddition $addition) {
                return $addition->getMeal->name;
            })
            ->addColumn('addition', function (MealAddition $addition) {
                return $addition->getAddition->name;
            })
            ->setRowId('id')
            ->addColumn('actions', function ($data)
            {
                return view('partials.actionBtns')->with('controller','meal-additions')
                    ->with('id', $data->id)
                    ->render();
            })->rawColumns(['actions', 'meal', 'addition'])->make(true);

        return $tableData ;
    }

    /**
     * Get description.
     * @param $mealId
     * @return Meal
     * @author Alaa <alaaragab34@gmail.com>
     */


    public function getMeal($mealId)
    {
        try {
            $meal = Meal::findOrFail($mealId);
            return $meal;
        }
        catch(ModelNotFoundException $ex){
            return array('status' => 'false', 'message' => 'Meal not found');
        }
    }

    public function getMealSizes($mealId)
    {
        try {
            $sizes = MealSize::where('meal_id', $mealId)->get();
            return $sizes;
        }
        catch(ModelNotFoundException $ex){
            return array('status' => 'false', 'message' => 'Meal not found');
        }
    }

    public function getMealAddition($mealAdditionId)
    {
        try {
            $mealAddition = MealAddition::findOrFail($mealAdditionId);
            return $mealAddition;
        }
        catch(ModelNotFoundException $ex){
            return array('status' => 'false', 'message' => 'Meal addition not found');
        }
    }

    public function getMealAdditions($mealId)
    {
        try {
            $additions = MealAddition::where('meal_id', $mealId)->get();
            return $additions;
        }
        catch(ModelNotFoundException $ex){
            return array('status' => 'false', 'message' => 'Meal not found');
        }
    }

    public function getMealImages($mealId)
    {
        try {
            $images = MealImage::where('meal_id', $mealId)->get();
            return $images;
        }
        catch(ModelNotFoundException $ex){
            return array('status' => 'false', 'message' => 'Meal not found');
        }
    }

    /**
     * Create description.
     * @param $type
     * @param $username
     * @param $display_name
     * @param $phone
     * @param $image
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function createMeal($parameters)
    {
        try {
            if(Meal::where('name', $parameters['name'])->first())
                return \Response::json(['msg'=>'هذه الوجبة موجود بالفعل'],404);

            $meal = new Meal();
            $meal_id = $meal->create($parameters)->id;
            if($meal){
                if(isset($parameters['images']) && $parameters['images']){
                    foreach ($parameters['images'] as $image){
                        $data = $this->utilityService->uploadImage($image);
                        if(!$data['status'])
                            return response(array('msg' => $data['errors']), 404);

                        $mealImage = new MealImage();
                        $mealImage->image = $data['image'];
                        $mealImage->meal_id = $meal_id;
                        $mealImage->save();
                    }
                }else{
                    return response(array('msg' => 'Image required'), 404);
                }
            }
            return \Response::json(['msg'=>'تم التسجيل بنجاح'],200);
        }
        catch(ModelNotFoundException $ex){
            return \Response::json(['msg'=>'حدث خطا'],404);
        }
    }

    public function createMealImages($parameters)
    {
        try {
            if(isset($parameters['images']) && $parameters['images']){
                foreach ($parameters['images'] as $image){
                    $data = $this->utilityService->uploadImage($image);
                    if(!$data['status'])
                        return response(array('msg' => $data['errors']), 404);

                    $max = MealImage::max('sort');
                    $mealImage = new MealImage();
                    $mealImage->image = $data['image'];
                    $mealImage->meal_id = $parameters['meal_id'];
                    $mealImage->sort = $max + 1;;
                    $mealImage->save();
                    }
                }else{
                    return response(array('msg' => 'Image required'), 404);
                }
            return \Response::json(['msg'=>'تم التسجيل بنجاح'],200);
        }
        catch(ModelNotFoundException $ex){
            return \Response::json(['msg'=>'حدث خطا'],404);
        }
    }

    public function createMealSize($parameters)
    {
        try {
            if(MealSize::where('size', $parameters['size'])->where('meal_id', $parameters['meal_id'])->first())
                return \Response::json(['msg'=>'هذا الحجم موجود بالفعل'],404);

            $mealSize = new MealSize();
            $mealSize->create($parameters);
            return \Response::json(['msg'=>'تم التسجيل بنجاح'],200);
        }
        catch(ModelNotFoundException $ex){
            return \Response::json(['msg'=>'حدث خطا'],404);
        }
    }

    public function createMealAddition($parameters)
    {
        try {
            if(MealAddition::where('addition_id', $parameters['addition_id'])->where('meal_id', $parameters['meal_id'])->first())
                return \Response::json(['msg'=>'هذه الأضافه موجوده بالفعل'],404);

            $max = MealAddition::max('sort');
            $parameters['sort'] = $max + 1;

            $mealAddition = new MealAddition();
            $mealAddition->create($parameters);
            return \Response::json(['msg'=>'تم التسجيل بنجاح'],200);
        }
        catch(ModelNotFoundException $ex){
            return \Response::json(['msg'=>'حدث خطا'],404);
        }
    }

    /**
     * Update user.
     * @param $username
     * @param $display_name
     * @param $phone
     * @param $image
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function updateMeal($mealId, $parameters, $images, $image)
    {
        try {
            $meal = Meal::findOrFail($mealId);
            if(isset($images['image']) && $images['image'] != ""){
                $data = $this->utilityService->uploadImage($images['image']);
                if(!$data['status'])
                    return response(array('msg' => $data['errors']), 404);
                $parameters['image'] = $data['image'];
            }else{
                $parameters['image']  = $image;
            }

            if(Meal::where('name', $parameters['name'])->where('id', '!=', $mealId)->first())
                return \Response::json(['msg'=>'هذه الوجبة موجود بالفعل'],404);

            $meal->update($parameters);
            return \Response::json(['msg'=>'تم تحديث الوجبة بنجاح'],200);
        }
        catch(ModelNotFoundException $ex){
            return \Response::json(['msg'=>'حدث خطا'],404);
        }
    }

    public function updateMealAddition($parameters, $additionId)
    {
        try {
            $mealAddition = MealAddition::findOrFail($additionId);

            if(MealAddition::where('addition_id', $parameters['addition_id'])->where('meal_id', $parameters['meal_id'])->where('id', '!=', $additionId)->first())
                return \Response::json(['msg'=>'هذه الأضافه موجوده بالفعل'],404);

            $mealAddition->update($parameters);
            return \Response::json(['msg'=>'تم تحديث الوجبة بنجاح'],200);
        }
        catch(ModelNotFoundException $ex){
            return \Response::json(['msg'=>'حدث خطا'],404);
        }
    }

    /**
     * Delete Meal.
     * @param $MealId
     * @return Meal
     * @author Alaa <alaaragab34@gmail.com>
     */
    public function deleteMeal($meal)
    {
        return Meal::find($meal)->delete();
    }

    public function deleteMealAddition($mealAddition)
    {
        return MealAddition::find($mealAddition)->delete();
    }

    public function deleteImage($mealImage)
    {
        return MealImage::find($mealImage)->delete();
    }

    public function deleteSize($mealSize)
    {
        return MealSize::find($mealSize)->delete();
    }

    public function sortMealImages($ids)
    {
        for($i = 0; $i < count($ids); $i++){
            $image = MealImage::findOrFail($ids[$i]);
            $image->sort = $i+1;
            $image->save();
        }
    }

    public function sortMealAdditions($ids)
    {
        for($i = 0; $i < count($ids); $i++){
            $mealAddition = MealAddition::findOrFail($ids[$i]);
            $mealAddition->sort = $i+1;
            $mealAddition->save();
        }
    }
}
