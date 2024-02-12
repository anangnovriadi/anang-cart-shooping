@extends('layouts.main', ['count_total' => $count])


@section('content')
    <main class="my-8">
        <div class="container px-2 mx-auto">
            <div class="flex justify-center my-6">
                <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y rounded-md md:w-4/5 lg:w-4/5">
                    @if ($message = Session::get('success'))
                        <div class="p-4 mb-3 bg-green-400 rounded">
                            <p class="text-green-800">{{ $message }}</p>
                        </div>
                    @endif
                    <h3 class="text-2xl font-medium text-gray-700 mb-4">Cart List</h3>
                    <div class="flex-1">
                        <table class="w-full text-sm lg:text-base" cellspacing="0">
                            <thead>
                            <tr class="h-12">
                                <th class="text-left">Produk</th>
                                <th class="text-left">Pilihan Harga</th>
                                <th class="text-left">Kuantitas</th>
                                <th class="text-left">Subtotal</th>
                                <th class="text-left">Hapus</th>
                            </tr>
                            </thead>
                            <form method="post" action="{{ url('update-cart') }}">
                            @csrf
                            <tbody>
                                @foreach ($carts as $item)
                                <tr>
                                    <td class="hidden pb-4 md:table-cell">
                                        <input type="hidden" name="id" value="{{ $item->id }}"/>
                                        <div class="flex gap-4 items-center">
                                            <a href="#">
                                                <img src="{{ $item->image }}" class="w-14 h-144 rounded" alt="Thumbnail">
                                            </a>
                                            <div>
                                                <p class="mb-2">{{ $item->name }}</p>  
                                                <p class="mb-2 text-gray-500">{{ $item->code }}</p>  
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-2">@currency($item->price)</p>  
                                    </td>
                                    <td>
                                        <p class="mb-2 flex gap-2">
                                        <form action="{{ route('update.qty')}}" method="post" class="flex gap-2">
                                            @csrf
                                            <select id="qty" name="qty" class="w-14 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="1" {{ ($item->qty === 1) ? 'selected': '' }}>1</option>
                                                <option value="2" {{ ($item->qty === 2) ? 'selected': '' }}>2</option>
                                                <option value="3" {{ ($item->qty === 3) ? 'selected': '' }}>3</option>
                                                <option value="4" {{ ($item->qty === 4) ? 'selected': '' }}>4</option>
                                                <option value="5" {{ ($item->qty === 5) ? 'selected': '' }}>5</option>
                                            </select>
                                            <input type="hidden" name="id" value="{{ $item->id }}" />
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                        </p>  
                                    </td>
                                    <td>
                                        <p class="mb-2">@currency($item->sub_total)</p>  
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="{{ url('delete-cart', ['id' => $item->id]) }}">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </form>
                        </table>
                        <div class="flex justify-between items-center border-b-2 border-t-2 p-2">
                            <a>Code Discount: {{ $code_discount ? $code_discount : '-' }}</a>
                            <a data-toggle="modal" data-target="#exampleModal" class="font-bold text-yellow-500 cursor-pointer" style="color: rgba(245,158,11,var(--tw-text-opacity))"><i class="fa-solid fa-tag"></i> Gunakan kode diskon / reward</a>
                        </div>
                        <div class="text-right p-2">
                            <p class="font-bold">Total: @currency($total)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form method="post" action="{{ url('update-discount') }}">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kode Diskon</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="text" name="code" class="form-control" placeholder="Discount code" aria-label="Discount code" aria-describedby="basic-addon2">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </main>
@endsection