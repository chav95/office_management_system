<template>
    <ul class="nav nav-treeview">        
        <li class="nav-item"
            v-for="item in playlist" :key="item.id"
            :class="{'has-treeview': item.children.length > 0}"
        >
            <router-link class="nav-link smaller-text"
                :to="{
                    name: 'playlist',
                    params: {
                        'playlist_id': item.id,
                        'playlist_name': item.nama_playlist.replace(' ', '-'),
                        'playlist_title': item.nama_playlist
                    }
                }"
            >
                <i @click="deletePlaylist(item.id, item.nama_playlist)" class="fas fa-trash-alt nav-icon color-red smaller-icon"></i>
                <p class="text-capitalize">
                    {{item.nama_playlist}}
                    <i v-if="item.children.length > 0" class="right fas fa-angle-left"></i>
                </p>
            </router-link>
            <playlist-sidebar v-if="item.children.length > 0" :playlist="item.children" :addParentID="item.id"></playlist-sidebar>
        </li>
        <add-playlist :parent_id="addParentID"></add-playlist>
    </ul>
</template>

<script>
export default {
    props: {
        playlist: Array,
        addParentID: Number
    },
    data(){
        return{
            
        }
    },
    methods: {
        deletePlaylist(id, nama_playlist){
            this.$confirm('Confirm Delete Playlist '+nama_playlist+' and all the content?', '', 'error')
                .then(res => {
                    axios.delete(window.location.origin+'/api/playlist/'+id).then(result => {
                        this.$alert('Delete Success', '', 'success');
                    });
                }
            );
        }
    }
}
</script>