<template>
  <div class="container">
    <div class="modal fade" id="CreateDoc" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateDocLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateDocLabel">Add New Doc / Maintanance</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <label for="type">Type</label>
                  <select v-model="postToDoc.type" id="type" class="form-control">
                    <option value="" disabled>Select Type</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Document">Document</option>
                  </select>

                  <label for="name">Name</label>
                  <input type="text" v-model="postToDoc.name" class="form-control" id="name"  placeholder="Doc / Maintenance Name">

                  <label for="notif_date">Notification Date</label>
                  <datepicker v-model="postToDoc.notif_date" placeholder="Notification Date" 
                    :language="id" id="notif_date" input-class="input-datepicker"
                  ></datepicker>

                  <label for="notif_date">Due Date</label>
                  <datepicker v-model="postToDoc.due_date" placeholder="Due Date" 
                    :language="id" id="notif_date" input-class="input-datepicker"
                  ></datepicker>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" @click="submitNewRoom()" class="btn btn-primary">{{loading ? 'Please Wait...' : 'Create'}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Datepicker from 'vuejs-datepicker';
  import {id, en} from 'vuejs-datepicker/dist/locale'
  import moment from 'moment'
  
  export default {
    components: {
      Datepicker
    },
    prop: {
        selected_maintenance: Object,
    },
    data(){
      return{
        id,
        en,

        loading: false,
      }
    },
    computed: {
      completed(){
        if(this.postToDoc.type !== '' && this.postToDoc.name !== '' && this.postToDoc.notif_date != '' && this.postToDoc.due_date != ''){
          return true
        }
        return false
      }
    },
    methods: {
      submitNewRoom(){
        if(this.completed === true){
          this.loading = true

          axios.post(window.location.origin+'/api/doc', this.postToDoc)
            .then(res => {
              this.loading = false
              
              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Add New Doc / Maintanance Success', '', 'success')
                $('#CreateDoc').modal('hide');

                this.postToDoc.name = ''
                this.postToDoc.capacity = ''
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
    }
  }
</script>

<style lang="scss" scoped>

</style>