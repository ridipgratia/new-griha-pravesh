<x-app-layout>
    @section('extracss')
        <!--- put extra css here -->
    @endsection
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <a href="{{ route('viewData') }}">
                        <div class="card bg-primary text-white"
                            style="aspact-ratio:1; height:200px;display:flex;justify-content:center;align-items:center">
                            <h1 class="display-4">Show data 1</h1>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('uploadPhoto') }}">
                        <div class="card bg-success text-white"
                            style="aspact-ratio:1; height:200px;display:flex;justify-content:center;align-items:center">
                            <h1 class="display-4">Upload Photo</h1>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/upload-excel">
                        <div class="card bg-primary text-white"
                            style="aspact-ratio:1; height:200px;display:flex;justify-content:center;align-items:center">
                            <h1 class="display-4">Upload Excel</h1>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @section('extrajs')
        <!--- put extra js here -->
    @endsection


</x-app-layout>
