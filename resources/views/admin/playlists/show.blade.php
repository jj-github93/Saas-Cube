<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Playlist Details')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <dl class="grid grid-cols-6 gaps-2">
                        <dt class="col-span-1 font-bold py-1">ID</dt>
                        <dd class="col-span-5 py-1">{{$playlist->id}}</dd>
                        <dt class="col-span-1 font-bold py-1">Name</dt>
                        <dd class="col-span-5 py-1">{{$playlist->name}}</dd>
                        <dt class="col-span-1 font-bold py-1">User</dt>
                        <dd class="col-span-5 py-1">{{$playlist->user->name ?? "None"}}</dd>
                        <dt class="col-span-1 font-bold py-1">Protection</dt>
                        <dd class="col-span-5 py-1">{{($playlist->protected == true ? "Private" : "Public")}}</dd>
                        <dt class="col-span-1  py-1 font-bold">Added</dt>
                        <dd class="col-span-5 py-1">{{$playlist->created_at}}</dd>
                        <dt class="col-span-1 py-1 font-bold">Tracks</dt>
                        <dd class="col-span-5 py-1">{{$playlist->tracks()->count()}}</dd>
                        <dd class="col-span-6 py-1">
                            <table class="table w-full table-zebra">
                                <thead>
                                <tr>
                                    <th>Track Name</th>
                                    <th>Artist</th>
                                    <th>Genre</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($playlist->tracks as $track)
                                    <tr>
                                        <td>{{$track->name}}</td>
                                        <td>{{$track->artist}}</td>
                                        <td>{{$track->genre->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </dd>
                        <dd class="col-span-5 pt-3">
                            <form

                                action="{{route('playlists.destroy',['playlist'=>$playlist])}}"
                                method="post">
                                @csrf
                                @method('delete')
                                <a href="{{route('playlists.edit',['playlist'=>$playlist->id])}}"
                                   class="btn btn-sm btn-primary text-gray-50">Update</a>
                                <button class="btn btn-sm btn-secondary text-gray-50">
                                    Delete
                                </button>
                                <a href="{{url('/admin/playlists')}}" class="btn btn-sm btn-accent">
                                    Back To Playlists
                                </a>

                            </form>

                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
