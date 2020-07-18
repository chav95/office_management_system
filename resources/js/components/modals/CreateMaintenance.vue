<template>
  <div class="container">
    <div class="modal fade" id="CreateMaintenance" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateMaintenanceLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateMaintenanceLabel">{{selected_maintenance.action == 'create_maintenance' ? 'Add New Maintenance' : 'Edit Maintenance'}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" v-model="selected_maintenance.name" class="form-control" placeholder="Maintenance Name">

                  <label>Due Date</label>
                  <datepicker v-model="selected_maintenance.due_date" placeholder="Due Date" 
                    :language="id" input-class="input-datepicker" 
                    :disabledDates="{to: new Date(new Date().setDate(new Date().getDate() - 1))}"
                  ></datepicker>

                  <!-- <label>Notification Date</label>
                  <datepicker v-model="selected_maintenance.notif_date" placeholder="Notification Date" 
                    :language="id" input-class="input-datepicker" 
                    :disabledDates="{to: new Date(new Date().setDate(new Date().getDate() - 1)), from: notif_max_date}"
                  ></datepicker> -->

                  <label>Notes (Optional)</label>
                  <textarea v-model="selected_maintenance.description" rows="4" class="form-control" placeholder="Description (Optional)"></textarea>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" @click="submitMaintenance()" class="btn btn-primary">
                {{loading 
                  ? 'Please Wait...' 
                  : selected_maintenance.action == 'create_maintenance'
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
  import Datepicker from 'vuejs-datepicker';
  import {id, en} from 'vuejs-datepicker/dist/locale'
  import moment from 'moment'
  
  export default {
    components: {
      Datepicker
    },
    props: {
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
        if(this.selected_maintenance.descripton !== '' && this.selected_maintenance.name !== '' /*&& this.selected_maintenance.notif_date != ''*/ && this.selected_maintenance.due_date != ''){
          return true
        }
        return false
      },
      notif_max_date(){
        if(this.selected_maintenance.due_date != ''){
          return new Date(this.selected_maintenance.due_date + 1)
        }
        return 0
      },
    },
    methods: {
      submitMaintenance(){
        if(this.completed === true){
          this.loading = true

          let text = this.selected_maintenance.action == 'create_maintenance'
            ? 'Add New'
            : 'Edit'

          axios.post(window.location.origin+'/api/maintenance', this.selected_maintenance)
            .then(res => {
              this.loading = false
              
              if(res.data.success === true){
                this.$emit('success')
                this.$alert(`${text} Maintenance Success`, '', 'success')
                $('#CreateMaintenance').modal('hide');
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