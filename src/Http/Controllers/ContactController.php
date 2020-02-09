<?php

namespace Successive\Keka\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    
  public function index(){
    //   die('in here');
    return View::make('contact');
  }
}
