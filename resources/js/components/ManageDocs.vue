<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <create-doc :selected_doc="selected_doc" :userLogin="userLogin" @success="getPageContent(data_page)"/>
          <import-doc @success="loadDocData()"/>
          <export-filter :module="exportModule"/>
          <div class="card-header">
            <h3 class="card-title"><strong>{{$route.path == '/manage-docs/history' ? 'History ' : ''}}Document List</strong></h3>
            <button v-if="$route.path != '/manage-docs/history'" class="btn btn-primary" style="float: right" @click="createItem()">New Document</button>
            <button v-if="$route.path != '/manage-docs/history'" class="btn btn-primary" style="float: right; margin-right: 5px" data-toggle="modal" data-target="#UploadDoc">Import From Excel</button>
            <button v-if="$route.path == '/manage-docs/history'" class="btn btn-primary" style="float: right" @click="exportToExcel()">Export Document</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Bagian (Unit)</th>
                  <th>Nama</th>
                  <th>Nomor Dokumen</th>
                  <th>Masa Berlaku</th>
                  <th>Waktu Pengurusan</th>
                  <th>Diurus Oleh</th>
                  <th class="no-print">Action</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="doc_list.data.length > 0">
                  <tr v-for="(item) in doc_list.data" :key="item.id">
                    <td>{{item.bagian}} ({{item.unit}})</td>
                    <td>{{item.name}}</td>
                    <td>{{item.no_document}}</td>
                    <td class="masa_berlaku">
                      {{formatDatetime(item.document_date)}}
                      <br>s/d<br>
                      {{formatDatetime(item.due_date)}}
                    </td>
                    <td>{{item.waktu_urus}}</td>
                    <!-- <td><pre class="doc_description">{{item.description}}</pre></td> -->
                    <!-- <td>{{item.user.name | ucwords}}</td> -->
                    <td>{{item.user.name}}</td>
                    <td class="no-print">
                      <div class="modify_box" v-if="(userLogin.id === item.created_by || userLogin.id == 6) && $route.path != '/manage-docs/history'">
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
  import moment from 'moment'
  import CreateDoc from './modals/CreateDoc'
  import ImportDoc from './modals/ImportDoc'
  import ExportFilter from './modals/ExportFilter'

  export default {
    components: {
      CreateDoc, ImportDoc, ExportFilter
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
        incoming_doc: {},
        user_data: {},

        selected_doc: {
          action: '',
          id: 0,
          name: '',
          no_document: '',
          document_date: '',
          due_date: '',
          description: '',
          user: 0,
        },

        exportModule: '',

        data_page: 1,
      }
    },
    methods:{
      formatDatetime(datetime){
        let result = moment(datetime)
        if(result == null || !result.isValid()){
          return datetime
        }else{
          return moment(String(datetime)).format('ll')
        }        
      },
      loadDocData(){
        axios.get(window.location.origin+'/api/doc/getDocData')
          .then(({data}) => {
            this.doc_list = data
          })
      },
      loadDocHistory(){
        axios.get(window.location.origin+'/api/doc/getDocHistory')
          .then(({data}) => {
            this.doc_list = data
          })
      },
      getIncomingDoc(){
        axios.get(window.location.origin+'/api/doc/getIncomingDoc')
          .then(({data}) => {
            this.incoming_doc = data
          })
      },

      getPageContent(page = 1) {
        let content = this.$route.path == '/manage-docs/history' ? 'getDocHistory' : 'getDocData'
        axios.get(window.location.origin+`/api/doc/${content}?page=` + page)
          .then(response => {
            this.doc_list = response.data
            this.data_page = response.data.current_page
          });
      },

      exportToExcel(){
        this.exportModule = 'document'

        $('#ExportFilter').modal('show');
      },

      createItem(){
        this.selected_doc = {
          action: 'create_doc',
          id: 0,
          name: '',
          no_document: '',
          document_date: '',
          due_date: '',
          description: '',
          user: 0,
        }
        $('#CreateDoc').modal('show')
      },
      editItem(item){
        this.selected_doc.id = item.id
        this.selected_doc.name = item.name
        this.selected_doc.no_document = item.no_document
        this.selected_doc.document_date = item.document_date
        this.selected_doc.due_date = item.due_date
        this.selected_doc.description = item.description
        this.selected_doc.user = item.user.id
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
      this.$route.path == '/manage-docs/history' ? this.loadDocHistory() : this.loadDocData()
      this.getIncomingDoc()
    },
    watch:{
      '$route.path'(newVal, oldVal){
        if(this.$route.path == '/manage-docs/history'){
          this.loadDocHistory()
        }else{
          this.loadDocData()
        }
      },
    },
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
    max-width: 350px;
    padding: 0;
    margin-bottom: 0;
    font-family: inherit;
    font-size: inherit;
  }
  .masa_berlaku{
    min-width: 110px;
  }
</style>