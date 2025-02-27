@extends('layouts.user')

@section('title', 'Dashboards')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')


<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ @$data['order_count'] }}</h3>

          <p>Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="/orders" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ @$data['shop_count'] }}</h3>

          <p>Shops</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="/shops" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ @$data['product_count'] }}</h3>

          <p>Products</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a class="small-box-footer">&nbsp;</a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ @$data['total_sell_price'] }}</h3>

            <p>Sales</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a class="small-box-footer">&nbsp;</a>
        </div>
      </div>
</div>

<div class="row">
   
      
                <div class="col-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Products
                              </h3>
                        </div>
                        <div class="card-body ">
                            <div class="chart" id="sales-chart" style="position: relative; height: 300px;">
                           <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                        </div>
                        </div>
                      </div>
                </div>
           
                <div class="col-6">

        
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sales
                          </h3>
                          
                        </div><!-- /.card-header -->
                        <div class="card-body">
                          
                            <!-- Morris chart - Sales -->
                            <div class="chart" id="revenue-chart"
                                 style="position: relative; height: 300px;">
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                             </div>
                           
                          
                        </div><!-- /.card-body -->
                      </div>
            
                </div>
       
</div>
    
        
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>


    <script> 

   
    var order       = @json(@$month_orders);
    var products    = @json(@$products);
    console.log(products);
   $(function () { 
    var myCanvas = $("#revenue-chart-canvas");
    var salesChartCanvas = myCanvas[0].getContext("2d");
   
  // $('#revenue-chart').get(0).getContext('2d');

  // $('#revenue-chart').get(0).getContext('2d');

  var salesChartData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',"Aug",'Sep','Oct','Nov',"Dec"],
    datasets: [
      {
        label: 'Digital Goods',
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data:order
      },
      
    ]
  }

  var salesChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false
        }
      }],
      yAxes: [{
        gridLines: {
          display: false
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'line',
    data: salesChartData,
    options: salesChartOptions
  })

  // Donut Chart

    var DonutCanvas = $("#sales-chart-canvas");
    var pieChartCanvas = DonutCanvas[0].getContext("2d");
  var pieData = products
//   { 
//     labels: [
//       'Instore Sales',
//       'Download Sales',
//       'Mail-Order Sales'
//     ],
//     datasets: [
//       {
//         data: [30, 12, 20],
//         backgroundColor: ['#f56954', '#00a65a', '#f39c12']
//       }
//     ]
//   }
  var pieOptions = {
    legend: {
      display: false
    },
    maintainAspectRatio: false,
    responsive: true
  }
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  // eslint-disable-next-line no-unused-vars
  var pieChart = new Chart(pieChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'doughnut',
    data: pieData,
    options: pieOptions
  })


  
});
  
    </script>
@stop