<template>
  <div class="container">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card my-auto">
          <div class="card-header">
            <pagination :data="musics" @pagination-change-page="getResults"></pagination>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 100%;">
            <div class="card-tools">
              <audio-player 
                :file="file"
                :file_id="file_id"
                :judul="judul"
                :autoPlay="autoPlay" 
                v-on:playNext="nextMusic">
              </audio-player>
            </div>
            
            <table class="table table-head-fixed">
              <thead>
                <tr>
                  <th>Judul</th>
                  <th></th>
                  <th v-if="$route.params.playlist_id">Playlist</th>
                  <th>Uploaded At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="musics.data.length > 0">
                  <tr v-for="(music,index) in musics.data" :key="index" hover:bg-blue px-4 py2>
                    <td>{{music.judul}}</td>
                    <td>
                      <button 
                        type="button" class="btn btn-outline-primary playlist-play-btn"
                        @click="playAudio(music.judul, '/storage/'+music.path, music.id, index)"
                      >
                        Play
                        <i class="fas fa-play-circle nav-icon"></i>
                      </button>
                    </td>
                    <td v-if="$route.params.playlist_id" class="text-capitalize">{{music.nama_playlist}}</td>
                    <td>{{formatDatetime(music.created_at)}}</td>
                    <td>
                      <div class="modify-btn-container">
                        <a class="modify-btn" title="Add To Wishlist" 
                          v-on:click="addToWishlist(music.id, music.judul)"
                        >
                          <i class="fa fa-folder-plus color-purple fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" title="Download" 
                          v-on:click="download(music.judul, '/storage/'+music.path, music.id)"
                        >
                          <i class="fa fa-download color-green fa-fw fa-lg"></i>
                        </a>
                        <!--<a class="modify-btn" title="Edit"><i class="fa fa-edit color-blue fa-fw fa-lg"></i></a>-->
                        <a class="modify-btn" title="Delete" 
                          v-on:click="deleteMusic(music.id, music.judul)"
                        >
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h3 class="text-center">Playlist Is Empty</h3></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="musics" @pagination-change-page="getResults"></pagination>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>        
    </div>
  </div>
</template>

<script>
  import AudioPlayer from './reusables/PlayAudio.vue';
  import moment from 'moment';
  import PlayAudioVue from './reusables/PlayAudio.vue';

  export default {
    components: {
      AudioPlayer,
    },
    data(){
      return{
        file: null,
        file_id: null,
        judul: null,

        autoPlay: false,
        musics:{data:{}},
        fileArr: [],
        judulArr: [],
        //playingIndex: this.$route.params.playlist_id,
      }
    },
    methods:{
        loadMusics(){ 
          if(this.$route.params.playlist_id){
            let musicList = axios.get(window.location.origin+'/api/music/playlist-'+this.$route.params.playlist_id).then(({data}) => { 
              this.musics = data;
              for(let item of data.data){
                this.fileArr.push('/storage/'+item.path);
                this.judulArr.push(item.judul);
              }
            });
          }else{
            let musicList = axios.get(window.location.origin+'/api/music/getMusicList/').then(({data}) => { 
              this.musics = data;
              for(let item of data.data){
                this.fileArr.push('/storage/'+item.path);
                this.judulArr.push(item.judul);
              }
            });
          }
        },
        getResults(page = 1){
          if(this.$route.params.playlist_id){
            axios.get(window.location.origin+'/api/music/playlist-'+this.$route.params.playlist_id+'?page=' + page)
              .then(response => {
                this.musics = response.data;
                for(let item of data.data){
                  this.fileArr.push('/storage/'+item.path);
                  this.judulArr.push(item.judul);
                }
              });
          }else{
            axios.get(window.location.origin+'/api/music/getMusicList/?page=' + page)
              .then(response => {
                this.musics = response.data;
                for(let item of data.data){
                  this.fileArr.push('/storage/'+item.path);
                  this.judulArr.push(item.judul);
                }
              });
          }
        },
        formatDatetime(datetime){
          return moment(String(datetime)).format('llll');
        },
        playAudio(judul, path, id, index){
          this.judul = judul;
          this.file = path;
          this.file_id = id;
          this.autoPlay = true;
          this.playingIndex = index;
        },
        nextMusic(){
          let next = this.playingIndex+1;
          if(this.fileArr[next] == null){
            next = 0;
          }
          this.playingIndex = next;
          this.file = this.fileArr[next];
          this.judul = this.judulArr[next];
        },
        download(judul, path, id){
          axios.get(path, { responseType: 'blob' })
            .then(({ data }) => {
              const blob = new Blob([data], {type: 'audio/mp3'});
              let link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = judul;
              link.click();
              
              let postToLog = {
                'judul' : judul,
                'music_id' : id,
                'filename' : path.replace('/storage/uploadedMusic/', '')
              }
              axios.post(window.location.origin+'/api/log', postToLog)
              .then(({ data }) => {
                  
              })
              .catch(error => console.error(error));
          })
          .catch(error => console.error(error));
        },
        addToWishlist(music_id, music_judul){
          this.$confirm('Add '+music_judul+' to your wishlist?', '', 'question')
          .then( () => {
            let postToWishlist = {
              'music_id' : music_id,
            }
            axios.post(window.location.origin+'/api/wishlist', postToWishlist)
              .then(({ response }) => {
                this.$alert(music_judul+' added to your wishlist', '', 'success')
              })
              .catch(error => console.error(error));
          })
          .catch(error => console.error(error));
        },
        deleteMusic(music_id, music_judul){
          let playlist = 'Music Bank permanently';
          let confirm_type = 'warning';
            if(this.$route.params.playlist_id){
              playlist = this.$options.filters.capitalize(this.$route.params.playlist_title)+' playlist';
              confirm_type = 'question';
            }

            this.$confirm('Delete '+music_judul+' from '+playlist+'?', '', confirm_type)
              .then( () => {
                if(this.$route.params.playlist_id){
                  let patchMusic = {
                    'act': 'remove_from_playlist',
                    'playlist_detail_id': music_id,
                    'playlist_id': this.$route.params.playlist_id
                  }
                  axios.post(window.location.origin+'/api/music', patchMusic)
                    .then(({response}) => {
                      this.$alert(music_judul+' removed from'+playlist+' playlist', '', 'success');
                      this.loadMusics();
                    })
                    .catch(({error}) => this.$alert(error.message, '', 'error'));
                }else{
                  this.$confirm('This delete action cannot be undone!', '', 'warning')
                    .then( () => {
                      axios.delete(window.location.origin+'/api/music/'+music_id)
                        .then(({response}) => {
                          this.$alert('Delete Successful', '', 'success');
                          this.loadMusics();
                        })
                        .catch(({error}) => this.$alert(error.message, '', 'error'));
                    });
                }
              })
              .catch(error => console.error(error));
        }
    },
    watch: {
      '$route.params.playlist_id': function(playlist_id){
        this.loadMusics();
      }
    },
    mounted() {
      this.loadMusics();
    }
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }
</style>