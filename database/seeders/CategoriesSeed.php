<?php

namespace Database\Seeders;

use App\Models\CategoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CategoryModel::create([
            'name' => 'Technology'
        ]);
        CategoryModel::create([
            'name' => 'Science'
        ]);
        CategoryModel::create([
            'name' => 'Health'
        ]);
        CategoryModel::create([
            'name' => 'Business'
        ]);
        CategoryModel::create([
            'name' => 'Entertainment'
        ]);
        CategoryModel::create([
            'name' => 'Sports'
        ]);
        CategoryModel::create([
            'name' => 'Education'
        ]);
    }
}
