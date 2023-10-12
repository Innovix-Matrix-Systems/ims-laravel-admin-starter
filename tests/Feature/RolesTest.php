<?php

use App\Filament\Resources\RoleResource;
use App\Models\User;

$adminUser;

beforeEach(function () {
    $this->adminUser = User::factory()->create();
    $this->adminUser->assignRole('Admin');
    $this->adminUser->is_active = 1;
    $this->adminUser->save();
});

test('authenticated admin can render Role Page, View All', function () {

    $this->actingAs($this->adminUser);

    $this->get(RoleResource::getUrl('index'))->assertSuccessful();

});

test('authenticated admin can not render other role pages', function () {

    $this->actingAs($this->adminUser);

    $this->get(RoleResource::getUrl('create'))->assertStatus(403);

});
