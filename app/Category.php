<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    public function menus() {
        return $this->belongsToMany('App\Menu', 'menu_category', 'category_id', 'menu_id');
    }

    public function isMain() {
        return $this->parent_id == 0;
    }

    public function getUrl() {

        return route('site.category.only', ['slug' => $this->translated()->slug]);
    }

    public function getProducts() {
        $products = [];

        if ($this->products) {
            $this->products->map(function($product) use (&$products) {
                $products[] = $product;
            });
        }

        if ($this->subCategories) {
            $this->subCategories->map(function($c) use (&$products) {
                if ($c->products) {
                    foreach ($c->products()->latest()->get() as $product) {
                        $products[] = $product;
                    }
                }
            });
        }

        return collect($products);
    }

    public function isActive() {

        return (bool) $this->active;
    }

    public function isSub() {
        return !$this->isMain();
    }

    public function products() {

        return $this->hasMany('App\Product', 'category_id');
    }

    public function subsubCategory() {

        return $this->hasMany('App\Category', 'parent_id');
    }

    public function mainCategory() {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function subCategories() {

        return $this->hasMany('App\Category', 'parent_id');
    }

    public function details() {
        return $this->hasMany(_Category::class);
    }

    public function translated($locale = null) {
        return $this->details()->where('locale_id', Locale::where('name', $locale ?: app()->getLocale())->first()->id)->first();
    }

}
