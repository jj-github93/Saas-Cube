<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Edit Track')}}
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

                    <form action="{{route('tracks.update', ['track'=>$track->id])}}" method="post">
                        @csrf
                        @method('patch')
                        {{-- # --}}
                        <div class="form-control">
                            <label for="track_number" class="label">
                                <span class="label-text">#</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="#"
                                   value="{{old('track_number') ?? $track->track_number}}"
                                   id="track_number"
                                   name="track_number">
                        </div>
                        {{-- Name --}}
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="name"
                                   value="{{old('name') ?? $track->name}}"
                                   id="name"
                                   name="name">
                        </div>
                        {{-- Artist --}}
                        <div class="form-control">
                            <label for="artist" class="label">
                                <span class="label-text">Artist</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Artist"
                                   value="{{old('artist') ?? $track->artist}}"
                                   id="artist"
                                   name="artist">
                        </div>
                        {{-- Album --}}
                        <div class="form-control">
                            <label for="album" class="label">
                                <span class="label-text">Album</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Album"
                                   value="{{old('album') ?? $track->album}}"
                                   id="album"
                                   name="album">
                        </div>
                        {{-- Genre --}}
                        <div class="form-control">
                            <label for="genre_id" class="lagenrebel">
                                <span class="label-text">Genre</span>
                            </label>
                            <select name="genre_id" id="genre_id"
                                    class="select select-bordered w-full max-w-xs">

                                <option value="{{null}}">No Genre Selected</option>
                                @foreach($all_genres as $key=>$value)
                                    @if($value->id == $track->genre_id)
                                        <option selected value="{{$value->id}}">{{$value->name}}</option>
                                    @endif
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Year --}}
                        <div class="form-control">
                            <label for="year" class="label">
                                <span class="label-text">Year</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Year"
                                   value="{{old('year') ?? $track->year}}"
                                   id="year"
                                   name="year">
                        </div>
                        {{-- Length --}}
                        <div class="form-control">
                            <label for="length" class="length">
                                <span class="label-text">Duration</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Duration"
                                   value="{{old('length') ?? $track->length}}"
                                   id="length"
                                   name="length">
                        </div>
                        <div class="py-6">
                            <button
                                class="btn btn-sm btn-primary text-gray-50"
                                type="submit">
                                Update Track
                            </button>
                            <a href="{{route('tracks.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Tracks
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
