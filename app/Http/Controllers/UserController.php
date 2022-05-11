<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\GeneralSetting;
use App\Models\Rating;
use App\Models\Plan;
use App\Models\PlanLog;
use App\Models\Seminar;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    
    public function home()
    {
        $pageTitle = 'Dashboard';
        $total_tours = PlanLog::where('status',1)->where('type','tour')->where('user_id', auth()->id())->count();
        $upcoming_tours = PlanLog::where('status',1)->where('type','tour')->where('user_id', auth()->id())->whereHas('plan', function($q){
            $q->where('departure_time', '>', now());
        })->count();
        $total_seminars = PlanLog::where('status',1)->where('type','seminar')->where('user_id', auth()->id())->count();
        $upcoming_seminars = PlanLog::where('status',1)->where('type','seminar')->where('user_id', auth()->id())->whereHas('seminar', function($q){
            $q->where('start_time', '>', now());
        })->count();
        
        $payment_history = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->take(10)->get();
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'total_tours', 'upcoming_tours', 'total_seminars', 'upcoming_seminars', 'payment_history'));
    }

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);
        
        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);
        

        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Payment History
     */
    public function depositHistory()
    {
        $pageTitle = 'Patment History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function rating(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|in:tour,seminar',
            'rating' => 'required|integer|min:1|in:1,2,3,4,5',
            'comment' => 'nullable|string'
        ]);

        if ($request->type == 'tour') {
            $tour = Plan::active()->where('id', $id)->first();
            if (!$tour) {
                $notify[] = ['error', 'Invalid tour plan'];
                return back()->withNotify($notify);
            }
        }else{
            $seminar = Seminar::active()->where('id', $id)->first();
            if (!$seminar) {
                $notify[] = ['error', 'Invalid seminar'];
                return back()->withNotify($notify);
            }
        }

        $exist = Rating::where('user_id', auth()->id())->where('type', $request->type)->where('plan_id', $id)->exists();
        if ($exist) {
            $notify[] = ['error', 'Already exist your rating!'];
            return back()->withNotify($notify);
        }

        $rating = new Rating();
        $rating->user_id = auth()->id();
        $rating->plan_id = $id;
        $rating->type = $request->type;
        $rating->rating = $request->rating;
        $rating->comment = $request->comment;
        $rating->save();

        $notify[] = ['success', 'Thanks for your rating!'];
        return back()->withNotify($notify);
    }

    //Tour log
    public function tourLog()
    {
        $tour_logs = PlanLog::where('status',1)->where('type','tour')->where('user_id', auth()->id())->with('plan')->latest()->paginate(getPaginate());

        $pageTitle = 'Tour Booking Log';
        return view($this->activeTemplate.'user.log.tourLog', compact('pageTitle', 'tour_logs'));
    }

    //Seminar log
    public function seminarLog()
    {
        $seminar_logs = PlanLog::where('status',1)->where('type','seminar')->where('user_id', auth()->id())->with('seminar')->latest()->paginate(getPaginate());

        $pageTitle = 'Seminar Booking Log';
        return view($this->activeTemplate.'user.log.seminarLog', compact('pageTitle', 'seminar_logs'));
    }


    public function booking(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:tour,seminar',
            'seat' => 'required|integer|min:1',
            'plan_id' => 'required|integer|gt:0'
        ]);
        
        $log = new PlanLog();
        if ($request->type == 'tour') {
            $package = Plan::find($request->plan_id);
        } else {
            $package = Seminar::find($request->plan_id);
        }

        if(!$package){
            $notify[] = ['error', 'Plan doesn\'t exist'];
            return back()->withNotify($notify);
        }

        $available_seat = ($package->capacity - $package->sold);
        if($available_seat < $request->seat){
            $notify[] = ['error', "Only $available_seat seats available!"];
            return back()->withNotify($notify);
        }

        $log->user_id = auth()->user()->id;
        $log->plan_id = $package->id;
        $log->seat = $request->seat;
        $log->price = getAmount($package->price * $request->seat);
        $log->trx = getTrx();
        $log->status = 0;
        $log->type = $request->type;
        $log->save();
        session()->put('log_id',$log->id);
        return redirect()->route('user.deposit');

    }
}
