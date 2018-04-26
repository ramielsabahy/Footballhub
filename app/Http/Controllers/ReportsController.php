<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\feed_report;
use App\Report;
use App\Feed;

class ReportsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth', ['except' => ['reportFeed', 'getReports', 'createReport', 'editReport', 'destroyReport', 'getReportFeeds', 'getFeedReports', 'getReportsDataTable']]);
    }

    // Players and Referees only
    // Reporting a feed
    public function reportFeed(Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the user is not a player or a referee return unauthorized
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
            })->where('id', '=', $requestUser->id)->get()->count() &&
            !\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Referees');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Only players and referees can report a feed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if (count(feed_report::where('feed_id', '=', request()->feed_id)->where('user_id', '=', $requestUser->id)->get()))
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "User already reported this feed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try
        {
            $feed = Feed::findOrFail(request()->feed_id);
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Feed Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try
        {
            $report = Report::findOrFail(request()->report_id);
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Report Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $feed_report = new feed_report;
        $feed_report->user_id = $requestUser->id;
        $feed_report->feed_id = request()->feed_id;
        $feed_report->report_id = request()->report_id;

        try
        {
            $feed_report->save();
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Report delivered successfully, thanks";
            $resp->Status = true;
            $resp->InnerData = $feed_report;
            return response()->json($resp, 200);
        }
        catch (\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Can't deliver the report";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Admins only
    // Destroying a feed report
    // CMS Method
    public function destroyFeedReport(Request $request)
    {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try {
            $feed_report = feed_report::findOrFail(request()->feed_report_id);
            try {
                $feed_report->delete();

                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Feed report deleted successfully";
                $resp->Status = true;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
            catch(\Exception $e)
            {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = $e->getMessage();
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Feed Report Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // All authorized users
    // Get the list of reports
    public function getReports()
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        if (!$token)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthoirzed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $reports = Report::all();
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $reports;
        return response()->json($resp, 200);
    }

    // All users
    // Get the list of reports for DataTable
    public function getReportsDataTable(Request $request)
    {
        $reports = Report::all();
        return response()->json($reports, 200);
    }

    // Admins only
    // Creating a report
    // CMS Method
    public function createReport(Request $request)
    {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $report = new Report;
        $report->type = request()->type;
        $report->description = request()->description;
        try {
            $report->save();
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Report Created Successfully";
            $resp->Status = true;
            $resp->InnerData = $report;
            return response()->json($resp, 200);
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Admins only
    // Editing a report
    // CMS Method
    public function editReport(Request $request)
    {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try {
            $report = Report::findOrFail(request()->report_id);
            $report->type = empty(request()->type) ? $report->type : request()->type;
            $report->description = empty(request()->description) ? $report->description : request()->description;

            try {
                $report->save();
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Report edited successfully";
                $resp->Status = true;
                $resp->InnerData = $report;
                return response()->json($resp, 200);
            }
            catch(\Exception $e)
            {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = $e->getMessage();
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Report Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Admins only
    // Destroying a report
    // CMS Method
    public function destroyReport(Request $request)
    {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try {
            $report = Report::findOrFail(request()->report_id);
            try {
                $report->delete();

                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Report deleted successfully";
                $resp->Status = true;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
            catch(\Exception $e)
            {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = $e->getMessage();
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Report Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Admins only
    // get report feeds
    // CMS Method
    public function getReportFeeds(Request $request)
    {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try
        {
            $report = Report::findOrFail(request()->report_id);
            $report->load('feed_reports');
            $report->feed_reports->load('user');
            $report->feed_reports->load('feed');
            $report->feed_reports->load('report');
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Retreived Successfully";
            $resp->Status = true;
            $resp->InnerData = $report;
            return response()->json($resp, 200);
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Report Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Admins only
    // get feed reports
    // CMS Method
    public function getFeedReports(Request $request)
    {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try
        {
            $feed = Feed::findOrFail(request()->feed_id);
            $feed->load('feed_reports');
            $feed->feed_reports->load('user');
            $feed->feed_reports->load('feed');
            $feed->feed_reports->load('report');

            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Retreived Successfully";
            $resp->Status = true;
            $resp->InnerData = $feed;
            return response()->json($resp, 200);
        }
        catch(\Exception $e)
        {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Feed Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Admins only
    // CMS Method
    public function indexReportsView()
    {
        return view('reports.index');
    }

    // Admins only
    // CMS Method
    public function createReportView()
    {
        return view('reports.create');
    }

    // Admins only
    // CMS Method
    public function editReportView($report_id)
    {
        try
        {
            $report = Report::findOrFail($report_id);
            return view('reports.edit')->with('report', $report);
        }
        catch(\Exception $e)
        {
            return redirect()->route('indexReportsView', ['error' => 'Report Not Found']);
        }
    }

    // Admins only
    // CMS Method
    public function IndexFeedReportsView($feed_id)
    {
        try
        {
            $feed = Feed::findOrFail($feed_id);
            return view('reports.feedReports')->with('feed', $feed);
        }
        catch(\Exception $e)
        {
            return redirect()->route('indexGeneralFeeds', array('error' => 'Feed Not Found'));
        }
    }

    // Admins only
    // CMS Method
    public function IndexReportFeedsView($report_id)
    {
        try
        {
            $report = Report::findOrFail($report_id);
            return view('reports.reportFeeds')->with('report', $report);
        }
        catch(\Exception $e)
        {
            return redirect()->route('indexReportsView', array('error' => 'Report Not Found'));
        }
    }

    // Admins only
    // CMS Method
    public function IndexReportFeedsView2()
    {
        try
        {
            $report = Report::where('id',2)->get();
            $report->load('feed_reports');
            return view('reports.reportsFeeds')->with('report', $report);
        }
        catch(\Exception $e)
        {
            return redirect()->route('indexReportsView', array('error' => 'Report Not Found'));
        }
    }
}
