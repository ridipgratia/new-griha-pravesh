<x-app-layout>
    @section('extracss')
        <link rel="stylesheet" href="{{ asset('css/upload_excel.css') }}">
    @endsection
    <div class="py-12">

        <form enctype="multipart/form-data" class="d-flex flex-wrap justify-content-center main-excel-upload-form col-12"
            id="main-excel-upload-form-id">
            @csrf
            <div class="d-flex flex-wrap col-12 justify-content-center main-select-header gap-2">
                <div class="d-flex flex-wrap col-md-3 col-5 select-header-div">
                    <p class="col-12">District Code</p>
                    <select name="district_code" id="" class="col-12">
                        <option value="">{{ $district_name }}</option>
                    </select>
                </div>
                <div class="d-flex flex-wrap col-md-3 col-5 select-header-div">
                    <p class="col-12">Block Name</p>
                    <select name="district_code" id="" class="col-12">
                        <option value="" selected disabled>{{ $block_name }}</option>
                    </select>
                </div>
                <div class="d-flex flex-wrap col-md-3 col-5 select-header-div">
                    <p class="col-12">GP Name</p>
                    <select name="gp_code" id="" class="col-12">
                        <option value="" selected disabled>Select gp name</option>
                        @foreach ($all_gps as $gp_name)
                            <option value="{{ $gp_name->gp_id }}">{{ $gp_name->gp_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div
                class="d-flex flex-wrap justify-content-center align-items-center flex-column excel-form-div col-md-9 col-11">
                <h1 class="col-11">Add File</h1>
                <div
                    class="d-flex flex-wrap justify-content-center align-items-center flex-column excel-form-div-1 col-11">
                    <span><i class="fa-solid fa-cloud-arrow-up"></i></span>
                    <h1 class="col-11">Upload your excel file</h1>
                    <p class="col-11">Supproted only .xlsx</p>
                    <button type="button" id="excel_browse">Browse</button>
                    <input type="file" name="excel_file" id="excel_file" accept=".xlsx">
                    <p class="col-11">Maximun file size 10mb</p>
                </div>
                <div class="d-flex excel-form-div-2 col-11 align-items-center">
                    <span><i class="fa-solid fa-file"></i></span>
                    <span id="excel_file_name">No file selected </span>
                    <span id="excel_file_success"><i class="fa-regular fa-circle-xmark"></i></span>
                </div>
                <button type="submit" id="upload_excel_btn">Upload</button>
            </div>
        </form>

    </div>

    @section('extrajs')
        <!--- put extra js here -->
        <script type="module" src="{{ asset('js/excel_upload.js') }}"></script>
    @endsection


</x-app-layout>
