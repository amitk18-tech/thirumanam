<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $isLoggedIn = Session::has('api_token');
        $members = [];

        if ($isLoggedIn) {
            $response = $this->api->getHomePageData();
            $members = $response['data'] ?? [];
        }

        $showcaseMembers = [
            ['id'=>0,'name'=>'Ananya Krishnamurthy','age'=>26,'education'=>'B.Tech (IT)','occupation'=>'Software Engineer','profile_marital_status'=>'Never Married','gender'=>'female','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/f1.jpg'],
            ['id'=>0,'name'=>'Karthikeyan Subramaniam','age'=>29,'education'=>'MBA','occupation'=>'Business Analyst','profile_marital_status'=>'Never Married','gender'=>'male','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/m1.jpg'],
            ['id'=>0,'name'=>'Deepa Venkataraman','age'=>24,'education'=>'M.Sc Nursing','occupation'=>'Nurse','profile_marital_status'=>'Never Married','gender'=>'female','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/f2.jpg'],
            ['id'=>0,'name'=>'Selvakumar Murugesan','age'=>31,'education'=>'B.E Civil','occupation'=>'Civil Engineer','profile_marital_status'=>'Never Married','gender'=>'male','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/m2.jpg'],
            ['id'=>0,'name'=>'Priya Sundaram','age'=>27,'education'=>'B.Com CA','occupation'=>'Chartered Accountant','profile_marital_status'=>'Never Married','gender'=>'female','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/f3.jpg'],
            ['id'=>0,'name'=>'Vijayakumar Pillai','age'=>33,'education'=>'M.Tech','occupation'=>'Senior Developer','profile_marital_status'=>'Never Married','gender'=>'male','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/m3.jpg'],
            ['id'=>0,'name'=>'Meenakshi Rajendran','age'=>25,'education'=>'B.Sc Nutrition','occupation'=>'Dietitian','profile_marital_status'=>'Never Married','gender'=>'female','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/f4.jpg'],
            ['id'=>0,'name'=>'Arun Balakrishnan','age'=>28,'education'=>'BBA','occupation'=>'Marketing Manager','profile_marital_status'=>'Never Married','gender'=>'male','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/m4.jpg'],
            ['id'=>0,'name'=>'Kavitha Narayanan','age'=>30,'education'=>'M.A Tamil','occupation'=>'School Teacher','profile_marital_status'=>'Never Married','gender'=>'female','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/f5.jpg'],
            ['id'=>0,'name'=>'Murugan Annamalai','age'=>34,'education'=>'Diploma Mech','occupation'=>'Factory Supervisor','profile_marital_status'=>'Never Married','gender'=>'male','profile_photo'=>'https://beta.thirumanam.info/storage/showcase/m5.jpg'],
        ];

        return view('home', compact('members', 'isLoggedIn', 'showcaseMembers'));
    }
}
