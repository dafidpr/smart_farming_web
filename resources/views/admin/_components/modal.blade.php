<div class="modal fade" tabindex="-1" role="dialog" id="{{ $id }}">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            @if (isset($form))
                {!! $form !!}
                @csrf
            @endif
            <div class="modal-body modal-body-lg">
                <h5 class="title">{{ $title ?? 'Untitled Modal' }}</h5>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <form action="" method="post" id="formSubmit">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    {!! $slot !!}
                                </div>
                                @if (!isset($withoutFooter) || !$withoutFooter)
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            @if (!isset($withoutSubmit) || !$withoutSubmit)
                                                {!! $submitBt ?? '<li><button type="submit" class="btn btn-primary"><em class="icon ni ni-send"></em><span> Simpan </span> </button></li>' !!}
                                            @endif
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">{{ $closeButtonText ?? 'Tutup' }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div><!-- .tab-pane -->
                </div>
            </div><!-- .modal-body -->
            {!! isset($form) ? '</form>' : '' !!}
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
