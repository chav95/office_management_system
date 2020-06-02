<template>
<div class="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                Salary Slip Details
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
            <!-- Main content -->
            <div class="doc-container p-3 mb-3">

            <!-- <template v-if="$route.params.id == 1"> -->
              <div class="row">
                <div class="col-12" style="font-size: 1.15em">
                  <h4><strong>Rincian Penghasilan Karyawan</strong></h4>
                  <h4 class="periode"><small>Bulan: <strong>Februari 2020</strong></small></h4>
                  <h5 style="margin-bottom: 0">
                    Unit Kerja: <strong>Marketing</strong>
                    <span style="float: right">Pembayaran: <strong>Bank Mandiri</strong></span>
                  </h5>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <hr class="header-line-top">
              <div class="row doc-header">
                <div class="col-sm-3 doc-col">
                  NIK - Nama <span style="float: right">:</span><br>
                  Jabatan <span style="float: right">:</span><br>
                  Nomor Pokok Wajib Pajak <span style="float: right">:</span><br>
                </div>
                <!-- /.col -->
                <div class="col-sm-9 doc-col">
                  <strong>10123 - Budi Saharjo</strong> <br>
                  <strong>Assisten Manager Marketing</strong> <br>
                  <strong>51.821.003.9-021.627</strong> <br>
                </div>
              </div>

              <div class="row doc-header doc-info">
                <div class="col-sm-3 doc-col">
                  Tanggal Masuk Bekerja <span style="float: right">:</span><br>
                  Masa Kerja Efektif <span style="float: right">:</span><br>
                </div>
                <div class="col-sm-3 doc-col">
                  <strong>01-Jan-2015</strong> <br>
                  <strong>4 Tahun 2 Bulan</strong> <br>
                </div>

                <div class="col-sm-3 doc-col">
                  Status Karyawan <span style="float: right">:</span><br>
                  Status Keluarga <span style="float: right">:</span><br>
                </div>
                <div class="col-sm-3 doc-col">
                  <strong>Karyawan Perbantuan</strong> <br>
                  <strong>K/1</strong> <br>
                </div>
              </div>
              <hr class="header-line-bot">
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="section-container">
                  <div class="col-6 section">
                    <h5><strong>I. Penerimaan</strong></h5>

                    <h6><strong>Gaji</strong></h6>
                    <div class="col-5 section-left">
                      1. Gaji <span style="float: right">:</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>Subtotal :</strong></span><br>
                    </div>
                    <div class="col-5 section-right">
                      <span style="float: right">5.352.838</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>5.352.838</strong></span><br>
                    </div>
                    
                    <h6><strong>Tunjangan</strong></h6>
                    <div class="col-5 section-left">
                      1. Tunjangan Jabatan <span style="float: right">:</span><br>
                      2. Tunjangan Fungsional <span style="float: right">:</span><br>
                      3. Tunjangan Lainnya <span style="float: right">:</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>Subtotal :</strong></span><br>
                      <span style="float: right"><strong>Jumlah Penghasilan :</strong></span><br>
                    </div>
                    <div class="col-5 section-right">
                      <span style="float: right">0</span><br>
                      <span style="float: right">1.300.000</span><br>
                      <span style="float: right">0</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>1.300.000</strong></span><br>
                      <span style="float: right"><strong>6.652.838</strong></span><br>
                    </div>
                    
                    <h6><strong>Umum</strong></h6>
                    <div class="col-5 section-left">
                      1. Tunjangan PPh 21 <span style="float: right">:</span><br>
                      <ul>
                        <li><small>Penghasilan Tetap</small></li>
                        <li><small>Penghasilan Tidak Tetap</small></li>
                      </ul>
                      2. Jamsostek => 4,54%<span style="float: right">:</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>Subtotal :</strong></span><br>
                    </div>
                    <div class="col-5 section-right">
                      <span style="float: right">-</span><br>
                      <ul>
                        <li>31.150</li>
                        <li>17.012</li>
                      </ul>
                      <span style="float: right">0</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>48.162</strong></span><br>
                    </div>
                  </div>

                  <div class="col-6 section">
                    <h5><strong>II. Potongan</strong></h5>

                    <h6><strong>Umum</strong></h6>
                    <div class="col-5 section-left">
                      1. Potongan Kehadiran <span style="float: right">:</span><br>
                      2. PPh 21 <span style="float: right">:</span><br>
                      <ul>
                        <li><small>Penghasilan Tetap</small></li>
                        <li><small>Penghasilan Tidak Tetap</small></li>
                      </ul>
                      3. Jamsostek <span style="float: right">:</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>Subtotal :</strong></span><br>
                    </div>
                    <div class="col-5 section-right">
                      <span style="float: right">0</span><br>
                      <span style="float: right">-</span><br>
                      <ul>
                        <li>31.150</li>
                        <li>0</li>
                      </ul>
                      <span style="float: right">0</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>31.150</strong></span><br>
                    </div>
                  </div>
                </div>
              </div> <!--row-->

              <div class="row">
                <div class="col-12 total-container">
                  <div class="section-container total">
                    <div class="col-6 section">
                      <div class="col-5 section-left">
                        <strong>Lain-lain</strong> <span style="float: right">:</span> <br>
                      </div>
                      
                      <div class="col-5 section-right">
                        <strong><span style="float: right">450.000</span></strong> <br>
                      </div>
                    </div>

                    <div class="col-6 section">
                      <div class="col-5 section-left">
                        <strong>Lain-lain</strong> <span style="float: right">:</span> <br>
                      </div>
                      <div class="col-5 section-right">
                        <strong><span style="float: right">319.850</span></strong> <br>
                      </div>
                    </div>
                  </div>

                  <div class="section-container total">
                    <hr class="header-line-top thin-margin">
                    <div class="col-6 section">
                      <div class="col-5 section-left">
                        <strong>Total Penerimaan</strong> <span style="float: right">:</span> <br>
                      </div>
                      
                      <div class="col-5 section-right">
                        <strong><span style="float: right">7.150.000</span></strong> <br>
                      </div>
                    </div>

                    <div class="col-6 section">
                      <div class="col-5 section-left">
                        <strong>Total Potongan</strong> <span style="float: right">:</span> <br>
                      </div>
                      <div class="col-5 section-right">
                        <strong><span style="float: right">350.000</span></strong> <br>
                      </div>
                    </div>
                    <hr class="header-line-bot thin-margin">
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <div class="section-container">
                  <div class="col-8">
                    <h5><strong>III. Koreksi PPh 21</strong></h5>
                    <div class="col-4 section-left">
                      - Penghasilan Tetap <span style="float: right">:</span><br>
                      - Penghasilan Tidak Tetap <span style="float: right">:</span><br>
                    </div>
                    <div class="col-4 section-right" style="padding-right: 5px">
                      <span style="float: right">0</span><br>
                      <span style="float: right">0</span><br>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="font-size: .8em">
                <div class="section-container total-container">
                  <div class="col-12 total">
                    <hr class="header-line-top thin-margin">
                    <div class="col-3 section-left">
                      <h5 style="margin-left: 0; margin-top: 8px"><strong>IV. Penerimaan Bersih</strong></h5>
                    </div>
                    <div class="col-2 section-right">
                      <h5 style="text-align: right; margin-top: 8px"><strong>6.800.000</strong></h5>
                    </div>
                    <hr class="header-line-bot thin-margin">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="section-container">
                  <div class="col-12">
                    <h5 style="margin-bottom: 2px;"><strong>Keterangan :</strong></h5>
                    <ul style="font-size: 1.05em">
                      <li>PPh 21 adalah jumlah pajak yang harusnya disetor ke kantor pajak</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="row" style="font-size: .8em; text-align: center">
                <div class="section-container total-container">
                  <div class="col-12 total table-responsive">
                    <table class="table table-striped" style="font-size: 1.3em">
                      <thead class="thead-dark" style="border: 1px solid black">
                        <tr>
                          <th style="border: 1px solid black" colspan="3">Rincian Penerimaan Lain-lain</th>
                          <th style="border: 1px solid black" colspan="3">Rincian Potongan Lain-lain</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="border: 1px solid black">
                          <td style="text-align: right">1</td>
                          <td style="text-align: left">Rapel Kenaikan Gaji</td>
                          <td style="text-align: right">450.000</td>
                          <td style="text-align: right;  border-left: 1px solid black">1</td>
                          <td style="text-align: left">Iuran Dapen JM</td>
                          <td style="text-align: right">319.850</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

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
            <!-- </template> -->
            </div>
          </div><!-- /.col -->
        </div>
      </div>
    </section>
