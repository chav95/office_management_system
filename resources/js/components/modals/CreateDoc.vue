<template>
  <div class="container">
    <div class="modal fade" id="CreateDoc" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateDocLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateDocLabel">{{selected_doc.action == 'create_doc' ? 'Add New Document' : 'Edit Document'}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" v-model="selected_doc.name" class="form-control" placeholder="Document Name">

                  <label>Nomor Dokumen</label>
                  <input type="text" v-model="selected_doc.no_document" class="form-control" placeholder="Document Number">

                  <label>Tanggal Terbit</label>
                  <datepicker v-model="selected_doc.document_date" placeholder="Issue Date" 
                    :language="id" input-class="input-datepicker" 
                    :disabledDates="{from: notif_max_date}"
                  ></datepicker>

                  <label>Berlaku Sampai</label>
                  <datepicker v-model="selected_doc.due_date" placeholder="Due Date" 
                    :language="id" input-class="input-datepicker mb-0" :disabled="this.tidak_terbatas"
                    :disabledDates="{to: new Date(new Date().setDate(new Date().getDate() - 1))}"
                  ></datepicker>
                  <input type="checkbox" class="mb-1" v-model="tidak_terbatas"> Masa Berlaku Tidak Terbatas <br>

                  <template v-if="userLogin.privilege == 'admin' || userLogin.privilege == 'super_admin'">
                    <label>User</label>
                    <select v-model="selected_doc.user" class="form-control" placeholder="Document Owner">
                      <option value="0" disabled>Select User</option>
                      <option v-for="item in user_data" :key="item.id" :value="item.id">{{item.name}}</option>
                    </select>
                  </template>

                  <label>Notes (Optional)</label>
                  <textarea v-model="selected_doc.description" rows="4" class="form-control" placeholder="Description (Optional)"></textarea>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" @click="submitDoc()" class="btn btn-primary">
                {{loading 
                  ? 'Please Wait...' 
                  : selected_doc.action == 'create_doc'
                    ? 'Create'
                    : 'Submit Edit'
                }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Datepicker from 'vuejs-datepicker'
  import {id, en} from 'vuejs-datepicker/dist/locale'
  import moment from 'moment'
  
  export default {
    components: {
      Datepicker
    },
    props: {
      userLogin: Object,
      selected_doc: Object,
    },
    data(){
      return{
        id,
        en,

        user_data: {},
        tidak_terbatas: false,

        loading: false,
      }
    },
    computed: {
      due_date_disable(){
        if(this.tidak_terbatas == true){
          return true
        }
        return false
      },
      completed(){
        if(this.selected_doc.name !== '' /*&& this.selected_doc.notif_date != '' && this.selected_doc.due_date != ''*/){
          return true
        }
        return false
      },
      notif_max_date(){
        if(this.selected_doc.due_date != ''){
          return new Date(this.selected_doc.due_date + 1)
        }
        return 0
      },
    },
    methods: {
      loadUserData(){
        axios.get(window.location.origin+'/api/user/getUserData')
          .then(res => {
            this.user_data = res.data
          })
      },

      submitDoc(){
        if(this.completed === true){
          this.loading = true
          this.selected_doc.due_date = this.tidak_terbatas == true ? 'Tidak Terbatas' : this.selected_doc.due_date
          let text = this.selected_doc.action == 'create_doc'
            ? 'Add New'
            : 'Edit'

          axios.post(window.location.origin+'/api/doc', this.selected_doc)
            .then(res => {
              this.loading = false
              
              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Add New Document Success', '', 'success')
                $('#CreateDoc').modal('hide');
              }else{ //console.log(res)
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((error) => {
              this.loading = false
              
              this.$alert(error, '', 'error')
            });
        }else{
          this.$alert('All Data Must Be Filled', '', 'error');
        }
      }
    },

    mounted(){
      this.loadUserData()
    }
  }
</script>

<style lang="scss" scoped>

</style>