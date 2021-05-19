@extends('admin.layouts.ajax')
@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                <div class="nk-block-des text-soft">
                    <p>Anda bisa membaca dan mendownload file panduan pada halaman ini.</p>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
               
                <div class="card-inner p-4">
                    <div id="accordion" class="accordion">
                        @foreach ($guides as $item)
                            <div class="accordion-item">
                                <a href="#" class="accordion-head" data-toggle="collapse" data-target="#accordion-item-{{$loop->iteration}}">
                                    <h6 class="title">{{$item->title}}</h6>
                                    <span class="accordion-icon"></span>
                                </a>
                                <div class="accordion-body collapse show" id="accordion-item-{{$loop->iteration}}" data-parent="#accordion">
                                    <div class="accordion-inner">
                                        <a href="{{ asset('admin/uploads/files/guides/'.$item->file) }}" class="btn btn-sm btn-round btn-light" target="_blank"><em class="icon ni ni-file-pdf text-danger"></em><span>{{ $item->file }} <em class="icon ni ni-download ml-2"></em></span> </a>
                                        <p class="mt-3">{{$item->description}}</p>
                                     
                                    </div>
                                </div>
                            </div>
                        @endforeach
                      </div>  
                </div><!-- .card-inner -->
            </div><!-- .card-inner-group -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>
@endsection