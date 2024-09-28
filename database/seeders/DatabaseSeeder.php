<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\Shop\Brand;
use App\Models\Shop\Category as ShopCategory;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\Blog\Author;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Post;
use App\Models\Blog\Link;
use App\Models\Comment;
use Closure;
use Filament\Actions\Action;
use Filament\Notifications\Collection;
use Filament\Notifications\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    const IMAGE_URL = 'https://picsum.photos/200';
    
    public function run(): void
    {
        // Clear Images
        Storage::deleteDirectory('public');

        // User Seeder
        $this->call(UsersTableSeeder::class);

        // Shop Brands
        $this->command->warn(PHP_EOL . 'Creating shop brands...');
        $brands = $this->withProgressBar(20, fn () => Brand::factory()->count(20)
           ->create());
       $this->command->info('Shop brands created.');

        // Shop Category

        $this->command->warn(PHP_EOL . 'Creating shop categories...');
        $categories = $this->withProgressBar(20, fn () => ShopCategory::factory(1)
           ->create());
        $this->command->info('Shop categories created.');

        // Shop Customers

        $this->command->warn(PHP_EOL . 'Creating shop customers...');
        $customers = $this->withProgressBar(1000, fn () => Customer::factory(1)
            ->create());
        $this->command->info('Shop customers created.');

        // Shop Products

        $this->command->warn(PHP_EOL . 'Creating shop products...');
        $products = $this->withProgressBar(50, fn () => Product::factory(1)
            ->sequence(fn ($sequence) => ['shop_brand_id' => $brands->random(1)->first()->id])
            ->hasAttached($categories->random(rand(3, 6)), ['created_at' => now(), 'updated_at' => now()])
            ->create());
        $this->command->info('Shop products created.');

        // Shop Orders

        $this->command->warn(PHP_EOL . 'Creating orders...');
        $orders = $this->withProgressBar(1000, fn () => Order::factory(1)
            ->sequence(fn ($sequence) => ['purchase_customer_id' => $customers->random(1)->first()->id])
            ->has(Payment::factory()->count(rand(1, 3)))
            ->has(
                OrderItem::factory()->count(rand(2, 5))
                    ->state(fn (array $attributes, Order $order) => ['shop_product_id' => $products->random(1)->first()->id]),
                'items'
            )
            ->create());
                
            foreach ($orders->random(rand(5, 8)) as $order) {
                Notification::make()
                    ->title('New order')
                    ->icon('heroicon-o-shopping-bag')
                    ->body("{$order->customer->name} ordered {$order->items->count()} products.")
                    ->actions([
                        Action::make('View')
                            ->url(OrderResource::getUrl('edit', ['record' => $order])),
                    ]);
            }
            $this->command->info('Shop orders created.');

            // Blog

            $this->command->warn(PHP_EOL . 'Creating blog categories...');
            $blogCategories = $this->withProgressBar(20, fn () => BlogCategory::factory(1)
                ->count(20)
                ->create());
            $this->command->info('Blog categories created.');
            
            $this->command->warn(PHP_EOL . 'Creating blog authors and posts...');
            $this->withProgressBar(20, fn () => Author::factory(1)
                ->has(
                    Post::factory()->count(5)
                        ->has(
                            Comment::factory()->count(rand(5, 10))
                                ->state(fn (array $attributes, Post $post) => ['customer_id' => $customers->random(1)->first()->id]),
                        )
                        ->state(fn (array $attributes, Author $author) => ['blog_category_id' => $blogCategories->random(1)->first()->id]),
                    'posts'
                )
                ->create());
            $this->command->info('Blog authors and posts created.');

            $this->command->warn(PHP_EOL . 'Creating blog links...');
            $this->withProgressBar(20, fn () => Link::factory(1)
                ->count(20)
                ->create());
            $this->command->info('Blog links created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
    
}
