<template>
  <div class="container">
    <div class="modal fade" id="CreateEmployee" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateEmployeeLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateEmployeeLabel">{{selected_employee.action == 'create' ? 'Add New' : 'Edit'}} Employee</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <div class="row">
                    <div class="col-6 section">
                      <label for="name">Nama</label>
                      <input type="text" v-model="employee.name" class="form-control" id="name"  placeholder="Wajib Diisi">
                      <label for="name">NIK</label>
                      <input type="text" v-model="employee.nik" class="form-control" id="nik"  placeholder="Wajib Diisi">
                    </div>
                    <div class="col-6 section">
                      <label for="name">Tanggal Masuk</label>
                      <datepicker v-model="employee.entry_date" placeholder= "Wajib Diisi" 
                        :language="id" input-class="input-datepicker" wrapper-class="datepicer-div"
                      ></datepicker>
                      <label for="name">NPWP</label>
                      <input type="text" v-model="employee.npwp" class="form-control" id="npwp">
                    </div>
                  </div>
                  <hr class="header-line-bot">

                  <div class="row">
                    <div class="col-6 section">
                      <label for="name">Gaji Tunjangan</label>
                      <input type="text" v-model="employee.gaji_tunjangan" class="form-control" id="gaji_tunjangan">
                      <label for="name">Terima PPh</label>
                      <input type="text" v-model="employee.terima_pph" class="form-control" id="terima_pph">
                      <label for="name">Total Terima Lain</label>
                      <input type="text" v-model="employee.total_terima_lain" class="form-control" id="total_terima_lain">
                    </div>
                    <div class="col-6 section">
                      <label for="name">Total Potongan PPh</label>
                      <input type="text" v-model="employee.total_potongan_pph" class="form-control" id="total_potongan_pph">
                      <label for="name">Total Potongan Lain</label>
                      <input type="text" v-model="employee.total_potongan_lain" class="form-control" id="total_potongan_lain"  placeholder="Employee Total Potongan Lain">
                    </div>
                  </div>
                  <hr class="header-line-bot">
                  
                  <div class="row">
                    <div class="col-6 section">
                      <label for="name">Jumlah Penerimaan</label>
                      <input type="text" v-model="employee.jumlah_penerimaan" class="form-control" id="jumlah_penerimaan">
                    </div>
                    <div class="col-6 section">
                      <label for="name">Jumlah Potongan</label>
                      <input type="text" v-model="employee.jumlah_potongan" class="form-control" id="jumlah_potongan">
                    </div>
                  </div>
                  <hr class="header-line-bot">
                  
                  <div class="row">
                    <div class="col-6 section">
                      <label for="name">Penerimaan</label>
                      <input type="text" v-model="employee.penerimaan" class="form-control" id="penerimaan">
                    </div>
                    <div class="col-6 section">
                      <label for="name">Pengurang</label>
                      <input type="text" v-model="employee.pengurang" class="form-control" id="pengurang">
                    </div>
                  </div>
                  <hr class="header-line-bot">
                  
                  <label for="name">Penerimaan Bersih</label>
                  <input type="text" v-model="employee.penerimaan_bersih" class="form-control" id="penerimaan_bersih">
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" @click="submitNewEmployee()" class="btn btn-primary">{{employee.action == 'create' ? 'Submit' : 'Edit'}}</button>
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
      selected_employee: {
        type: Object
      },
    },
    data(){
      return{
        id,
        en,

        employee: {
          action: ``,
          id: 0,
          nik: '',
          name: '',
          npwp: '',
          entry_date: '',
          gaji_tunjangan: 0,
          terima_pph: 0,
          total_terima_lain: 0,
          total_potongan_lain: 0,
          total_potongan_pph: 0,
          jumlah_penerimaan: 0,
          jumlah_potongan: 0,
          penerimaan_bersih: 0,
          pengurang: 0,
          penerimaan: 0,
        }
      }
    },
    watch: {
      selected_employee: {
        handler: function(newVal, oldVal) {
          this.employee.action = this.selected_employee.action
          this.employee.id = this.selected_employee.id
          this.employee.nik = this.selected_employee.nik
          this.employee.name = this.selected_employee.name
          this.employee.npwp = this.selected_employee.npwp
          this.employee.entry_date = this.selected_employee.entry_date
          this.employee.gaji_tunjangan = this.selected_employee.gaji_tunjangan
          this.employee.terima_pph = this.selected_employee.terima_pph
          this.employee.total_terima_lain = this.selected_employee.total_terima_lain
          this.employee.total_potongan_lain = this.selected_employee.total_potongan_lain
          this.employee.total_potongan_pph = this.selected_employee.total_potongan_pph
          this.employee.jumlah_penerimaan = this.selected_employee.jumlah_penerimaan
          this.employee.jumlah_potongan = this.selected_employee.jumlah_potongan
          this.employee.penerimaan_bersih = this.selected_employee.penerimaan_bersih
          this.employee.pengurang = this.selected_employee.pengurang
          this.employee.penerimaan = this.selected_employee.penerimaan
        },
        immediate: true,
        deep: true,
      },
    },
    computed: {
      must_be_filled(){
        if(this.employee.nik != '' && this.employee.name != '' && this.employee.entry_date != ''){
          return true
        }
        return false
      }
    },
    methods: {
      submitNewEmployee(){
        if(this.must_be_filled === true){
          axios.post(window.location.origin+'/api/employee', this.employee)
            .then(res => {
              if(res.data.success === true){
                this.$emit('success')
                this.$alert(`${this.employee.action == 'create' ? 'Add New' : "Edit"} Employee Success`, '', 'success')
                $('#CreateEmployee').modal('hide');
              }else{
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((err) => { //console.log(err.response)
              const error = Object.values(err.response.data.errors)

              let message = `Error: ${error.join(', ')}`
              this.$alert(message, '', 'error')
            });
        }else{
          this.$alert('NIK, Nama, Tanggal Masuk harus diisi', '', 'error');
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  label{
    margin-bottom: 0;
  }
  .header-line-bot{
    border-bottom: 1px solid #212529;
  }
</style>