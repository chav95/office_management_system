<template>
  <div class="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                Office Management Usage
                <button class="btn btn-default" @click="print()"><i class="fas fa-print"></i> Print</button>
            </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="col-12">
        <div class="col-md-6">
          <div class="box container-box">
            <h4>Monthly Room Bookings</h4>
            <apex-chart :options="roomBookingBar.options" :series="roomBookingBar.series">
            </apex-chart>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box container-box">
            <h4>Monthly Car Bookings</h4>
            <apex-chart :options="carBookingBar.options" :series="carBookingBar.series">
            </apex-chart>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
	import ApexChart from './reusables/Apexchart.vue';

	export default {
		components:{
			ApexChart,
		},
		data(){
			return{
				book_car_data: {},
				book_room_data: {},
				
				roomBookingBar: {
					options: {
						chart: {
							id: 'room-monthly',
							type: 'bar',
						},
						xaxis: {
							categories: ['2020/03', '2020/02', '2020/01', '2019/12', '2019/11', '2019/10']
						},
					},
					series: [{
						name: 'Room Booked',
						data: [32, 17, 14, 27, 30, 16]
					}]
				},
				carBookingBar: {
					options: {
						chart: {
							id: 'car-monthly',
							type: 'bar',
						},
						xaxis: {
							categories: ['2020/03', '2020/02', '2020/01', '2019/12', '2019/11', '2019/10']
						},
						// plotOptions: {
						// 	bar: {
						// 		horizontal: true,
						// 	}
						// },
					},
					series: [{
						name: 'Car Booked',
						data: [21, 16, 19, 18, 15, 22]
					}]
				},
			}
		},
		methods: {
			print(){
        window.print();
      }
		},
		mounted(){

		}
	}
</script>

<style scoped>
  .col-12{
    text-align: center;
  }
  .col-md-6{
    display: inline-block;
    width: 49%;
  }
	.row{
		margin: 20px 0;
	}
	.justify-content-center{
		margin-right: -15px;
		margin-left: -15px;
	}
</style>