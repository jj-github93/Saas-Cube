<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Edit Role')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                     role="alert">
                                    <strong>{{$error}}</strong>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('roles.update', ['role'=>$role->id])}}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="name"
                                   value="{{old('name') ?? $role->name}}"
                                   id="name"
                                   name="name">
                        </div>


                        {{--Remove Permissions --}}
                        <div class="py-2 overflow-x-auto">
                            <h2 class="py-2">Permissions</h2>
                            <table class="table w-full table-zebra">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($rolePermissions as $_rolePermission)
                                    <?php $_permission = $permissions->where('id', $_rolePermission);?>
                                    <tr>
                                        <td>
                                            @foreach($_permission as $_perm)
                                                @if(!is_null($_perm))
                                                    {{$_perm->name}}
                                                @endif

                                            @endforeach
                                        </td>
                                        <td>
                                            <a class="btn btn-sm bg-red-700"
                                               id="{{$_rolePermission}}"
                                               href="{{route('roles.remove_permission', ['role'=>$role->id, 'permission'=>$_rolePermission])}}">
                                                Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>


                        <div class="py-2 overflow-x-auto form-control">
                            <h2 class="py-2">Add Permissions</h2>
                            <table class="table table-zebra col-span-6">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                    @if(!in_array($permission->id, $rolePermissions))
                                        <tr>
                                            <td><input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{$permission->id}}"></td>
                                            <td>{{$permission->id}}</td>
                                            <td>{{$permission->name}}</td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>
                            </table>

                        </div>

                        <div class="py-6">

                            <a href="{{route('roles.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Roles
                            </a>
                            <button
                                class="btn btn-sm btn-primary text-gray-50"
                                type="submit">
                                Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<!-- TODO: Update roles/update.blade file -->

