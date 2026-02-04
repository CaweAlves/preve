<?php

declare(strict_types=1);

use App\Models\User;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should be able to render Recurring Transactions screen', function () {
    $response = $this->get(route('recurring.index'));
    $response->assertOk();
});
