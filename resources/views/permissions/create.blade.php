<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions / Create
            </h2>
            <a class="bg-slate-700 text-sm rounded-sm px-5 py-2 text-white" href="{{ route('permissions.index') }}">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permissions.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" name="name" placeholder="Enter Name" 
                                value="{{old('name')}}" @error('name') is-invalid @enderror
                                class="border-gray-300 w-1/2 shadow-sm focus:border-indigo-300 rounded-md" />
                                <div>
                                @error('name') <span class="text-red-600 text-sm">{{$message}}</span> @enderror
                                </div>
                            </div>
                            <button class="bg-slate-700 text-sm rounded-sm px-5 py-2 text-white">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
