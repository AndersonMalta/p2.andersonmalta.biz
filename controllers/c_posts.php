<?php

class posts_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            Router::redirect('/users/login');
        }
    }

    public function index() {

        # Set up the View
        $this->template->content = View::instance('v_posts_index');
        $this->template->title   = "All Posts";

        # Build the query
        $q = "SELECT
              posts.* ,
              users.first_name,
              users.last_name,
              users.avatar
            FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            ORDER BY modified DESC";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;

    } # End of Method

    public function following() {

        # Set up the View
        $this->template->content = View::instance('v_posts_index');
        $this->template->title   = "Friends' Posts";

        # Build the query to only choose those posts from users that you're following
        $q = "SELECT
              posts.* ,
              users.first_name,
              users.last_name,
              users.avatar
            FROM posts
            INNER JOIN users ON posts.user_id = users.user_id
            INNER JOIN users_users ON posts.user_id = users_users.user_id_followed
            WHERE users_users.user_id = ".$this->user->user_id."
             ORDER BY created DESC";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;

    } # End of Method

    public function add($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = $this->user->first_name." - New Post";

        #Pass in any error information
        $this->template->content->error = $error;

        # Render template
        echo $this->template;

    } # End of Method

    public function p_add() {

        # convert new lines to line breaks
        $_POST['content']=nl2br($_POST['content']);

        # Have user try again if their post content was empty.
        if (strlen($_POST['content'])<1) {
            Router::redirect('/posts/add/error');
        }

        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('posts', $_POST);

        # Send user to their list of personal posts
        Router::redirect('/users/profile');

    } # End of Method

    public function edit_post($post_id = NULL) {

        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = $this->user->first_name." - Edit Post";

        # Find the original post
        $q = "SELECT posts.content
                FROM posts
                WHERE post_id = ".$post_id;

        # Select original post from the database
        $post = DB::instance(DB_NAME)->select_field($q);

        #Pass the post content to the view
        $this->template->content->post = $post;

        #Pass in post_id information
        $this->template->content->post_id = $post_id;

        # Render template
        echo $this->template;

    } # End of Method

    public function p_edit($post_id = NULL) {

        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp to update when the field was modified
        $_POST['modified'] = Time::now();

        # Generation the where condition, where the post_id matches
        $where_condition = "WHERE posts.post_id = ".$post_id;

        # Edit the entry in the database
        DB::instance(DB_NAME)->update_row('posts', $_POST, $where_condition);

        # Send user to their list of personal posts
        Router::redirect('/users/profile');

    } # End of Method

    public function personal() {

        ## Display only posts that match the current user

        # Set up the View
        $this->template->content = View::instance('v_posts_index');
        $this->template->title   = $this->user->first_name." ".$this->user->last_name;

        # Build the query
        $q = "SELECT posts.*
                FROM posts
                WHERE user_id = ".$this->user->user_id.
                " ORDER BY created DESC";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;

    } # End of Method



    public function delete_post($post_id = NULL){

        # Configure where condition so that post_id is matched
        $where_condition = "WHERE posts.post_id = ".$post_id;

        # Delete desired entry from the posts table
        DB::instance(DB_NAME)->delete('posts', $where_condition);

        # Reroute user back to his profile page

        Router::redirect('/users/profile');
    } # End of Method

    public function users(){

        ## Display a list of users who we can follow and unfollow

        # Set up the View
        $this->template->content = View::instance("v_posts_users");
        $this->template->title   = "All ".APP_NAME." Users";

        # Generate query of all users
        $q = "SELECT *
                FROM users";

        # Query the database
        $users = DB::instance(DB_NAME)->select_rows($q);

        # Generate query of all the relationships
        # ... where the current user is the follower
        $q = "SELECT *
            FROM users_users
            WHERE user_id = ".$this->user->user_id;

        # Establish the "connections" variable, indexed to user_id_followed
        $connections = DB::instance(DB_NAME)->select_array($q,'user_id_followed');

        # Pass users and relationships to the views
        $this->template->content->users         = $users;
        $this->template->content->connections   = $connections;

        # Render the view
        echo $this->template;

    } # End of Method

    public function follow($user_id_followed) {

        # with the user_id_followed information given, set the users_users
        # table to indicate that $this->user is following user_id_followed

        # Set up the information that will be inserted to users_users table

        $data = Array(
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $user_id_followed
        );

        # Insert into the users_users table
        DB::instance(DB_NAME)->insert('users_users', $data);

        # Redirect the user back to users page:
        Router::redirect('/posts/users');

    } # End of Method

    public function unfollow($user_id_followed) {

        # When this function is called, delete the entry in users_users
        # that pairs $this->user with $user_id_followed

        # Set up the database query
        $where_condition = "WHERE user_id = ". $this->user->user_id.
            " AND user_id_followed = ". $user_id_followed;

        # Delete from the users_users table
        DB::instance(DB_NAME)->delete('users_users', $where_condition);

        # Redirect the user back to users page:
        Router::redirect('/posts/users');

    } # End of Method

} # End of Class