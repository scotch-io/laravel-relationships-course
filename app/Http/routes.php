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