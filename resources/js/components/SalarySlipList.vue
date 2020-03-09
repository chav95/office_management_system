<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <!-- <create-modal model_title="New Document"></create-modal> -->
          <div class="card-header">
            <h3 class="card-title"><strong>Salary Slip List</strong></h3>
            <!-- <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateModel">New Document</button> -->
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>Position</th>
                  <th>Masa Kerja Efektif</th>
                  <th>Employee Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <router-link to="/hrd/salary-slip/1">Budi Suharjo</router-link>
                  </td>
                  <td>Assisten Manager Marketing</td>
                  <td>4 Tahun 2 Bulan</td>
                  <td>Karyawan Perbantuan</td>
                  <td>
                    <div>
                      <a class="modify-btn" title="Edit Slip">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem('Budi Suharjo')" title="Delete Slip">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <router-link to="/hrd/salary-slip/2">Stefani</router-link>
                  </td>
                  <td>Product Manager</td>
                  <td>5 Tahun 11 Bulan</td>
                  <td>Karyawan Perbantuan</td>
                  <td>
                    <div>
                      <a class="modify-btn" title="Edit Slip">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem('Stefani')" title="Delete Slip">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                </tr>
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

  export default {
    components: {
      CreateModal,
    },
    data(){
      return{
        
      }
    },
    methods:{
      deleteItem(name){
        this.$confirm(`Delete Salary Slip ${name}?`, '', 'question')
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
      
    }
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }
</style>