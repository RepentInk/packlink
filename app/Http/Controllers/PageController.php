<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /***
     * ----------------------------------------------
     * Pages function
     * ----------------------------------------------
     */

     public function indexPage(){
         return view('pages.index');
     }
}
