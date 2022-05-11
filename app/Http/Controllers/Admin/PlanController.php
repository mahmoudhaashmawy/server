<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use App\Models\PlanLog;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('category')->latest()->paginate(getPaginate());
        $pageTitle = 'Tour Plans';
        $empty_message = 'No plan has been added.';
        return view('admin.plan.index', compact('pageTitle', 'empty_message', 'plans'));
    }

    public function add()
    {
        $pageTitle = 'Add Plan';
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.plan.add', compact('pageTitle', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'location' => 'required|string',
            'map_latitude' => 'required|string',
            'map_longitude' => 'required|string',
            'duration' => 'required|string',
            'departure_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:today',
            'return_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:departure_time',
            'capacity' => 'required|integer|gte:0',
            'price' => 'required|numeric|gte:0',
            'details' => 'required|string',
            'included' => 'array',
            'included.*' => 'required',
            'excluded.*' => 'required|string',
            'title.*' => 'required|array',
            'subtitle.*' => 'required|string',
            'content.*' => 'required|string',
            'images.*' => ['required', 'max:10000', new FileTypeValidate(['jpeg','jpg','png','gif'])]
        ]);


        $plan = new Plan();
        $plan->name = $request->name;
        $plan->category_id = $request->category_id;
        $plan->location = $request->location;
        $plan->map_latitude = $request->map_latitude;
        $plan->map_longitude = $request->map_longitude;
        $plan->duration = $request->duration;
        $plan->departure_time = Carbon::create($request->departure_time);
        $plan->return_time = Carbon::create($request->return_time);
        $plan->capacity = $request->capacity;
        $plan->price = $request->price;
        $plan->details = $request->details;
        $plan->included = $request->included ?? [];
        $plan->excluded = $request->excluded ?? [];

        if ($request->title) {
            foreach ($request->title as $key => $item) {
                $tour_plans[$item] = [
                    $request->title[$key],
                    $request->subtitle[$key],
                    $request->content[$key]
                ];
            }
        }
        $plan->tour_plan = @$tour_plans ?? [];

        // Upload image
        foreach ($request->images as $image) {
            $path = imagePath()['plans']['path'];
            $size = imagePath()['plans']['size'];
            $images[] = uploadImage($image, $path, $size);
        }
        $plan->images = $images;

        $plan->save();

        $notify[] = ['success', 'Plan Added Successfully!'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $pageTitle = 'Edit Plan';
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.plan.edit', compact('pageTitle', 'categories', 'plan'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'location' => 'required|string',
            'map_latitude' => 'required|string',
            'map_longitude' => 'required|string',
            'duration' => 'required|string',
            'departure_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:today',
            'return_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:departure_time',
            'capacity' => 'required|integer|gte:0',
            'price' => 'required|numeric|gte:0',
            'details' => 'required|string',
            'included.*' => 'required|string',
            'excluded.*' => 'required|string',
            'title.*' => 'required|string',
            'subtitle.*' => 'required|string',
            'content.*' => 'required|string',
            'images.*' => ['required', 'max:10000', new FileTypeValidate(['jpeg','jpg','png','gif'])]
        ]);

        $plan = Plan::findOrFail($id);
        $plan->name = $request->name;
        $plan->category_id = $request->category_id;
        $plan->location = $request->location;
        $plan->map_latitude = $request->map_latitude;
        $plan->map_longitude = $request->map_longitude;
        $plan->duration = $request->duration;
        $plan->departure_time = Carbon::create($request->departure_time);
        $plan->return_time = Carbon::create($request->return_time);
        $plan->capacity = $request->capacity;
        $plan->price = $request->price;
        $plan->details = $request->details;
        $plan->included = $request->included ?? [];
        $plan->excluded = $request->excluded ?? [];

        if ($request->title) {
            foreach ($request->title as $key => $item) {
                $tour_plans[$item] = [
                    $request->title[$key],
                    $request->subtitle[$key],
                    $request->content[$key]
                ];
            }
        }
        $plan->tour_plan = @$tour_plans ?? [];

        // Upload and Update image
        if ($request->images){
            foreach ($request->images as $image) {
                $path = imagePath()['plans']['path'];
                $size = imagePath()['plans']['size'];

                $images[] = uploadImage($image, $path, $size);
            }
            $plan->images = array_merge((array)$plan->images, $images);
        }

        $plan->save();

        $notify[] = ['success', 'Plan Updated Successfully!'];
        return back()->withNotify($notify);
    }

    public function deleteImage($id, $image)
    {
        $plan = Plan::findOrFail($id);
        $images = (array)$plan->images;
        $path = imagePath()['plans']['path'];
        if (($key = array_search($image, $images)) !== false) {
            removeFile($path.'/' . $image);
            unset($images[$key]);
        }
        $plan->images = $images;
        $plan->save();

        return response()->json(['success' => true, 'message' => 'Plan image deleted!']);
    }

    public function status($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->status = ($plan->status ? 0 : 1);
        $plan->save();

        $notify[] = ['success', ($plan->status ? 'Activated!' : 'Deactivated!')];
        return back()->withNotify($notify);
    }

    //Booking Log
    public function bookingLog()
    {
        $plan_logs = PlanLog::where('type','tour')->where('status',1)->with(['plan', 'user'])->latest()->paginate(getPaginate());
        $pageTitle = 'Tour Booking Log';
        $empty_message = 'No data found.';
        return view('admin.plan.bookinglog', compact('pageTitle', 'empty_message', 'plan_logs'));
    }

    public function userBookingLog($id)
    {
        $plan_logs = PlanLog::where('type','tour')->where('status',1)->where('user_id', $id)->with(['plan', 'user'])->latest()->paginate(getPaginate());
        $pageTitle = 'User Tour Booking Log';
        $empty_message = 'No data found.';
        return view('admin.plan.bookinglog', compact('pageTitle', 'empty_message', 'plan_logs'));
    }
}
