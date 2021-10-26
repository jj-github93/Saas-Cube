<x-guest-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Add User')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                        @endif
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('users.store')}}" method="post">
                        @csrf
                        <div class="form-control">
                            <label for="username" class="label">
                                <span class="label-text">Username</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Username"
                                   value="{{old('name')}}"
                                   id="username"
                                   name="name">
                        </div>
                        <div class="form-control">
                            <label for="email" class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email"
                                   class="input input-bordered"
                                   placeholder="Email"
                                   value="{{old('email')}}"
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
                                Save New User
                            </button>
                            <a href="{{route('users.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Users
                            </a>
                            <button class="btn btn-sm btn-accent" type="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
