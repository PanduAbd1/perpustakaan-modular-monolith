php <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-flash-message />
                    <x-validation-summary />

                    <form action="{{ route('books.store') }}" method="POST" novalidate>
                        @csrf
                        @include('books._form', ['book' => null])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
