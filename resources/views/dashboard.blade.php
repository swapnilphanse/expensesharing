@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
<div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h5 class="card-category">Total Expenses</h5>
                            <h2 class="card-title">Amount</h2>
                        </div>
                        </div>
                </div>
                
        
<div class="card-body">
<div class="chart-area">
    <canvas id="lineChartExample"></canvas>
</div> 
</div> 
</div>
</div>
    </div>
    
   
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Expense') }}</h4>
                        </div>
                       
                    </div>
                </div>
                
                        <table id="table_id" class="table table-striped" style="width:100%">
                            <thead >
                                <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th >{{ __('Date') }}</th>
                                
                                <th >{{ __('Type') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $exp)
                                    <tr>
                                        <td><a href=" {{route('addexpense.show', $exp->expense_id) }}">{{ strtoupper($exp->ename) }}</td>
                                        <td> {{ $exp->category }} </td>
                                        <td> $ {{ number_format($exp->amount,2) }} </td>
                                        <td> {{\Carbon\Carbon::parse($exp->date)->format('M d Y') }} </td>
                                      
                                        @if($exp->paid_by == 0 )
                                        <td> YOU OWE MONEY </td>
                                        @else
                                        <td> YOU PAID THE FULL AMOUNT </td>
                                        @endif
                                       
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
            <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Category') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th >{{ __('Date') }}</th>
                                <th >{{ __('Type') }}</th>
                               
            </tr>
        </tfoot>
                        </table>
                    
                
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
    <script>
        $(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>

<script>
  gradientChartOptionsConfiguration =  {
  maintainAspectRatio: false,
  legend: {
        display: false
   },

   tooltips: {
     backgroundColor: '#fff',
     titleFontColor: '#333',
     bodyFontColor: '#666',
     bodySpacing: 4,
     xPadding: 12,
     mode: "nearest",
     intersect: 0,
     position: "nearest"
   },
   responsive: true,
   scales:{
     yAxes: [{
       barPercentage: 1.6,
           gridLines: {
             drawBorder: false,
               color: 'rgba(29,140,248,0.0)',
               zeroLineColor: "transparent",
           },
           ticks: {
            beginAtZero:true,
            suggestedMin:50,
             suggestedMax: 110,
               padding: 20,
               fontColor: "#9a9a9a"
           }
         }],

     xAxes: [{
       barPercentage: 1.6,
           gridLines: {
             drawBorder: false,
               color: 'rgba(220,53,69,0.1)',
               zeroLineColor: "transparent",
           },
           ticks: {
               padding: 20,
               fontColor: "#9a9a9a"
           }
         }]
     }
};

var ctx = document.getElementById("lineChartExample").getContext("2d");

var gradientStroke = ctx.createLinearGradient(0,230,0,50);

gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors

var data = {
  labels: ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'],
  datasets: [{
    label: "Amount",
    fill: true,
    backgroundColor: gradientStroke,
    borderColor: '#d048b6',
    borderWidth: 2,
    borderDash: [],
    borderDashOffset: 0.0,
    pointBackgroundColor: '#d048b6',
    pointBorderColor:'rgba(255,255,255,0)',
    pointHoverBackgroundColor: '#d048b6',
    pointBorderWidth: 20,
    pointHoverRadius: 4,
    pointHoverBorderWidth: 15,
    pointRadius: 4,
    data: <?php echo $record; ?>,
  }]
};

var myChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: gradientChartOptionsConfiguration
});
    </script>

@endpush
