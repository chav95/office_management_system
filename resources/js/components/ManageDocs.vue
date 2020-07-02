<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <create-doc
            :selected_doc="selected_doc"   
            @success="loadDocData()"
          />
          <div class="card-header">
            <h3 class="card-title"><strong>Document List</strong></h3>
            <button class="btn btn-primary" style="float: right" @click="createItem()">New Document</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <!-- <th>Notification Date</th> -->
                  <th>Due Date</th>
                  <th>Description</th>
                  <th>Created By</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- <tr>
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
                </tr> -->
                <template v-if="doc_list.data.length > 0">
                  <tr v-for="(item) in doc_list.data" :key="item.id">
                    <td>{{item.name}}</td>
                    <!-- <td>{{formatDatetime(item.notif_date)}}</td> -->
                    <td>{{formatDatetime(item.due_date)}}</td>
                    <td><pre class="doc_description">{{item.description}}</pre></td>
                    <td>{{item.user.name | ucwords}}</td>
                    <td>
                      <div class="modify_box" v-if="userLogin.id === item.created_by">
                        <a class="modify-btn" @click="editItem(item)" title="Edit Document">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" @click="deleteItem(item)" title="Delete Document">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h5 class="text-center">No Document</h5></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="doc_list" @pagination-change-page="getPageContent"></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import CreateDoc from './modals/CreateDoc'
  import moment from 'moment'

  export default {
    components: {
      CreateDoc
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },
        doc_list: {
          data: []
        },

        selected_doc: {
          action: '',
          id: 0,
          name: '',
          notif_date: '',
          due_date: '',
          description: '',
        },
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
      getPageContent(page = 1) {
        axios.get(window.location.origin+'/api/doc/getDocData?page=' + page)
          .then(response => {
            this.doc_list = response.data;
          });
      },

      createItem(){
        this.selected_doc = {
          action: 'create_doc',
          id: 0,
          name: '',
          notif_date: '',
          due_date: '',
          description: '',
        }
        $('#CreateDoc').modal('show')
      },
      editItem(item){
        this.selected_doc.id = item.id
        this.selected_doc.name = item.name
        this.selected_doc.due_date = item.due_date
        // this.selected_doc.notif_date = item.notif_date
        this.selected_doc.description = item.description
        this.selected_doc.action = 'edit_doc'
        $('#CreateDoc').modal('show')
      },
      deleteItem(item){
        this.$confirm(`Delete ${item.name}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                axios.delete(`${window.location.origin}/api/doc/${item.id}`)
                  .then(res => {
                    this.$alert('Delete Successful', '', 'success');
                    this.loadDocData()
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
              });
          })
          .catch(error => console.error(error));
      }
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

  .modify_box{
    width: 52px;
    margin-bottom: 10px;
  }
  .doc_description{
    padding: 0;
    margin-bottom: 0;
    font-family: inherit;
    font-size: inherit;
  }
</style>