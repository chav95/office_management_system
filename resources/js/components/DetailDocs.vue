<template>
<div class="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                Document Details
                <button class="btn btn-default" @click="printDoc()"><i class="fas fa-print"></i> Print</button>
            </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info" v-if="$route.params.id == 1">
              <h5><i class="fas fa-info"></i> Note: </h5>
              A payment for this document is due in 2 month!
            </div>


            <!-- Main content -->
            <div class="doc-container p-3 mb-3">
              <!-- title row -->
              <template v-if="$route.params.id == 1">
              <div class="row">
                <div class="col-12">
                  <h4>
                    STNK Toyota Avanza (B 5213 BMD)
                    <small class="float-right">Date: 21/5/2010</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row doc-info">
                <div class="col-sm-6 doc-col">
                  Nomor Polisi: <strong>B 5213 BMD</strong><br>
                  Nama Pemilik: <strong>Slamet Hariudin</strong><br>
                  Alamat: <strong>Jl. Padamulya RT 11 RW 2 Angke</strong><br>
                  Jenis Kendaraan: <strong>Mobil Penumpang</strong><br>
                  Tahun Pembuatan: <strong>2010</strong><br>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 doc-col">
                  Merk: <strong>Toyota</strong><br>
                  Bahan Bakar: <strong>Bensin</strong><br>
                  Isi Silinder: <strong>01329</strong><br>
                  Berlaku Sampai: <strong>21/5/2020</strong><br>
                  Biaya Perpanjangan: <strong>Rp. 200.000</strong><br>
                  Pajak Tahunan: <strong>Rp. 1.216.000</strong><br>
                </div>
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <h5>Payment History</h5>
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Completed At</th>
                        <th>Completed By</th>
                        <th>Amount Paid</th>
                      </tr>   
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2011</td>
                        <td>19 May 2011</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2012</td>
                        <td>18 May 2012</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2013</td>
                        <td>19 May 2013</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2014</td>
                        <td>8 Aug 2014</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.732.000</td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2015</td>
                        <td>20 May 2015</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>Perpanjangan STNK</td>
                        <td>21 May 2015</td>
                        <td>20 May 2015</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 200.000</td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2016</td>
                        <td>3 May 2016</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2017</td>
                        <td>10 May 2017</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                      <tr>
                        <td>9</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2018</td>
                        <td>9 May 2018</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                      <tr>
                        <td>10</td>
                        <td>Pajak Tahunan</td>
                        <td>21 May 2019</td>
                        <td>8 Aug 2019</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 1.216.000</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <button class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Document
                  </button>
                  <button @click="deleteItem('STNK Toyota Avanza (B 5213 BMD)')" class="btn btn-danger float-right">
                    <i class="fas fa-trash"></i>
                    Delete Document
                  </button>
                </div>
              </div>
            </template>

            <template v-else-if="$route.params.id == 2">
              <div class="row">
                <div class="col-12">
                  <h4>
                    STNK Daihatsu Xenia (B 5213 BMD)
                    <small class="float-right">Date: 8/9/2018</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row doc-info">
                <div class="col-sm-6 doc-col">
                  Nomor Polisi: <strong>B 5213 BMD</strong><br>
                  Nama Pemilik: <strong>Slamet Hariudin</strong><br>
                  Alamat: <strong>Jl. Padamulya RT 11 RW 2 Angke</strong><br>
                  Jenis Kendaraan: <strong>Mobil Penumpang</strong><br>
                  Tahun Pembuatan: <strong>2018</strong><br>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 doc-col">
                  Merk: <strong>Daihatsu</strong><br>
                  Bahan Bakar: <strong>Bensin</strong><br>
                  Isi Silinder: <strong>00989</strong><br>
                  Berlaku Sampai: <strong>8/9/2020</strong><br>
                  Biaya Perpanjangan: <strong>Rp. 200.000</strong><br>
                  Pajak Tahunan: <strong>Rp. 903.000</strong><br>
                </div>
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <h5>Payment History</h5>
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Due Date</th>
                        <th>Completed At</th>
                        <th>Completed By</th>
                        <th>Amount Paid</th>
                      </tr>   
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Pajak Tahunan</td>
                        <td>8 Sep 2019</td>
                        <td>24 Aug 2019</td>
                        <td>Edward Tabianto</td>
                        <td>Rp. 903.000</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <button class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Document
                  </button>
                  <button @click="deleteItem('STNK Daihatsu Xenia (B 1977 TYZ)')" class="btn btn-danger float-right">
                    <i class="fas fa-trash"></i>
                    Delete Document
                  </button>
                </div>
              </div>
            </template>
            </div>
          </div><!-- /.col -->
        </div>
      </div>
    </section>
</div>
</template>

<script>
  export default {
    data(){
      return{
        
      }
    },
    methods:{
      printDoc(){
        window.print();
      },
      deleteItem(name){
        this.$confirm(`Delete ${name}?`, '', 'question')
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
  .doc-container{
    background: #fff;
    border: 1px solid rgba(0,0,0,.125);
    position: relative;
  }
  .row .doc-info{
    padding: 5px;
    margin-bottom: 12px;
  }
</style>