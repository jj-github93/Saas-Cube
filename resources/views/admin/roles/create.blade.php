<x-guest-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Add Playlist')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('playlists.store')}}" method="post">
                        @csrf
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Playlist Name"
                                   value="{{old('name')}}"
                                   id="name"
                                   name="name">
                        </div>
                        {{-- Playlist Privacy --}}
                        <div class="form-control">
                            <label for="protected" class="label">
                                <span class="label-text">Protected</span>
                            </label>
                            <select
                                class="select select-bordered w-full max-w-xs"
                                name="protected" id="protected">
                                <option selected value="1">Private</option>
                                <option value="0">Public</option>
                            </select>
                        </div>'
                        {{-- Playlist User --}}
                        <div class="form-control">
                            <label for="user_id" class="label">
                                <span class="label-text">User</span>
                            </label>
                            <select
                                class="select select-bordered w-full max-w-xs"
                                name="user_id" id="user_id">
                                <option selected value="{{null}}">No User</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="py-6">
                            <button
                                class="btn btn-sm btn-primary text-gray-50"
                                type="submit">
                                Save Playlist
                            </button>
                            <a href="{{route('playlists.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Playlists
                            </a>
                            <button class="btn btn-sm btn-accent" type="reset">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
