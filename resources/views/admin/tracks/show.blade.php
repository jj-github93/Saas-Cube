<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Track Details')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <dl class="grid grid-cols-6 gaps-2">
                        <dt class="col-span-1">ID</dt>
                        <dd class="col-span-5">{{$track->id}}</dd>
                        <dt class="col-span-1">Track Number</dt>
                        <dd class="col-span-5">{{$track->track_number}}</dd>
                        <dt class="col-span-1">Name</dt>
                        <dd class="col-span-5">{{$track->name}}</dd>
                        <dt class="col-span-1">Artist</dt>
                        <dd class="col-span-5">{{$track->artist}}</dd>
                        <dt class="col-span-1">Album</dt>
                        <dd class="col-span-5">{{$track->album}}</dd>
                        <dt class="col-span-1">Genre</dt>
                        <dd class="col-span-5">{{$track->genre->name ?? '-'}}</dd>
                        <dt class="col-span-1">Duration</dt>
                        <dd class="col-span-5">{{$track->length}}</dd>
                        <dt class="col-span-1">Release Year</dt>
                        <dd class="col-span-5">{{$track->year}}</dd>
                        <dt class="col-span-1">Added</dt>
                        <dd class="col-span-5">{{$track->created_at}}</dd>
                        <dt class="col-span-1">Actions</dt>
                        <dd class="col-span-5">
                            <form
                                action="{{route('tracks.destroy',['track'=>$track])}}"
                                method="post">
                                @csrf
                                @method('delete')
                                <a href="{{route('tracks.edit',['track'=>$track->id])}}"
                                   class="btn btn-sm btn-primary text-gray-50">Update</a>
                                <button class="btn btn-sm btn-secondary text-gray-50">
                                    Delete
                                </button>
                            </form>

                        </dd>
                    </dl>
                    <p class="pt-6">
                        <a href="{{url('/admin/tracks')}}" class="btn btn-sm btn-accent">
                            Back To Tracks
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
