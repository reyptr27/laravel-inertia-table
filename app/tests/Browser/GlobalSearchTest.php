<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GlobalSearchTest extends DuskTestCase
{
    /** @test */
    public function it_can_globally_search()
    {
        $this->browse(function (Browser $browser) {
            User::first()->forceFill([
                'name'  => 'Reynaldo Putra',
                'email' => 'reynaldo.ptr27@gmail.com',
            ])->save();

            $users = User::query()
                ->select(['id', 'name', 'email'])
                ->orderBy('name')
                ->get();

            $browser->visit('/users/eloquent')
                ->waitFor('table')
                // First user
                ->assertSeeIn('tr:first-child td:nth-child(1)', $users->get(0)->name)
                ->assertDontSee('Reynaldo Putra')
                ->type('global', 'Reynaldo Putra')
                ->waitForText('reynaldo.ptr27@gmail.com')
                ->type('global', ' ')
                ->waitUntilMissingText('reynaldo.ptr27@gmail.com')
                ->type('global', 'reynaldo.ptr27@gmail.com')
                ->waitForText('Reynaldo Putra');
        });
    }
}
