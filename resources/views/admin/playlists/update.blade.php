<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Edit Playlist')}}
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
                    <form action="{{route('playlists.update', ['playlist'=>$playlist->id])}}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="name"
                                   value="{{old('name') ?? $playlist->name}}"
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
                                <option value="{{true}}">Private</option>
                                @if($playlist->protected == false)
                                    <option selected value="{{false}}">Public</option>
                                @else
                                    <option value="{{false}}">Public</option>
                                @endif
                            </select>
                        </div>

                        {{-- Playlist User --}}
                        <div class="form-control">
                            <label for="user_id" class="label">
                                <span class="label-text">User</span>
                            </label>
                            <select
                                class="select select-bordered w-full max-w-xs"
                                name="user_id" id="user_id">
                                <option value="{{null}}">No User</option>
                                @foreach($users as $user)
                                    @if($user->id == $playlist->user_id)
                                        <option selected value="{{$user->id}}">{{$user->name}}</option>
                                    @else
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif

                                @endforeach
                            </select>
                        </div>

                        {{--Remove Tracks--}}
                        <div class="py-2 overflow-x-auto overflow-auto">
                            <h2 class="py-2">Tracks</h2>
                            <table class="table w-full table-zebra">
                                <thead>
                                <tr>
                                    <th>Track Name</th>
                                    <th>Artist</th>
                                    <th>Genre</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($playlist->tracks as $track)
                                    <tr>
                                        <td>{{$track->name}}</td>
                                        <td>{{$track->artist}}</td>
                                        <td>{{$track->genre->name ?? '-'}}</td>
                                        <td>
                                            <a class="btn btn-sm"
                                               id="{{$track->id}}"
                                               href="{{route('playlists.remove', ['playlist'=>$playlist->id, 'track'=>$track->id])}}">
                                                Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="">Total Songs: {{$playlist->tracks()->count()}}</td>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{--Add Tracks--}}
                        <div class="form-control">
                            <div class="p-4 grid grid-cols-6 gaps-2 overflow-auto">
                                <div class="col-span-6">
                                    <h2 class="py-2">Add Tracks:</h2>
                                    <table class="w-full table table-compact">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Track Name</th>
                                            <th>Artist</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_tracks as $track)
                                            @if(!$playlist->tracks->contains('id', $track->id))
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                               name="add_tracks[]"
                                                               value="{{$track->id}}">
                                                    </td>
                                                    <td>{{$track->name}}</td>
                                                    <td>{{$track->artist}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="py-6">

                            <a href="{{route('playlists.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Playlists
                            </a>
                            <button
                                class="btn btn-sm btn-primary text-gray-50"
                                type="submit">
                                Update Playlist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
