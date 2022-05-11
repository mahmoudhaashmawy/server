<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PlanLog;
use App\Models\Seminar;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    public function index()
    {
        $seminars = Seminar::with('category')->latest()->paginate(getPaginate());
        $pageTitle = 'Seminars';
        $empty_message = 'No seminar has been added.';
        return view('admin.seminar.index', compact('pageTitle', 'empty_message', 'seminars'));
    }

    public function add()
    {
        $pageTitle = 'Add Seminar';
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.seminar.add', compact('pageTitle', 'categories'));
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
            'start_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:today',
            'end_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:start_time',
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

        $seminar = new Seminar();
        $seminar->name = $request->name;
        $seminar->category_id = $request->category_id;
        $seminar->location = $request->location;
        $seminar->map_latitude = $request->map_latitude;
        $seminar->map_longitude = $request->map_longitude;
        $seminar->duration = $request->duration;
        $seminar->start_time = Carbon::create($request->start_time);
        $seminar->end_time = Carbon::create($request->end_time);
        $seminar->capacity = $request->capacity;
        $seminar->price = $request->price;
        $seminar->details = $request->details;
        $seminar->included = $request->included;
        $seminar->excluded = $request->excluded;

        if($request->title){
            foreach ($request->title as $key => $item) {
                $seminar_plans[$item] = [
                    $request->title[$key],
                    $request->subtitle[$key],
                    $request->content[$key]
                ];
            }
        }
        $seminar->seminar_plan = @$seminar_plans ?? [];

        // Upload image
        foreach ($request->images as $image) {
            $path = imagePath()['seminars']['path'];
            $size = imagePath()['seminars']['size'];
            $images[] = uploadImage($image, $path, $size);
        }
        $seminar->images = $images;

        $seminar->save();

        $notify[] = ['success', 'Seminar Added Successfully!'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $seminar = Seminar::findOrFail($id);
        $pageTitle = 'Edit Seminar';
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.seminar.edit', compact('pageTitle', 'categories', 'seminar'));
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
            'start_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:today',
            'end_time' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:start_time',
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

        $seminar = Seminar::findOrFail($id);
        $seminar->name = $request->name;
        $seminar->category_id = $request->category_id;
        $seminar->location = $request->location;
        $seminar->map_latitude = $request->map_latitude;
        $seminar->map_longitude = $request->map_longitude;
        $seminar->duration = $request->duration;
        $seminar->start_time = Carbon::create($request->start_time);
        $seminar->end_time = Carbon::create($request->end_time);
        $seminar->capacity = $request->capacity;
        $seminar->price = $request->price;
        $seminar->details = $request->details;
        $seminar->included = $request->included;
        $seminar->excluded = $request->excluded;

        if($request->title){
            foreach ($request->title as $key => $item) {
                $seminar_plans[$item] = [
                    $request->title[$key],
                    $request->subtitle[$key],
                    $request->content[$key]
                ];
            }
        }
        $seminar->seminar_plan = @$seminar_plans ?? [];

        // Upload and Update image
        if ($request->images){
            foreach ($request->images as $image) {
                $path = imagePath()['seminars']['path'];
                $size = imagePath()['seminars']['size'];

                $images[] = uploadImage($image, $path, $size);
            }
            $seminar->images = array_merge((array)$seminar->images, $images);
        }

        $seminar->save();

        $notify[] = ['success', 'Seminar Updated Successfully!'];
        return back()->withNotify($notify);
    }

    public function deleteImage($id, $image)
    {
        $seminar = Seminar::findOrFail($id);

        $images = (array)$seminar->images;
        $path = imagePath()['seminars']['path'];
        if (($key = array_search($image, $images)) !== false) {
            removeFile($path.'/' . $image);
            unset($images[$key]);
        }
        $seminar->images = $images;
        $seminar->save();

        return response()->json(['success' => true, 'message' => 'Seminar image deleted!']);
    }

    public function status($id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->status = ($seminar->status ? 0 : 1);
        $seminar->save();

        $notify[] = ['success', ($seminar->status ? 'Activated!' : 'Deactivated!')];
        return back()->withNotify($notify);
    }

    //Booking Log
    public function bookingLog()
    {
        $seminar_logs = PlanLog::where('type','seminar')->where('status',1)->with(['seminar', 'user'])->latest()->paginate(getPaginate());
        $pageTitle = 'Seminar Booking Log';
        $empty_message = 'No data found.';
        return view('admin.seminar.bookingLog', compact('pageTitle', 'empty_message', 'seminar_logs'));
    }

    public function userBookingLog($id)
    {
        $seminar_logs = PlanLog::where('type','seminar')->where('status',1)->where('user_id', $id)->with(['seminar', 'user'])->latest()->paginate(getPaginate());
        $pageTitle = 'User Seminar Booking Log';
        $empty_message = 'No data found.';
        return view('admin.seminar.bookingLog', compact('pageTitle', 'empty_message', 'seminar_logs'));
    }
}