</div>
</template>

<script>
  export default{
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

<style lang="scss" scoped>
  .doc-container{
    background: #fff;
    border: 1px solid rgba(0,0,0,.125);
    position: relative;
  }

  h4{
    text-align: center;
    margin-bottom: 0;
  }

  h5, h6{
    margin-left: 20px;
    text-align: left;
  }
  h6{
    margin-bottom: 0px;
    padding: 0 25px;
  }

  .row{
    .doc-header{
      padding: 5px;
    }
    .doc-info{
      margin-bottom: 12px;
    }
  }

  .col-6 > .col-6, .col-6 > .col-5{
    display: inline-block;
  }

  .header-line-top{
    border-bottom: 2px solid #212529;
  }
  .header-line-bot{
    border-bottom: 2px solid #212529;
  }
  .header-line-top.thin-margin, .header-line-bot.thin-margin{
    margin: 0;
  }

  .section-container{
    width: 100%;

    .total{
      margin: 12px 0;
    }
  }
  .total div{
    margin: 0;
  }

  .total-container{
    margin-bottom: 20px;
  }

  .section{
    display: inline-block;
    vertical-align: top;
    text-align: center;
    margin-top: 10px;
    max-width: 49.5%;
    padding: 0 10px;
  }

  .section-left{
    text-align: left;
  }
  .section-left, .section-right{
    display: inline-block;
    vertical-align: top;
    margin-bottom: 15px;
    font-size: .95em;

    ul{
      margin: 0;
      padding-left: 8px;
      list-style-type: none;
    }
  }
  .section-right{
    text-align: right;
  }

  .section-line{
    border-top: 1px solid #212529;
    margin: 5px 0;
  }

  .rincian{
    width: 800px;
    max-width: 49%;
    padding: 0 10px;
  }
  .v-line{
    width: 5px;
    height: 150px;
    border-right: 1px solid #212529;
    display: inline-block
  }
</style>