<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Add Role')}}
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
                    <form action="{{route('roles.store')}}" method="post">
                        @csrf
                        {{--   Role Name  --}}
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Role Name"
                                   value="{{old('name')}}"
                                   id="name"
                                   name="name">
                        </div>
                        <div class="form-control">
                            <label for="permissions" class="label">
                                <span class="label-text">
                                    Permissions
                                </span>
                            </label>
                            <table class="w-full table table-compact">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Role Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_permissions as $permission)
                                    <tr>
                                        <td>
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{$permission->id}}">
                                        </td>
                                        <td>{{$permission->id}}</td>
                                        <td>{{$permission->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="py-6">
                            <button
                                class="btn btn-sm btn-primary text-gray-50"
                                type="submit">
                                Save Role
                            </button>
                            <a href="{{route('roles.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Roles
                            </a>
                            <button class="btn btn-sm btn-accent" type="reset">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- TODO: Update roles/create.blade file -->
