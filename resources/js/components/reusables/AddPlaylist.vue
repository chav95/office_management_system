<template>
    <li class="nav-item">
        <a href="" @click="updatePlaylistParentID(parent_id)" class="nav-link smaller-text" :id="parent_id" data-toggle="modal" data-target="#CreatePlaylist">
            <p class="text-capitalize">+Add New Playlist+</p>
        </a>
    </li>
</template>

<script>
    import {mapMutations} from 'vuex'
    export default {
        name: 'addPlaylist',
        props: {
            parent_id: {
                type: Number,
                default: 0
            },
        },
        data(){
            return{
                
            }
        },
        methods: {
            updatePlaylistParentID(value){// console.log(value);
            this.$store.commit('SET_PLAYLIST_PARENT_ID', value);
      },
        },
        computed: {
            ...mapMutations([
                'SET_PLAYLIST_PARENT_ID'
            ])
        }
    }
</script>