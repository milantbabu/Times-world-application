<?php

namespace  App\Http\Trait;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Product;

trait CommonTrait
{
	private function getUser($userId = 0): Builder
	{
		return User::select('id', 'name', 'email', 'password')
		->when($userId > 0, function($query) use($userId) {
			$query->where('id', $userId);
		})
		->latest();
	}

	private function getProducts(): Builder
	{
		return Product::with([
			'variants:id,product_id,size,color'
		])
		->select('id', 'title', 'description', 'image')
		->latest();
	}
}