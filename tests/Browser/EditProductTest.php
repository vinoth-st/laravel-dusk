<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditProductTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAddProduct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create') // Adjust the URL to your product creation route
                    ->type('name', 'New Product')
                    ->type('description', 'Description of the new product.')
                    ->type('price', '19.99')
                    ->press('Submit') // Adjust if your button has a different text
                    ->assertPathIs('/products') // Adjust to the path where products are listed
                    ->assertSee('Product created successfully.') // Check for success message
                    ->assertSee('New Product') // Verify that the new product is listed
                    ->assertInputValue('name', 'New Product')
                    ->assertInputValue('description', 'Description of the new product.')
                    ->assertInputValue('price', '19.99');
        });
    }

    public function testAddProductValidationErrors()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create')
                    ->type('name', '') // Leave name empty to trigger validation
                    ->type('description', 'Valid description')
                    ->type('price', '') // Leave price empty to trigger validation
                    ->press('Submit')
                    ->assertSee('The name field is required.') // Check for name validation error
                    ->assertSee('The price field is required.'); // Check for price validation error
        });
    }
    /**
     * Test editing a product.
     *
     * @return void
     */
    public function testEditProduct()
    {
        $product = Product::factory()->create(); // Create a product to edit

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id . '/edit')
                    ->type('name', 'Updated Product Name')
                    ->type('description', 'Updated Product Description')
                    ->type('price', '99.99')
                    ->press('Update')
                    ->assertSee('Product updated successfully.')
                    ->assertInputValue('name', 'Updated Product Name')
                    ->assertInputValue('description', 'Updated Product Description')
                    ->assertInputValue('price', '99.99');
        });
    }

    /**
     * Test validation errors on product edit page.
     *
     * @return void
     */
    public function testEditProductValidationErrors()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id . '/edit')
                    ->type('name', '') // Leave name empty to trigger validation
                    ->press('Update')
                    ->assertSee('The name field is required.');
        });
    }
}

