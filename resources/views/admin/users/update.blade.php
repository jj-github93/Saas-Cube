<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Edit User')}}
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
                            <form action="{{route('users.update', ['user'=>$user])}}" method="post">
                                @csrf
                                @method('patch')

                                <div class="form-control">
                                    <label for="username" class="label">
                                        <span class="label-text">Username</span>
                                    </label>
                                    <input type="text"
                                           class="input input-bordered"
                                           placeholder="Username"
                                           value="{{old('name') ?? $user->name}}"
                                           id="username"
                                           name="name">
                                </div>
                                <div class="form-control">
                                    <label for="roles" class="label">
                                <span class="label-text">
                                    Role
                                </span>
                                    </label>
                                    @can('edit-own-profile' && !'user-create')
                                        <select name="roles" id="roles">
                                            <option
                                                value="{{$user->roles()->pluck('id')->first()}}">{{$userRoles}}</option>
                                        </select>
                                    @endcan
                                    @can('user-create')
                                        <select name="roles" id="roles">
                                            @foreach($roles as $role)
                                                @if($role != 'Admin')
                                                    <option
                                                        {{$userRoles != 'Manager' || $userRoles != 'Admin' ? 'disabled' : ''}}value="{{$role}}">{{$role}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endcan
                                </div>
                                <div class="form-control">
                                    <label for="email" class="label">
                                        <span class="label-text">Email</span>
                                    </label>
                                    <input type="email"
                                           class="input input-bordered"
                                           placeholder="Email"
                                           value="{{old('email') ?? $user->email}}"
                                           id="email"
                                           name="email">
                                </div>
                                <div class="form-control">
                                    <label for="password" class="label">
                                        <span class="label-text">Password</span>
                                    </label>
                                    <input type="password"
                                           class="input input-bordered"
                                           placeholder="Password"
                                           id="password"
                                           name="password">
                                </div>
                                <div class="form-control">
                                    <label for="password_confirmation" class="label">
                                        <span class="label-text">Confirm Password</span>
                                    </label>
                                    <input type="password"
                                           class="input input-bordered"
                                           placeholder="Confirm Password"
                                           id="password_confirmation"
                                           name="password_confirmation">
                                </div>
                                <div class="py-6">
                                    <button
                                        class="btn btn-sm btn-primary text-gray-50"
                                        type="submit">
                                        Update User
                                    </button>
                                    <a href="{{route('users.index')}}"
                                       class="btn btn-sm btn-secondary text-gray-50">
                                        Back To Users
                                    </a>
                                </div>

                                {{--                        @if ($errors->any())--}}
                                {{--                            @foreach($errors->any() as $error)--}}
                                {{--                                <div class="alert alert-error alert-sm my-2 py-1">--}}
                                {{--                                    <p class="flex-1">--}}
                                {{--                                        <i class="fas fa-exclamation-triangle mr-4 pl-2 pt-2"></i>--}}
                                {{--                                        <span>{{ $error }}</span>--}}
                                {{--                                    </p>--}}
                                {{--                                </div>--}}
                                {{--                            @endforeach--}}
                                {{--                        @endif--}}
                            </form>

                        </div>
                    </div>
                </div>
        </div>
</x-app-layout>
<!-- TODO: Update users/create.blade file. Add role and permission functionality -->

