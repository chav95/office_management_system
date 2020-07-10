<template>
  <div class="container">
    <div class="modal fade" id="CreateCarBooking" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateCarBookingLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateCarBookingLabel">{{this.postToCar.action == 'create_booking' ? 'Book A Car' : 'Edit Booking'}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <datepicker v-model="postToCar.tanggal" placeholder="Choose Booking Date" 
                    :language="id" :disabledDates="{to: new Date(new Date().setDate(new Date().getDate() - 1))}"
                    input-class="car-datepicker" wrapper-class="car-datepicker-div"
                  ></datepicker>
                  <select v-model="postToCar.jam_awal" class="form-control" style="display: inline-block; width: 194px">
                    <option disabled value="0">Hour</option>
                    <option value="9">9.00</option>
                    <option value="10">10.00</option>
                    <option value="11">11.00</option>
                    <option value="12">12.00</option>
                    <option value="13">13.00</option>
                    <option value="14">14.00</option>
                    <option value="15">15.00</option>
                    <option value="16">16.00</option>
                    <option value="17">17.00</option>
                  </select>
                  <!-- <select v-model="postToCar.jam_akhir" class="form-control" style="display: inline-block; width: 95px">
                    <option disabled value="0">Hour</option>
                    <option value="10">10.00</option>
                    <option value="11">11.00</option>
                    <option value="12">12.00</option>
                    <option value="13">13.00</option>
                    <option value="14">14.00</option>
                    <option value="15">15.00</option>
                    <option value="16">16.00</option>
                    <option value="17">17.00</option>
                    <option value="18">18.00</option>
                  </select> -->
                  <input v-model="postToCar.destination" type="text" class="form-control" placeholder="Destination"/>
                  <input v-model="postToCar.purpose" type="text" class="form-control" placeholder="Booking Purpose"/>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" @click="submitBooking()" class="btn btn-primary">
                {{loading 
                  ? 'Please Wait...' 
                  : postToCar.action == 'create_booking'
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
  import 'es6-promise/auto'
  import Form from 'vform'
  import Datepicker from 'vuejs-datepicker';
  import {id, en} from 'vuejs-datepicker/dist/locale'
  import moment from 'moment'

  export default{
    components: {
      Datepicker
    },
    props: {
      bookingItem: {
        type: Object,
      },
      carData: {
        type: Array,
        default: []
      },
      // divisionList: {
      //   type: Array,
      // },
      module: {
        type: String,
        default: ''
      }
    },
    data(){
      return{
        id,
        en,

        available_car: [],
        
        postToCar: {
          action: '',
          id: 0,
          tanggal: '',
          jam_awal: 0,
          jam_akhir: 0,
          destination: '',
          purpose: '',
          // division: 0,
          // car: 0
        },

        loading: false
      }
    },
    watch: {
      bookingItem: {
        handler: function(newVal, oldVal) {
          this.postToCar.action = this.bookingItem.action
          this.postToCar.id = this.bookingItem.id
          this.postToCar.tanggal = this.bookingItem.tanggal
          this.postToCar.jam_awal = this.bookingItem.jam_awal
          this.postToCar.jam_akhir = this.bookingItem.jam_akhir
          this.postToCar.destination = this.bookingItem.destination
          this.postToCar.purpose = this.bookingItem.purpose
        },
        immediate: true,
        deep: true,
      },
      'postToCar.tanggal'(newVal, oldVal) { //console.log(newVal)
        this.postToCar.tanggal = moment(String(newVal)).format('YYYY-MM-DD');
      },
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll');
      },
      DatetimeIntegerFormat(datetime){
        return moment(String(datetime)).format('yyyy-MM-dd');
      },
      DatetimeStringFormat(datetime){
        return moment(String(datetime)).format('ll');
      },
      submitBooking(){
        if(this.postToCar.tanggal === ''){
          this.$alert('Booking Date Cannot Be Empty', '', 'warning')
        }else if(this.postToCar.jam_awal == 0 /*|| this.postToCar.jam_akhir == 0*/){
          this.$alert('Booking Time Cannot Be Empty', '', 'warning')
        }else if(this.postToCar.destination == ''){
          this.$alert('Booking Destination Cannot Be Empty', '', 'warning')
        }else if(this.postToCar.purpose === ''){
          this.$alert('Booking Purpose Cannot Be Empty', '', 'warning')
        }else{
          this.loading = true
          
          axios.post(window.location.origin+'/api/car', this.postToCar)
            .then(res => {
              this.loading = false
              
              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Book Car Success', '', 'success')
                $('#CreateCarBooking').modal('hide');

                this.postToCar.tanggal = ''
                this.postToCar.jam_awal = 0
                this.postToCar.jam_akhir = 0
                this.postToCar.destination = ''
                this.postToCar.purpose = ''
                // this.postToCar.division = 0
                // this.postToCar.car = 0
              }else{ //console.log(res)
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((error) => {
              this.loading = false
              
              this.$alert(error, '', 'error')
            });            
        }
      },
      resetModal(){
        this.form = new Form;
      },
    },
  }
</script>

<style scoped>
  .form-group{
    text-align: center;
  }
  .form-control.half{
    display: inline-block;
    width: 231.15px;
  }

  .car-select{
    border: 2px solid cornflowerblue;
  }

  .car-select{
    border: 2px solid cornflowerblue;
  }
</style>