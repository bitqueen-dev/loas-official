<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Mail\Reminder;
use Illuminate\Support\Facades\Mail;

class FuncController extends Controller{

	public function __construct(){}

	public function poster(Request $request){
		$input = $request->all();
		$attPath = false;

		if(isset($input['imageUpload']) && $input['imageUpload']){
			$validator = Validator::make($input, [
				'imageUpload' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048'
			]);

			if(isset($validator) && ($validator->fails())) {
				return back()->withErrors(['imgUpload']);
			}

			$imageTmpName = time() . '.' . $request->imageUpload->getClientOriginalExtension();
			$request->imageUpload->move("/tmp", $imageTmpName);
			$attPath = "/tmp/" . $imageTmpName;
		}

		unset($input['imageUpload']);
		unset($input['_token']);

		try {
			Mail::to(config('gameInfo.serviceMail'))->send(new Reminder($input, $attPath));

			return back()->with('status', 'succ');
		} catch (Exception $e) {
			return back()->withErrors(['unknow']);
		}
	}
}