<template>
  <div class="container">
    <div class="modal fade" id="CreateCar" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateCarLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateCarLabel">{{action == 'create' ? 'Add New Car' : 'Edit Car'}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <select v-model="selected_car.company_id" class="form-control">
                    <option value="0" disabled>Select Company</option>
                    <template v-if="company_data.length > 0">
                      <option v-for="item in company_data" :key="item.id" :value="item.id">{{item.name}}</option>
                    </template>
                  </select>
                  <input type="text" v-model="type" class="form-control" placeholder="Car Model/Type">
                  <input type="number" v-model="engine" class="form-control width-35" placeholder="Engine CC">
                  <input type="text" v-model="police_number" class="form-control width-65" placeholder="Police Number">
                  <!-- <select v-model="driver" class="form-control">
                    <option value="0" disabled>Select Driver</option>
                    <template v-if="driver_data.length > 0">
                      <option v-for="item in driver_data" :key="item.id" :value="item.id">{{item.name}}</option>
                    </template>
                  </select> -->
                  <datepicker v-model="lease_start" placeholder="STNK Issue Date" 
                    :language="id" input-class="input-datepicker" wrapper-class="width-50"
                  ></datepicker>
                  <datepicker v-model="lease_due" placeholder="STNK Expire Date" 
                    :language="id" input-class="input-datepicker" wrapper-class="width-50"
                  ></datepicker>
                  <input type="number" v-model="lease_price" class="form-control" placeholder="Leasing Price">
                  <select v-model="vendor" class="form-control">
                    <option value="0" disabled>Select Vendor</option>
                    <template v-if="vendor_data.length > 0">
                      <option v-for="item in vendor_data" :key="item.id" :value="item.id">{{item.name}}</option>
                    </template>
                  </select>
                  <select v-model="division" class="form-control">
                    <option value="0" disabled>Select User</option>
                    <template v-if="division_data.length > 0">
                      <option v-for="item in division_data" :key="item.id" :value="item.id">{{item.name}}</option>
                    </template>
                  </select>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" @click="submitNewCar()" class="btn btn-primary">
                {{action == 'create'
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
      action: {
        type: String
      },
      selected_car: {
        type: Object
      },
      company_data: {
        type: Array
      },
      driver_data: {
        type: Array
      },
      vendor_data: {
        type: Array
      },
      division_data: {
        type: Array
      }
    },
    data(){
      return{
        id,
        en,

        company: 0,
        type: '',
        engine: '',
        police_number: '',
        driver: 0,
        lease_start: null,
        lease_due: null,
        lease_price: '',
        vendor: 0,
        division: 0,
      }
    },
    watch: {
      selected_car: {
        handler: function(newVal, oldVal) { //console.log('triggered')
          this.company = this.selected_car.company_id
          this.type = this.selected_car.type
          this.engine = parseInt(this.selected_car.engine_cc) == 0 ? '' : parseInt(this.selected_car.engine_cc)
          this.police_number = this.selected_car.police_number
          this.driver = this.selected_car.driver_id
          this.lease_start = this.selected_car.lease_start
          this.lease_due = this.selected_car.lease_due
          this.lease_price = parseInt(this.selected_car.lease_price) == 0 ? '' : parseInt(this.selected_car.lease_price)
          this.vendor = this.selected_car.vendor_id
          this.division = this.selected_car.division_id
        },
        immediate: true,
        deep: true,
      },
    },
    computed: {
      completed(){
        if(
          this.company > 0 && this.type !== '' && parseInt(this.engine) > 0 && this.police_number !== '' && //this.driver > 0 &&
          /*this.lease_start !== '' && this.lease_due !== '' && parseInt(this.lease_price) > 0 &&*/ this.vendor > 0 && this.division > 0
        ){
          return true
        }
        return false
      }
    },
    methods: {
      submitNewCar(){
        if(this.completed === true){
          let postToCar = {
            action: `${this.action}_car`,
            id: this.selected_car.id,
            company: this.company,
            type: this.type,
            engine: parseInt(this.engine),
            police_number: this.police_number,
            driver: this.driver,
            lease_start: this.lease_start,
            lease_due: this.lease_due,
            lease_price: parseInt(this.lease_price),
            vendor: this.vendor,
            division: this.division,
          }
          
          axios.post(window.location.origin+'/api/car', postToCar)
            .then(res => {
              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Add New Car Success', '', 'success')
                $('#CreateCar').modal('hide');

                this.company = 0
                this.type = ''
                this.engine = ''
                this.police_number = ''
                this.driver = 0
                this.lease_start = null,
                this.lease_due = null,
                this.lease_price = ''
                this.vendor = 0
                this.division = 0
              }else{ //console.log(res)
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((error) => {
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
  .width{
    &-35{
      display: inline-block;
      width: 34.5%;
    }
    &-50{
      display: inline-block;
      width: 49.5%;
    }
    &-65{
      display: inline-block;
      width: 64.5%;
    }
  }
</style>