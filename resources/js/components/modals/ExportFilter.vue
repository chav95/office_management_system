<template>
  <div class="container">
    <div class="modal fade" id="ExportFilter" ref="modal" tabindex="-1" role="dialog" aria-labelledby="ExportFilterLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="ExportFilterLabel">Export Filter</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <label class="d-block text-left">Select Date Range</label>
                  <datepicker v-model="postToExport.startDate" 
                    :placeholder="`Start Date (Tanggal ${this.module == 'car_booking' ? 'booking' : this.module})`" 
                    :language="id" input-class="input-datepicker" 
                    :disabledDates="{from: new Date()}"
                  ></datepicker>
                  <datepicker v-model="postToExport.endDate" 
                    :placeholder="`End Date (Tanggal ${this.module == 'car_booking' ? 'booking' : this.module})`"
                    :language="id" input-class="input-datepicker mb-0"
                    :disabledDates="{from: new Date(), to: new Date(postToExport.startDate)}"
                  ></datepicker>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" class="btn btn-primary" @click="exportToXls()">Export</button>
              <!-- <router-link to="/car/booking-export/" :disabled="loading" class="btn btn-primary">Export To Excel</router-link> -->
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
      module: {
        type: String
      },
    },
    data(){
      return{
        id,
        en,

        postToExport: {
          module: '',
          startDate: '',
          endDate: '',
        },
        exportUrl: '',

        loading: false,
      }
    },
    computed: {
      completed(){
        if(this.postToExport.module !== '' && this.postToExport.startDate != '' && this.postToExport.endDate != ''){
          return true
        }
        return false
      },
    },
    watch: {
      module: {
        handler: function(newVal, oldVal) {
          this.postToExport.module = this.module
          this.postToExport.startDate = ''
          this.postToExport.endDate = ''
        },
        immediate: true,
        deep: true,
      },
      'postToExport.startDate'(newVal, oldVal) {
        this.postToExport.startDate = moment(String(newVal)).format('YYYY-MM-DD');
      },
      'postToExport.endDate'(newVal, oldVal) {
        this.postToExport.endDate = moment(String(newVal)).format('YYYY-MM-DD');
      },
      completed(newVal){
        // if(newVal === true){
        //   this.exportUrl = `/car/booking-export/${this.postToExport.startDate}_${this.postToExport.endDate}`
        // }
      }
    },
    methods: {
      exportToXls(){
        this.loading = true
        if(this.completed){
          axios({
            url: `${window.location.origin}/${this.module}/export/${this.postToExport.startDate}_${this.postToExport.endDate}`,
            method: 'GET',
            responseType: 'blob',
          }).then((response) => {
            let fileURL = window.URL.createObjectURL(new Blob([response.data]))
            let fileLink = document.createElement('a')

            fileLink.href = fileURL
            fileLink.setAttribute('download', `${this.module}_export.xlsx`)
            document.body.appendChild(fileLink)

            fileLink.click()
            this.loading = false
          }).catch((err) => {
            this.loading = false
            this.$alert(err, '', 'error')
          })
        }else{
          this.loading = false
          this.$alert('Please Fill All Filter Information', '', 'error')
        }
      },
    }
  }
</script>

<style lang="scss" scoped>

</style>