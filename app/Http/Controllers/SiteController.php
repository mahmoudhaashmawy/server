<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Seminar;
use App\Models\Subscriber;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogs(){
        $blog_content = getContent('blog.content', true);
        $blog_elements = Frontend::where('data_keys', 'blog.element')->latest('id')->paginate(getPaginate());
        $pageTitle = 'Blogs';
        return view($this->activeTemplate.'blog',compact('blog_content','pageTitle', 'blog_elements'));
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $blog->increment('views');
        $recent_posts = Frontend::where('id', '!=', $id)->where('data_keys', 'blog.element')->latest('id')->take(4)->get();
        $pageTitle = 'Blog Details';
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'recent_posts'));
    }

    public function linkDetails($id,$slug){
        $link = Frontend::where('id',$id)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $link->data_values->title;
        return view($this->activeTemplate.'link_details',compact('link','pageTitle'));
    }


    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success' => 'Cookie accepted successfully']);
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    //Tour plan
    public function plans()
    {
        $pageTitle = 'Tour Plans';
        $ad_images = getContent('ad_image.content', true);
        $plans = Plan::active()->latest()->paginate(12);
        $categories = Category::active()->orderBy('name')->get();
        return view($this->activeTemplate.'plan.plans',compact('plans','pageTitle', 'ad_images', 'categories'));
    }

    public function planSearch(Request $request)
    {
        $location = $request->location1;
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::parse($request->from_date);
        }
        if ($request->to_date) {
            $to_date = Carbon::parse($request->to_date);
        }

        $pageTitle = 'Tour Plans';
        $ad_images = getContent('ad_image.content', true);
        $categories = Category::active()->orderBy('name')->get();


        $plans = Plan::active();

        if ($request->name) {
            $plans = $plans->where('name', 'like', "%$request->name%");
        }

        if ($from_date) {
            $plans = $plans->where('departure_time','>=',$from_date);
        }

        if ($to_date) {
            if (!$from_date) {
                $notify[] = ['error','Have to select to date first'];
                return back()->withNotify($notify);
            }
            if ($to_date < $from_date) {
                $notify[] = ['error','Must be grater than from date'];
                return back()->withNotify($notify);
            }
            $plans = $plans->where('departure_time','<=',$to_date);
        }

        if ($location) {
            $plans = $plans->orWhere('location', $location);
        }

        if ($request->category) {
            $plans = $plans->whereIn('category_id', $request->category);
        }

        if ($request->min_price) {
            $plans = $plans->where('price','>=',$request->min_price);
        }

        if ($request->max_price) {
            $plans = $plans->where('price','<=',$request->max_price);
        }


        $plans = $plans->latest()->paginate(12)->withQueryString();
        
        return view($this->activeTemplate.'plan.plans',compact('plans','pageTitle', 'ad_images', 'categories'));
    }

    public function planDetails($id, $slug)
    {
        $plan = Plan::active()->where('id', $id)->with('ratings')->withAvg('ratings', 'rating')->withCount('ratings')->firstOrFail();
        $pageTitle = $plan->name;
        $plan_breadcrumb = getContent('plan_breadcrumb.content', true);
        return view($this->activeTemplate.'plan.planDetails',compact('plan','pageTitle', 'plan_breadcrumb'));
    }

    //Seminar plan
    public function seminars()
    {
        $pageTitle = 'Seminar Plans';
        $ad_images = getContent('ad_image.content', true);
        $seminars = Seminar::active()->latest()->paginate(12);
        $categories = Category::active()->orderBy('name')->get();
        return view($this->activeTemplate.'seminar.seminars',compact('seminars','pageTitle', 'ad_images', 'categories'));
    }

    public function seminarSearch(Request $request)
    {
        $location = $request->location1;
        $from_date = null;
        $to_date = null;
        if ($request->from_date) {
            $from_date = Carbon::parse($request->from_date);
        }
        if ($request->to_date) {
            $to_date = Carbon::parse($request->to_date);
        }

        $pageTitle = 'Seminar Plans';
        $ad_images = getContent('ad_image.content', true);
        $categories = Category::active()->orderBy('name')->get();
        $seminars = Seminar::active();

        if ($from_date) {
            $seminars = $seminars->where('start_time','>=',$from_date);
        }

        if ($to_date) {
            if (!$from_date) {
                $notify[] = ['error','Have to select to date first'];
                return back()->withNotify($notify);
            }
            if ($to_date < $from_date) {
                $notify[] = ['error','Must be grater than from date'];
                return back()->withNotify($notify);
            }
            $seminars = $seminars->where('start_time','<=',$to_date);
        }

        if ($location) {
            $seminars = $seminars->orWhere('location', $location);
        }

        if ($request->category) {
            $seminars = $seminars->whereIn('category_id', $request->category);
        }

        if ($request->min_price) {
            $seminars = $seminars->where('price','>=',$request->min_price);
        }

        if ($request->max_price) {
            $seminars = $seminars->where('price','<=',$request->max_price);
        }

        if ($request->name) {
            $seminars = $seminars->where('name', 'like', "%$request->name%");
        }

        $seminars = $seminars->latest()->paginate(12)->withQueryString();
        return view($this->activeTemplate.'seminar.seminars',compact('seminars','pageTitle', 'ad_images', 'categories'));
    }

    public function seminarDetails($id, $slug)
    {
        $seminar = Seminar::active()->where('id', $id)->with('ratings')->withAvg('ratings', 'rating')->withCount('ratings')->firstOrFail();
        $pageTitle = $seminar->name;
        $seminar_breadcrumb = getContent('seminar_breadcrumb.content', true);
        return view($this->activeTemplate.'seminar.seminarDetails',compact('seminar','pageTitle', 'seminar_breadcrumb'));
    }
    
    public function subscribe()
    {
        $rules = [
            'email' => 'required|email|unique:subscribers,email'
        ];

        $validator = validator()->make(\request()->all(), $rules);
        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->getMessages()]);
        }

        $subscribe = new Subscriber();
        $subscribe->email = \request()->email;
        $subscribe->save();

        return response()->json(['success' => true,'message' => 'Thanks for subscribe!']);
    }
}
