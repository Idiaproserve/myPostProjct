<?php

class Pages extends Controller {

  public function __construct(){

  }

  public function index(){

    if (isLoggedIn()) {
      redirect('posts');
    }

    $data = [
      'title' => 'Welcome',
      'description' => 'Simple social network built on the Idiamvc PHP framework'
    ];

    $this->view('pages/index', $data);
  }

  public function about(){
    $data = [
      'title' => 'Welcome About us page',
      'description' => 'App to share posts with other users'
    ];
    //echo '<br>this is a page about method';
    $this->view('pages/about', $data);
  }

}