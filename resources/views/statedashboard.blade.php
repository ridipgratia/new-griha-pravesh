<x-app-layout>
@section('extracss')

    <!--- put extra css here -->
@endsection
  <div class="d-flex border col-12 justify-content-center p-3">
    <a href="/state_show_all_data" class="p-3 bg-primary text-white">Show Data</a>
    {{-- <a href="" class="bg-success p-3 text-white border">Show Data</a> --}}
  </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row justify-content-center">
                <div class="col-md-5 table-responsive" style="max-height: 120vh;">
                  <table class="table table-striped" style="overflow:scroll">
                    <tr class="bg-primary">
                        <td><strong class="text-white h5">District</td></strong>
                        <td><strong class="text-white h5">Completed</td></strong>
                        <td><strong class="text-white h5">Pending</td></strong>
                    </tr>
                    <tbody>
                    @php 
                    for($i=0;$i < sizeof($district);$i++){
                    @endphp
                    <tr>
                        <td>{{ $district[$i]->name }}</td>
                        <td>{{ $district[$i]->completed }}</td>
                        <td>{{ $district[$i]->pending }}</td>
                    </tr>
                    @php 
                    }
                    @endphp
                    </tbody>
                  </table>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- <a href="{{ route('viewDatadistrict') }}"> -->
                            <div class="card bg-primary text-white" style="aspact-ratio:1; height:200px;display:flex;justify-content:center;align-items:center">
                                <h1 class="display-5">{{ $total }}</h1>
                                <h2>Total beneficiary</h1>
                            </div>
                            <!-- </a> -->
                        </div>
                        <div class="col-md-4">
                            <!-- <a href="{{ route('viewDatadistrict') }}"> -->
                            <div class="card bg-success text-white" style="aspact-ratio:1; height:200px;display:flex;justify-content:center;align-items:center">
                                <h1 class="display-5">{{ $completed }}</h1>
                                <h2>Completed</h1>
                            </div>
                            <!-- </a> -->
                        </div>
                        <div class="col-md-4">
                            <!-- <a href="{{ route('viewDatadistrict') }}"> -->
                            <div class="card bg-warning text-white" style="aspact-ratio:1; height:200px;display:flex;justify-content:center;align-items:center">
                                <h1 class="display-5">{{ $pending }}</h1>
                                <h2>Pending</h1>
                            </div>
                            <!-- </a> -->
                        </div>
                        <div class="col-md-10 my-4" style="margin:auto;">
                            <canvas id="myChart" style="width:100%;max-height:100vh"></canvas>
                        </div>
                    </div>
                </div>
                
            </div>


            

        </div>
    </div>
      
    @section('extrajs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  const data = {
  labels: [
    'Completed',
    'Pending',
  ],
  datasets: [{
    label: 'Pi chart for beneficiary data',
    data: [{{ $completed }}, {{ $pending}}],
    backgroundColor: [
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
    ],
    hoverOffset: 4
  }]
};

  const config = {
    type: 'doughnut',
    data: data,
  };

  

  new Chart(ctx, config);
</script>
    @endsection
    

</x-app-layout>

