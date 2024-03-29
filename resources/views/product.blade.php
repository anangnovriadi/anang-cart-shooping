@extends('layouts.main', ['count_total' => $count])

@section('content')
    <div class="container px-6 mx-auto">
        <h3 class="text-2xl font-medium text-gray-700">Product List</h3>
        <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
            <div class="w-full max-w-sm mx-auto overflow-hidden rounded-md shadow-md">
                <img src="{{ url($product->image) }}" alt="" class="w-full h-60">
                <div class="flex items-end justify-end w-full bg-cover">
                </div>
                <div class="p-3">
                    <div class="flex justify-between">
                        <p class="text-gray-700">{{ $product->name }}</p>
                        <form action="{{ route('add.cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                            <button type="submit" class="focus:outline-none"><i class="fa-solid fa-circle-plus"></i> cart</button>
                        </form>
                        
                    </div>
                    <span class="mt-2 text-gray-500">@currency($product->price)</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection