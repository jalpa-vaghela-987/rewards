<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelloTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //pied piper key: y5guxzE8NNOTihkFN6cir182VaDfSV8llTQY7oZ6
    //PS key: O3dl4HGUxIcds6HVYE42KlVomBdUUjUR9vbZVIQv

    public $example_post = '
        {
                "id" : 55555555555555,
                "username" : "collin.peterson@helloteam.com",
                "firstName" : "Collin",
                "lastName" : "Peterson",
                "email" : "Collin.peterson@helloteam.com",
                "residenceCountry" : "US",
                "pointsAvailable" : 1800.0,
                "locked" : false
                "groups":[
                                {
                                        "group_name":"Dundermifflin",
                                        "group_admin":0,
                                        "subgroups" :
                                        [
                                             "Dundermifflin_Engineering",
                                             "Dundermifflin_Paris",
                                             "Dundermifflin_Europe",
                                        ]
                               }
        ]
        }

        ';

    public $proposed_post = '{
   "id":55555555555555,
   "username":"collin.peterson@helloteam.com",
   "firstName":"Collin",
   "lastName":"Peterson",
   "email":"Collin.peterson@helloteam.com",
   "residenceCountry":"US",
   "pointsAvailable":1800.0,
   "locked":false,
   "groups":[
      {
         "group_name":"Dundermifflin",
         "group_id":44444444444,
         "group_admin":0,
         "subgroups":[
            {
               "sub_group_name":"Dundermifflin Engineering",
               "sub_group_id":22222222222,
            },
            {
               "sub_group_name":"Dundermifflin Paris",
               "sub_group_id":33333333333,
            },
            {
               "sub_group_name":"Dundermifflin Europe",
               "sub_group_id":4444444444,
            }
         ]
      }
   ]
}
';

    public function index() // default api/helloteam get call here
    {
        return 'index';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->user();
        //return $request;
        $data = $request;
        //$data = json_decode($this->proposed_post); // when coming from external no need to decode

        return $data->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
