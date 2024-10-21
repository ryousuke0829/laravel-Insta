<?php
//php artisan make:seeder CategorySeeder
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $category;
        public function __construct(Category $category) {
            $this->category = $category;
        }

    /**
     * Make sure that you don't have aney duplicate name of categories
     */
    public function run(): void
    {
        $categories=[
            [
                'name'=>'Machines',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'books',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Computer Programming',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ];
        $this->category->insert($categories);
    }
}
