<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Roles') }}
            </h2>
            <a class="bg-slate-700 text-sm rounded-sm px-5 py-2 text-white" href="{{ route('roles.create') }}">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-message></x-message>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Permissions
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created At
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($roles) > 0)
                            @foreach ($roles as $role)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $role->name }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $role->permissions->pluck('name')->implode(', ') }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $role->created_at->diffForHumans() }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('roles.edit', $role->id) }}" class="bg-slate-700 text-sm rounded-sm px-5 py-2 text-white">Edit</a>
                                        <a href="#" onclick="deleteRole({{ $role->id }})" class="bg-red-600 text-sm rounded-sm px-5 py-2 text-white">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    No Roles Found
                                </th>
                            </tr>
                            @endif
                        </tbody>
                        
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function deleteRole(id) {
                if(confirm('Are you sure you want to delete this role?')){
                    $.ajax({
                        url: '{{ route("roles.destroy") }}',
                        type: 'DELETE',
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                location.reload();
                            }
                        }
                    })
                }
                
            }
        </script>
    </x-slot>

</x-app-layout>
