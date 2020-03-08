@if (count($playlist['children']) > 0)
    <li class="nav-item has-treeview">
        <router-link class="nav-link smaller-text"
            :to="{
                name: 'playlist',
                params: {
                    'playlist_id': $playlist['id']}},
                    'playlist_name': '{{str_replace(' ', '-', $playlist['nama_playlist'])}}'
                }
            }"
        >
            <i class="fas fa-music nav-icon color-blue smaller-icon"></i>
            <p class="text-capitalize">
                {{$playlist['nama_playlist']}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </router-link>
        <ul class="nav nav-treeview">
            @foreach($playlist['children'] as $playlist)
                @include('partials.playlist', $playlist)
            @endforeach
            <add-playlist :parent_id="{{$playlist['id']}}"></add-playlist>
        </ul>
    </li>
@else
    <li class="nav-item">
        <router-link class="nav-link smaller-text"
            :to="{
                name: 'playlist',
                params: {
                    'playlist_id': {{$playlist['id']}},
                    'playlist_name': '{{str_replace(' ', '-', $playlist['nama_playlist'])}}'
                }
            }"
        >
            <i class="fas fa-music nav-icon color-blue smaller-icon"></i>
            <p class="text-capitalize">{{$playlist['nama_playlist']}}</p>
        </router-link>
    </li>
@endif