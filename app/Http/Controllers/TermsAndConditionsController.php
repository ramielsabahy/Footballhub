<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TermsAndCondition;

class TermsAndConditionsController extends Controller
{
    public function __construct() {
        return $this->middleware('auth', ['except' => ['returnTermsAndConditions', 'setTermsAndConditions']]);
    }

    public function create()
    {
    	return view('termsAndConditions.create');
    }

    public function update()
    {
    	$termsAndConditions = TermsAndCondition::find(1);
    	return view('termsAndConditions.update')->with('termsAndConditions', $termsAndConditions->termsandconditions);
    }

    public function show()
    {
    	try {
    		$termsandconditions = TermsAndCondition::findOrFail(1);
    		return view('termsAndConditions.show')->with('termsAndConditions', $termsandconditions->termsandconditions)->with('exists', true);
    	}
    	catch (\Exception $e) {
    		return view('termsAndConditions.show')->with('exists', false);    		
    	}
    }

    public function setTermsAndConditions(Request $request)
    {
    	try {
    		$termsAndConditions = TermsAndCondition::findOrFail(1);
    		$termsAndConditions->termsandconditions = empty(request()->termsandconditions) ? $termsAndConditions->termsandconditions : request()->termsandconditions;
            try {
                $termsAndConditions->save();
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Terms and Conditions Updated Successfully";
                $resp->Status = true;
                $resp->InnerData = $termsAndConditions;
                return response()->json($resp, 200);
            }
            catch(\Exception $e) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = $e->getMessage();
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
    	}
    	catch(\Exception $e) {
    		$termsAndConditions = new TermsAndCondition;
    		$termsAndConditions->termsandconditions = request()->termsandconditions;
    		try {
    			$termsAndConditions->save();
		        $resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "Terms and Conditions Created Successfully";
		        $resp->Status = true;
		        $resp->InnerData = $termsAndConditions;
		        return response()->json($resp, 200);
    		}
    		catch(\Exception $e) {
		        $resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = $e->getMessage();
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
    		}
    	}
    }

    public function returnTermsAndConditions(Request $request)
    {
    	$termsAndConditions = TermsAndCondition::find(1);

    	if (TermsAndCondition::all()->count()) {
	        $resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = 'Retreived Successfully';
	        $resp->Status = true;
	        $resp->InnerData = $termsAndConditions->termsandconditions;
	        return response()->json($resp, 200);
    	}
    	else {
	        $resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = 'Terms and Conditions Are Not Set Yet';
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
    	}
    }
}
