<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <create-doc @success="loadDocData()"/>
          <div class="card-header">
            <h3 class="card-title"><strong>Document / Maintanance List</strong></h3>
            <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateDoc">New Document</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Notification Date</th>
                  <th>Due Date</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <router-link to="/manage-docs/1">STNK Toyota Avanza (B 5213 BMD)</router-link>
                  </td>
                  <td>Document</td>
                  <td>1 May 2022</td>
                  <td>21 December 2022</td>
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
                <template v-if="doc_list.length > 0">
                  <tr v-for="(item) in doc_list" :key="item.id">
                    <td>{{item.name}}</td>
                    <td>{{item.type}}</td>
                    <td>{{formatDatetime(item.notif_date)}}</td>
                    <td>{{formatDatetime(item.due_date)}}</td>
                    <td>
                    <div>
                      <a class="modify-btn" title="Edit Document">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem(item.name)" title="Delete Document">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h5 class="text-center">No Document / Notification</h5></td></tr>
                </template>
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
  import CreateDoc from './modals/CreateDoc'
  import moment from 'moment'

  export default {
    components: {
      CreateModal, CreateDoc
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },
        doc_list: [],
      }
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll')
      },
      loadDocData(){
        axios.get(window.location.origin+'/api/doc/getDocData')
          .then(({data}) => {
            this.doc_list = data
          })
      },
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
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      });
      this.loadDocData();
    }
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }
</style>