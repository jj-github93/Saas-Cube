<x-guest-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Tracks')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="table w-full table-zebra">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>#</th>
                                <th>Track Name</th>
                                <th>Artist</th>
                                <th>Album</th>
                                <th>Genre</th>
                                <th class="flex justify-between">
                                    <span class="pt-2">Action

                                    </span>
                                    <a
                                        href="{{route('tracks.create')}}"
                                        class="btn btn-sm btn-tertiary tet-gray-50">
                                        Add Track
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tracks as $key=>$track)
                                <tr class="hover">
                                    <td>{{$track->id}}</td>
                                    <td>{{$track->track_number}}</td>
                                    <td>{{$track->name}}</td>
                                    <td>{{$track->artist}}</td>
                                    <td> {{$track->album}} </td>
                                    <td>{{$track->genre}}</td>
                                    <td>
                                        <a href="{{url('/admin/tracks/' . $track->id)}}" class="btn btn-sm btn-primary text-gray-50">Details</a>
                                        <a href="{{url('/admin/tracks/' . $track->id . '/edit')}}" class="btn btn-sm btn-secondary text-gray-50">Update</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{$tracks->onEachSide(1)->links()}}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
