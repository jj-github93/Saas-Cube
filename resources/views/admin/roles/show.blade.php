<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Role Details')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <dl class="grid grid-cols-6 gaps-2">
                        <dt class="col-span-1 font-bold py-1">ID</dt>
                        <dd class="col-span-5 py-1">{{$role->id}}</dd>
                        <dt class="col-span-1 font-bold py-1">Name</dt>
                        <dd class="col-span-5 py-1">{{$role->name}}</dd>
                        <dt class="col-span-1 font-bold py-1">Permissions</dt>
                        <dd class="col-span-5 py-1">
                            @foreach($rolePermissions as $permission)
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md"
                                >
                                    {{$permission->name}}
                                </span>

                            @endforeach
                        </dd>
                        <dd class="col-span-5 pt-3">
                            <form

                                action="{{route('roles.destroy',['role'=>$role])}}"
                                method="post">
                                @csrf
                                @method('delete')
                                <a href="{{route('roles.edit',['role'=>$role->id])}}"
                                   class="btn btn-sm btn-primary text-gray-50"
                                    {{$role->name == 'Admin' ? 'disabled': ""}}
                                >Update</a>
                                <button class="btn btn-sm btn-secondary text-gray-50"
                                    {{$role->name == 'Admin' ? 'disabled': ""}}
                                >
                                    Delete
                                </button>
                                <a href="{{url('/admin/roles')}}" class="btn btn-sm btn-accent">
                                    Back To Roles
                                </a>

                            </form>

                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

