@extends('layouts.mylayout')
    @section('extracss')
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/class.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/user_data_nav.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/user_data.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/media.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>User Data</title>
    <style>
        .output{
            max-width:100%;
            width:auto;
            max-height:150px;
            height:150px;
            margin-bottom:10px;
        }
    </style>
    @endsection
   
    @section('content')
    <div class="d-flex align-items-center mb-4">
        <form action="user_data" method="post" class="flex_div user_upload_form py-4" id="filtergp">
            @csrf
            <div>
                <h5 class="text-white">Block Name : {{ $block->block_name }}</h5>
            </div>
            <div class="d-flex col-6 justify-content-end">
               <h5 class="text-white">GP Name :  </h5>
                <select name="GP_name" onchange="searchbygp(event)" style="width:40%;margin-left:20px">
                    <option disabled selected>Select GP</option>
                    @foreach($gps as $gp)
                    <option value="{{$gp->gp_id}}" @php if(isset($gp_code) && ($gp->gp_id == $gp_code)) { echo 'selected'; } @endphp>{{$gp->gp_name}}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
   
    <div class="container">
    <div class="table-responsive">
    <div class="row">
    <div class="col-md-12">
    <div class="card bg-light p-4">
      <h1 class="h3 my-4">List of Beneficiaries </h1>
      <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <td>SL No</td>
                <!-- <td>Record Id</td> -->
                <td>Beneficiary ID</td>
                <td>Beneficiary Name</td>
                <td>GP</td>
                <td>Block</td>
                <!-- <td>District</td> -->
                <td>Upload</td>
            </tr>
        </thead>
        <tbody>
        @php 
            for($i=0;$i<sizeof($beneficiaries);$i++){
            if(isset($page_id)){
                $index = ($page_id-1) * 15 ;
                $j = $index + $i +1;
            }
            else{
                $j = $i +1;
            }
        @endphp
{{ $beneficiaries[$i]->b_id }}
            <tr>
                <td>{{$j}}</td>
                <!-- <td>{{$beneficiaries[$i]->record_id}}</td> -->
                <td>{{$beneficiaries[$i]->b_id}}</td>
                <td>{{$beneficiaries[$i]->b_name}}</td>
                <td>{{$beneficiaries[$i]->gp_name}}</td>
                <td>{{$beneficiaries[$i]->block_name}}</td>
                <!-- <td>{{$beneficiaries[$i]->district_name}}</td> -->
                <!-- <td><a href="user_file_upload/{{$beneficiaries[$i]->record_id}}"><i class="fa fa-upload"></i></a></td> -->
                <td><a href="#" onclick="uploadModal({{$beneficiaries[$i]->record_id}})"><i class="fa fa-upload"></i></a></td>
            </tr>
        @php
        }
        @endphp
            
        </tbody>
        <tfoot>
            <tr>
                <td>SL No</td>
                <!-- <td>Record Id</td> -->
                <td>Beneficiary ID</td>
                <td>Beneficiary Name</td>
                <td>GP</td>
                <td>Block</td>
                <!-- <td>District</td> -->
                <td>Upload</td>
            </tr>
        </tfoot>
    </table>
    </div>
    </div>
    </div>
    </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal">
        <div class="modal-dialog" style="max-width: 60%;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Upload Griha Pravesh Photos </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div id="record_id" style="display:none"></div>
                    <div class="table-responsive">
                    <table class="table table-bordered ">
                        <tr>
                            <td>
                                <h6>Beneficiary Name : <strong><span id="b_name"></span></strong></h6>
                            </td>
                            <td>
                                <h6>Beneficiary ID : <strong><span id="b_id"></span></strong></h6>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6>District Name : <strong><span id="district_name"></span></strong></h6>
                            </td>
                            <td>
                                <h6>Block Name : <strong><span id="block_name"></span></strong></h6>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6>GP Name : <strong><span id="gp_name"></span></strong></h6>
                            </td>
                            <td>
                                <h6>Village Name : <strong><span id="village"></span></strong></h6>
                            </td>
                        </tr>
                        <h4 class="mb-2">Beneficiary Details</h4>
                    </table>
                    </div>
                    <h4 class="my-2">Upload Photos</h4>
                    <form id="user_file_upload" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row my-2 mb-4 d-flex justify-content-center">
                            <div class="col-md-6">
                                <img src="/images/default.jpeg" class="output" alt="">
                                <input type="file" name="file_1" id="file_1" onchange="loadFile(event,0)">
                            </div>
                            <div class="col-md-6">
                                <img src="/images/default.jpeg" class="output" alt="">
                                <input type="file" name="file_2" id="file_2" onchange="loadFile(event,1)">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="upload_file" class="btn btn-primary m-auto">Upload</button>
                        </div>
                    </form>

                </div>
            
            </div>
        </div>
    </div>

    @endsection

    @section('extrajs')
        <script type="text/javascript">
            function uploadModal(id){
                // fetch data from db and set on the modal
                let options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    body: JSON.stringify({id:id})
                }

                let fetchRes = fetch("{{ route('findUserdataOne') }}",options);
                fetchRes.then(res =>
                    res.json()).then(json => {
                        // set data before opening the modal
                        $("#b_id").html(json.b_id);
                        $("#b_name").html(json.b_name);
                        $("#block_name").html(json.block_name);
                        $("#district_name").html(json.district_name);
                        $("#gp_name").html(json.gp_name);
                        $("#record_id").html(json.record_id);
                        $("#village").html(json.village);
                        console.log(json);
                        // opening the modal
                        $('#modal').modal('show')
                    })
            }

            $(document).ready(function() {
                $('#user_file_upload').on('submit', function(event) {
                    event.preventDefault();
                    var record_id = $('#record_id').html();                    
                    let form_data = new FormData($('#user_file_upload')[0]);

                    $.ajax({
                        url: "/user_file_upload/" +record_id,
                        data: form_data,
                        type: 'post',
                        contentType: false,
                        processData: false,
                        success: function(result) {
                            if (result.status == 400) {
                                Swal.fire(
                                    'Error',
                                    'Plaese Select Files!',
                                    'error'
                                );
                            } else if (result.status == 200) {

                                Swal.fire(
                                    'Done',
                                    'Successfully Uploaded !',
                                    'success'
                                ).then(function() {
                                    window.location = "/user_data";
                                });
                            }
                        },
                        error: function(data) {
                            Swal.fire(
                                'Errors!',
                                'Some Error Executed!',
                                'error'
                            );
                        }
                    });
                })
            });
            var loadFile = function(event, id) {
                var output = document.getElementsByClassName('output')[id];
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            }

            function searchbygp(e){
                // e.preventDefault();
                $('#filtergp').submit();
                // url = getdatabygp

            }

            new DataTable('#example');
        </script>
    @endsection
 