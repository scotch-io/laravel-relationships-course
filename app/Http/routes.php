<?php

Route::get('/', function() {
    // create a new user
    $user = factory(App\User::class)->create();

    // create a new address
    $address = new App\Address([
        'country' => 'USA',
        'zip'     => '10000'
    ]);

    // link the two
    $user->address()->save($address);

    // dump
    $user->load('address');
    dd($user);
});

// has many relationship
Route::get('has-many', function() {
    // create a user
    $user = factory(App\User::class)->create();

    // create multiple posts
    $posts = factory(App\Post::class, 5)->create();

    // link them together
    $user->posts()->saveMany($posts);

    // dump
    $user->load('posts');
    dd($user);
});

Route::get('has-many-tips', function() {
    // create a user
    $user = factory(App\User::class)->create();

    // create multiple posts
    $post = factory(App\Post::class)->create();

    $post->author()->associate($user);
    $post->save();

    // dump information
    dd($post->author->id, $post->author->name, $post->author->email);
});

Route::get('user/{id}', function($id) {
    $user  = App\User::with('posts')->find($id);
    $posts = $user->posts;

    return view('profile', compact('user', 'posts'));
});

Route::get('roles', function() {
    $role = App\Role::whereName('admin')->with('users')->first();
    dd($role->users);

    $user = App\User::offset(1)->first();
    $role = App\Role::whereName('admin')->first();

    // assign a role to a user
    $user->roles()->detach($role->id);

    $user->load('roles');
    dd($user->roles);
});

Route::get('sync', function() {
    $roleAdmin  = App\Role::whereName('admin')->first();
    $roleEditor = App\Role::whereName('editor')->first();

    $user = App\User::first();

    // attach
    // $user->roles()->attach($roleAdmin->id);

    // detach
    // $user->roles()->detach($roleAdmin->id);

    // get all roles
    // check which roles already exist
    // check which roles dont exist

    // sync
    $user->roles()->sync([$roleEditor->id]);

    foreach ($user->roles as $role) {
        print_r($role->name . '<br>');
    }

    dd('done!');
});