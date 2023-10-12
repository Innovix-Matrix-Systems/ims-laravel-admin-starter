<?php

use App\Filament\Resources\UserResource;
use App\Models\User;

$adminUser;

beforeAll(function () {
    // Executes first, before any of tests are run
    // Eg. can be used to set up a testing database
});

beforeEach(function () {
    $this->adminUser = User::factory()->create();
    $this->adminUser->assignRole('Admin');
    $this->adminUser->is_active = 1;
    $this->adminUser->save();
});

test('authenticated normal user can not access the admin dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/admin')
        ->assertStatus(403);
});

test('authenticated admin user can access the admin dashboard', function () {

    $this->actingAs($this->adminUser)->get('/admin')
        ->assertStatus(200);
});

//User Resource Test

test('authenticated admin can render User Page, View All, view single', function () {

    $this->actingAs($this->adminUser);

    $this->get(UserResource::getUrl('index'))->assertSuccessful();
    $this->get(UserResource::getUrl('view', [
        'record' => User::factory()->create(),
    ]))->assertSuccessful();

});

test('authenticated admin can render User Page and Update User', function () {

    $this->actingAs($this->adminUser);
    $this->get(UserResource::getUrl('edit', [
        'record' => User::factory()->create(),
    ]))->assertSuccessful();
});

test('authenticated admin can not create a user', function () {

    $this->actingAs($this->adminUser);
    $this->get(UserResource::getUrl('create'))->assertStatus(403);
});
