<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function ratings()
    {
        $ratings = Rating::latest()->paginate(getPaginate());
        $pageTitle = 'All Ratings';
        $empty_message = 'No data found.';
        return view('admin.ratings', compact('pageTitle', 'empty_message', 'ratings'));
    }

    public function delete($id)
    {
        Rating::destroy($id);
        $notify[] = ['success', 'Deleted Successfully!'];
        return back()->withNotify($notify);
    }
}
