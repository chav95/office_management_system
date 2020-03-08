<template>
  <div class="container">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Booking Room List</h3>
              <button class="btn btn-primary" style="float: right">Book Room</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Room</th>
                  <th>Book Date</th>
                  <th>Book TIme</th>
                  <th>Extra(s)</th>
                  <th>Booked By</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Meeting Room A</td>
                  <td>28 Feb 2020</td>
                  <td>10.00 - 13.00</td>
                  <td>
                    <ul>
                      <li>Projector</li>
                      <li>Snacks</li>
                    </ul>
                  </td>
                  <td>Budi Suharjo</td>
                </tr>
                <tr>
                  <td>Meeting Room B</td>
                  <td>28 Feb 2020</td>
                  <td>15.00 - 16.00</td>
                  <td>
                    <ul>
                      <li>Projector</li>
                    </ul>
                  </td>
                  <td>Nadia Hutagalung</td>
                </tr>                
                <tr>
                  <td>Meeting Room A</td>
                  <td>28 Feb 2020</td>
                  <td>15.00 - 18.00</td>
                  <td>-</td>
                  <td>Raka</td>
                </tr>
                </tbody>
              </table>
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
        wishlist:{data:{}},
        fileArr: [],
        judulArr: [],
        //playingIndex: this.$route.params.playlist_id,
      }
    },
    methods:{
        loadWishlist(){
            axios.get(window.location.origin+'/api/wishlist').then(({data}) => {
                this.wishlist = data;
                for(let item of data.data){
                    this.fileArr.push('/storage/'+item.path);
                    this.judulArr.push(item.judul);
                }
            });
        },
        getResults(page = 1){
            axios.get(window.location.origin+'/api/wishlist?page=' + page)
                then(({response}) => {
                    this.wishlist = response.data; console.log(response.data)
                    for(let item of response.data){
                        this.fileArr.push('/storage/'+item.path);
                        this.judulArr.push(item.judul);
                    }
                });
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
    },
    watch: {
      '$route.params.playlist_id': function(playlist_id){
        this.loadWishlist();
      }
    },
    mounted() {
      this.loadWishlist();
    }
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }
</style>