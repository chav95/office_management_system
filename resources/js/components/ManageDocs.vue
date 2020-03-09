<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <create-modal model_title="New Document"></create-modal>
          <div class="card-header">
            <h3 class="card-title"><strong>Document List</strong></h3>
            <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateModel">New Document</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Document Name</th>
                  <th>Document Number</th>
                  <th>Date of Issue</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <router-link to="/manage-docs/1">STNK Toyota Avanza (B 5213 BMD)</router-link>
                </td>
                  <td>BA 2912 AF</td>
                  <td>21 May 2010</td>
                  <td>
                    <div>
                      <a class="modify-btn" title="Edit Document">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem('STNK Toyota Avanza (B 5213 BMD)')" title="Delete Document">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <router-link to="/manage-docs/2">STNK Daihatsu Xenia (B 1977 TYZ)</router-link>
                </td>
                  <td>B 6345 UDX</td>
                  <td>8 Sep 2018</td>
                  <td>
                    <div>
                      <a class="modify-btn" title="Edit Document">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem('STNK Daihatsu Xenia (B 1977 TYZ)')" title="Delete Document">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import CreateModal from './reusables/CreateNewModal.vue';

  export default {
    components: {
      CreateModal,
    },
    data(){
      return{
        
      }
    },
    methods:{
      deleteItem(name){
        this.$confirm(`Delete ${name}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                this.$alert('Delete Successful', '', 'success');
                this.loadMusics();
              });
            })
          .catch(error => console.error(error));
      }
    },
    watch: {
      // '$route.params.playlist_id': function(playlist_id){
      //   this.loadWishlist();
      // }
    },
    mounted() {
      
    }
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }
</style>