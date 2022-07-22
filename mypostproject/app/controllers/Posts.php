<?php

class Posts extends Controller{

    public function __construct(){
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index(){

        // Get Posts
        
        $posts = $this->postModel->getPosts();
        $data = [
            'title' => 'Post',
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    public function add(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],

                'title_err' => '',
                'body_err' => ''
            ];

            // Validate title
            if(empty($data['title'])){
               $data['title_err'] = 'Create a title for your post';
            }

            // Validate body
            if(empty($data['body'])){
                $data['body_err'] = 'Write in your post';
            }


            // Make sure errors are empty
            if(empty($data['title_err']) && empty($data['body_err'])){
                // validate
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post Added');
                    redirect('posts');
                }else {
                    die('Something went wrong');
                }
            }else {
                $this->view('posts/add', $data);
            }


        }else {
            // Load view
            $data = [
                'title' => '',
                'body' => ''
            ];

            $this->view('posts/add', $data);
        }
    }


    public function edit($id){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],

                'title_err' => '',
                'body_err' => ''
            ];

            // Validate title
            if(empty($data['title'])){
               $data['title_err'] = 'Create a title for your post';
            }

            // Validate body
            if(empty($data['body'])){
                $data['body_err'] = 'Write in your post';
            }


            // Make sure errors are empty
            if(empty($data['title_err']) && empty($data['body_err'])){
                // validate
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post Updated');
                    redirect('posts');
                }else {
                    die('Something went wrong');
                }
            }else {
                $this->view('posts/edit', $data);
            }


        }else {
            
            // Get existing post from model

            $post = $this->postModel->getPostByTitle($id);

            // Check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];

            $this->view('posts/edit', $data);
        }
    }


    public function show($id){

        $post = $this->postModel->getPostByTitle($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'headLine' => 'Read Content',
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }

    public function delete($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = $this->postModel->getPostByTitle($id);

            // Check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }
            
            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('posts');
            }else {
                die('Something went wrong');
            }
        }else {
            redirect('posts');
        }
    }
}