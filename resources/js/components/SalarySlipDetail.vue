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
                  <h4 class="periode"><small>Bulan: <strong>{{periode()}}</strong></small></h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <hr class="header-line-top">
              <div class="row doc-header">
                <div class="col-sm-3 doc-col">
                  Nama <span style="float: right">:</span><br>
                  NIK <span style="float: right">:</span><br>
                  Tanggal Masuk <span style="float: right">:</span><br>
                </div>
                <!-- /.col -->
                <div class="col-sm-9 doc-col">
                  <strong>{{employee_detail.name}}</strong> <br>
                  <strong>{{employee_detail.nik}}</strong> <br>
                  <strong>{{formatDate(employee_detail.entry_date)}}</strong> <br>
                </div>
              </div>
              <hr class="header-line-bot">
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="section-container"> 
                  <div class="col-6 section">
                    <h5><strong>Penerimaan</strong></h5>

                    <!-- <h6><strong>Penerimaan</strong></h6> -->
                    <div class="col-5 section-left">
                      Gaji <span style="float: right">:</span><br>
                      PPh 21 <span style="float: right">:</span><br>
                      Pendapatan Lainnya <span style="float: right">:</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>Jumlah Penerimaan :</strong></span><br>
                    </div>
                    <div class="col-5 section-right">
                      <span style="float: right">{{numberInThousand(employee_detail.gaji_tunjangan)}}</span><br>
                      <span style="float: right">{{numberInThousand(employee_detail.terima_pph)}}</span><br>
                      <span style="float: right">{{numberInThousand(employee_detail.total_terima_lain)}}</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>{{numberInThousand(employee_detail.jumlah_penerimaan)}}</strong></span><br>
                    </div>
                  </div>

                  <div class="col-6 section">
                    <h5><strong>Potongan</strong></h5>

                    <!-- <h6><strong>Umum</strong></h6> -->
                    <div class="col-5 section-left">
                      PPh 21 <span style="float: right">:</span><br>
                      Potongan Lainnya <span style="float: right">:</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>Jumlah Potongan :</strong></span><br>
                    </div>
                    <div class="col-5 section-right">
                      <span style="float: right">{{numberInThousand(employee_detail.total_potongan_pph)}}</span><br>
                      <span style="float: right">{{numberInThousand(employee_detail.total_potongan_lain)}}</span><br>
                      <hr class="section-line">
                      <span style="float: right"><strong>{{numberInThousand(employee_detail.jumlah_potongan)}}</strong></span><br>
                    </div>
                  </div>
                </div>
              </div> <!--row-->

              <div class="row">
                <div class="col-12 total-container">
                  <div class="section-container total">
                    <div class="col-6 section">
                      <div class="col-5 section-left">
                        <strong>Penerimaan</strong> <span style="float: right">:</span> <br>
                        <strong>Pengurangan</strong> <span style="float: right">:</span> <br>
                      </div>
                      
                      <div class="col-5 section-right">
                        <strong><span style="float: right">{{numberInThousand(employee_detail.penerimaan)}}</span></strong> <br>
                        <strong><span style="float: right">{{numberInThousand(employee_detail.pengurang)}}</span></strong> <br>
                      </div>
                    </div>
                  </div>

                  <div class="section-container total mt-4">
                    <hr class="header-line-top thin-margin mb-2">
                    <div class="col-6 section">
                      <div class="col-5 section-left">
                        <strong>Penerimaan Bersih</strong> <span style="float: right">:</span> <br>
                      </div>
                      
                      <div class="col-5 section-right">
                        <strong><span style="float: right">{{numberInThousand(employee_detail.penerimaan_bersih)}}</span></strong> <br>
                      </div>
                    </div>
                    <hr class="header-line-bot thin-margin mt-2">
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <!-- <div class="row no-print">
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
              </div> -->
            <!-- </template> -->
            </div>
          </div><!-- /.col -->
        </div>
      </div>
    </section>
</div>
</template>

<script>
  import moment from 'moment'

  export default{
    data(){
      return{
        employee_detail: {
          gaji_tunjangan: 0,
          terima_pph: 0,
          total_terima_lain: 0,
          jumlah_penerimaan: 0,
          total_potongan_pph: 0,
          total_potongan_lain: 0,
          jumlah_potongan: 0,
          penerimaan: 0,
          pengurang: 0,
          penerimaan_bersih: 0,
        },
      }
    },
    methods:{
      printDoc(){
        window.print()
      },
      formatDate(datetime){
        return moment(String(datetime)).format('LL')
      },
      periode(){
        return moment().format("MMMM YYYY")
      },
      numberInThousand(number){
        return number.toLocaleString()
      },
      
      loadEmployeeDetail(){
        axios.get(window.location.origin+'/api/employee/'+this.$route.params.id)
          .then(({data}) => {
            this.employee_detail = data
          })
      },
    },
    watch: {
      // '$route.params.playlist_id': function(playlist_id){
      //   this.loadWishlist()
      // }
    },
    mounted() {
      this.loadEmployeeDetail()
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