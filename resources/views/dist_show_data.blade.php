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

        img[data-action="zoom"] {
  cursor: pointer;
  cursor: -webkit-zoom-in;
  cursor: -moz-zoom-in;
}
.zoom-img,
.zoom-img-wrap {
  position: relative;
  z-index: 666;
  -webkit-transition: all 300ms;
       -o-transition: all 300ms;
          transition: all 300ms;
}
img.zoom-img {
  cursor: pointer;
  cursor: -webkit-zoom-out;
  cursor: -moz-zoom-out;
}
.zoom-overlay {
  z-index: 420;
  background: #fff;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  pointer-events: none;
  filter: "alpha(opacity=0)";
  opacity: 0;
  -webkit-transition:      opacity 300ms;
       -o-transition:      opacity 300ms;
          transition:      opacity 300ms;
}
.zoom-overlay-open .zoom-overlay {
  filter: "alpha(opacity=100)";
  opacity: 1;
}
    </style>
    @endsection
   
    @section('content')
    <div class="d-flex">
        {{-- <form action="{{ route('viewfiltereddata') }}" method="post" class="flex_div user_upload_form py-4" id="filtergp"> --}}
            {{-- @csrf --}}
               <div class="flex_div user_upload_form py-4" id="filtergp">
                <div class="col-4 text-center">
                  <h5 class="text-white">District Name :  </h5>
                  <select name="GP_name" style="width:50%;margin-left:20px">
                      <option disabled selected>Select District</option>
                      @foreach($dist as $d)
                      <option id="selectDist" value="{{$d->id}}">{{$d->name}}</option>
                      @endforeach
                  </select>
                 </div>
                 <div class="col-4 text-center">
                  <h5 class="text-white">Block Name :  </h5>
                  <select name="GP_name" style="width:50%;margin-left:20px">
                      <option disabled selected>Select Block</option>
                      
                  </select>
                 </div>
                 <div class="col-4 text-center">
                  <h5 class="text-white">GP Name :  </h5>
                  <select name="GP_name" style="width:50%;margin-left:20px">
                      <option disabled selected>Select GP</option>
                   
                  </select>
                 </div>

               </div>
        {{-- </form> --}}
    </div>
   
    <!-- <div class="d-flex my-2 justify-content-center">
         //$beneficiaries->links() }}
    </div> -->
    
    <div class="container">
    <div class="table-responsive">
    <div class="row">
    <div class="col-md-12">
    <div class="card bg-light p-4">
      <h1 class="h3 my-4">List of Beneficiaries </h1>
      <table id="example" class="display" style="width:100%;">
        <thead>
            <tr>
                <td>SL No</td>
                <!-- <td>Record Id</td> -->
                <td>Beneficiary ID</td>
                <td>Beneficiary Name</td>
                
                <td>GP</td>
                <td>Block</td>
                <!-- <td>District</td> -->
                <!-- <td>Photo 1</td>
                <td>Photo 2</td> -->
                <td>View Details</td>
            </tr>
        </thead>
        <tbody>
        {{-- @php 
            for($i=0;$i<sizeof($beneficiaries);$i++){
            if(isset($page_id)){
                $index = ($page_id-1) * 15 ;
                $j = $index + $i +1;
            }
            else{
                $j = $i +1;
            }
        @endphp

            <tr>
                <td>{{$j}}</td>
                <!-- <td>{{$beneficiaries[$i]->record_id}}</td> -->
                <td>{{$beneficiaries[$i]->b_id}}</td>
                <td>{{$beneficiaries[$i]->b_name}}</td>

                <td>{{$beneficiaries[$i]->gp_name}}</td>
                <td>{{$beneficiaries[$i]->block_name}}</td>
                <td><a href="#" onclick="uploadModal({{$beneficiaries[$i]->record_id}})"><i class="fa fa-eye"></i></a></td>
            </tr>
        @php
        }
        @endphp --}}
            
        </tbody>
       
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
                    <h3 class="modal-title">Beneficiary Details</h3>
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
                            
                        </tr>
                        <h4 class="mb-2">Basic Details</h4>
                    </table>
                    </div>
                    <h4 class="my-2">Uploaded Photos</h4>
                        <div class="row my-2 mb-4 d-flex justify-content-center">
                            <div class="col-md-6">
                                <img src="/images/default.jpeg" class="output" alt="photo" id="photo1" data-action="zoom">
                            </div>
                            <div class="col-md-6">
                                <img src="/images/default.jpeg" class="output" alt="photo" id="photo2" data-action="zoom">
                            </div>
                        </div>

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

                let fetchRes = fetch("{{ route('findUserdataOneview') }}",options);
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
                        $('#photo1').attr("src", json.p1);
                        $('#photo2').attr("src", json.p2);
                        // $("#photo2").src(json.photo2);
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

            new DataTable('#example');
        </script>

        <script>
            +function ($) { "use strict";

/**
 * The zoom service
 */
function ZoomService () {
  this._activeZoom            =
  this._initialScrollPosition =
  this._initialTouchPosition  =
  this._touchMoveListener     = null

  this._$document = $(document)
  this._$window   = $(window)
  this._$body     = $(document.body)
}

ZoomService.prototype.listen = function () {
  this._$body.on('click', '[data-action="zoom"]', $.proxy(this._zoom, this))
}

ZoomService.prototype._zoom = function (e) {
  var target = e.target

  if (!target || target.tagName != 'IMG') return

  if (this._$body.hasClass('zoom-overlay-open')) return

  if (e.metaKey) return window.open(e.target.src, '_blank')

  if (target.width >= (window.innerWidth - Zoom.OFFSET)) return

  this._activeZoomClose(true)

  this._activeZoom = new Zoom(target)
  this._activeZoom.zoomImage()

  // todo(fat): probably worth throttling this
  this._$window.on('scroll.zoom', $.proxy(this._scrollHandler, this))

  this._$document.on('click.zoom', $.proxy(this._clickHandler, this))
  this._$document.on('keyup.zoom', $.proxy(this._keyHandler, this))
  this._$document.on('touchstart.zoom', $.proxy(this._touchStart, this))

  e.stopPropagation()
}

ZoomService.prototype._activeZoomClose = function (forceDispose) {
  if (!this._activeZoom) return

  if (forceDispose) {
    this._activeZoom.dispose()
  } else {
    this._activeZoom.close()
  }

  this._$window.off('.zoom')
  this._$document.off('.zoom')

  this._activeZoom = null
}

ZoomService.prototype._scrollHandler = function (e) {
  if (this._initialScrollPosition === null) this._initialScrollPosition = window.scrollY
  var deltaY = this._initialScrollPosition - window.scrollY
  if (Math.abs(deltaY) >= 40) this._activeZoomClose()
}

ZoomService.prototype._keyHandler = function (e) {
  if (e.keyCode == 27) this._activeZoomClose()
}

ZoomService.prototype._clickHandler = function (e) {
  e.stopPropagation()
  e.preventDefault()
  this._activeZoomClose()
}

ZoomService.prototype._touchStart = function (e) {
  this._initialTouchPosition = e.touches[0].pageY
  $(e.target).on('touchmove.zoom', $.proxy(this._touchMove, this))
}

ZoomService.prototype._touchMove = function (e) {
  if (Math.abs(e.touches[0].pageY - this._initialTouchPosition) > 10) {
    this._activeZoomClose()
    $(e.target).off('touchmove.zoom')
  }
}


/**
 * The zoom object
 */
function Zoom (img) {
  this._fullHeight      =
  this._fullWidth       =
  this._overlay         =
  this._targetImageWrap = null

  this._targetImage = img

  this._$body = $(document.body)
}

Zoom.OFFSET = 80
Zoom._MAX_WIDTH = 2560
Zoom._MAX_HEIGHT = 4096

Zoom.prototype.zoomImage = function () {
  var img = document.createElement('img')
  img.onload = $.proxy(function () {
    this._fullHeight = Number(img.height)
    this._fullWidth = Number(img.width)
    this._zoomOriginal()
  }, this)
  img.src = this._targetImage.src
}

Zoom.prototype._zoomOriginal = function () {
  this._targetImageWrap           = document.createElement('div')
  this._targetImageWrap.className = 'zoom-img-wrap'

  this._targetImage.parentNode.insertBefore(this._targetImageWrap, this._targetImage)
  this._targetImageWrap.appendChild(this._targetImage)

  $(this._targetImage)
    .addClass('zoom-img')
    .attr('data-action', 'zoom-out')

  this._overlay           = document.createElement('div')
  this._overlay.className = 'zoom-overlay'

  document.body.appendChild(this._overlay)

  this._calculateZoom()
  this._triggerAnimation()
}

Zoom.prototype._calculateZoom = function () {
  this._targetImage.offsetWidth // repaint before animating

  var originalFullImageWidth  = this._fullWidth
  var originalFullImageHeight = this._fullHeight

  var scrollTop = window.scrollY

  var maxScaleFactor = originalFullImageWidth / this._targetImage.width

  var viewportHeight = (window.innerHeight - Zoom.OFFSET)
  var viewportWidth  = (window.innerWidth - Zoom.OFFSET)

  var imageAspectRatio    = originalFullImageWidth / originalFullImageHeight
  var viewportAspectRatio = viewportWidth / viewportHeight

  if (originalFullImageWidth < viewportWidth && originalFullImageHeight < viewportHeight) {
    this._imgScaleFactor = maxScaleFactor

  } else if (imageAspectRatio < viewportAspectRatio) {
    this._imgScaleFactor = (viewportHeight / originalFullImageHeight) * maxScaleFactor

  } else {
    this._imgScaleFactor = (viewportWidth / originalFullImageWidth) * maxScaleFactor
  }
}

Zoom.prototype._triggerAnimation = function () {
  this._targetImage.offsetWidth // repaint before animating

  var imageOffset = $(this._targetImage).offset()
  var scrollTop   = window.scrollY

  var viewportY = scrollTop + (window.innerHeight / 2)
  var viewportX = (window.innerWidth / 2)

  var imageCenterY = imageOffset.top + (this._targetImage.height / 2)
  var imageCenterX = imageOffset.left + (this._targetImage.width / 2)

  this._translateY = viewportY - imageCenterY
  this._translateX = viewportX - imageCenterX

  $(this._targetImage).css('transform', 'scale(' + this._imgScaleFactor + ')')
  $(this._targetImageWrap).css('transform', 'translate(' + this._translateX + 'px, ' + this._translateY + 'px) translateZ(0)')

  this._$body.addClass('zoom-overlay-open')
}

Zoom.prototype.close = function () {
  this._$body
    .removeClass('zoom-overlay-open')
    .addClass('zoom-overlay-transitioning')

  // we use setStyle here so that the correct vender prefix for transform is used
  $(this._targetImage).css('transform', '')
  $(this._targetImageWrap).css('transform', '')

  $(this._targetImage)
    .one($.support.transition.end, $.proxy(this.dispose, this))
    .emulateTransitionEnd(300)
}

Zoom.prototype.dispose = function () {
  if (this._targetImageWrap && this._targetImageWrap.parentNode) {
    $(this._targetImage)
      .removeClass('zoom-img')
      .attr('data-action', 'zoom')

    this._targetImageWrap.parentNode.replaceChild(this._targetImage, this._targetImageWrap)
    this._overlay.parentNode.removeChild(this._overlay)

    this._$body.removeClass('zoom-overlay-transitioning')
  }
}

new ZoomService().listen()

}(jQuery)
        </script>
    @endsection
 