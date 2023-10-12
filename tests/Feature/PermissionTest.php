<?php

use App\Filament\Resources\PermissionResource;
use App\Models\User;

$superAdminUser;
$adminUser;

beforeEach(function () {
    $this->superAdminUser = User::factory()->create();
    $this->superAdminUser->assignRole('Super-Admin');
    $this->superAdminUser->is_active = 1;
    $this->superAdminUser->save();

    $this->adminUser = User::factory()->create();
    $this->adminUser->assignRole('Admin');
    $this->adminUser->is_active = 1;
    $this->adminUser->save();
});

test('authenticated admin can not render any permission page', function () {

    $this->actingAs($this->adminUser);

    $this->get(PermissionResource::getUrl('index'))->assertStatus(403);
    $this->get(PermissionResource::getUrl('create'))->assertStatus(403);

});

test('super-admin without id 1 can not render any permission page', function () {

    $this->actingAs($this->superAdminUser);

    $this->get(PermissionResource::getUrl('index'))->assertStatus(403);
    $this->get(PermissionResource::getUrl('create'))->assertStatus(403);

});
