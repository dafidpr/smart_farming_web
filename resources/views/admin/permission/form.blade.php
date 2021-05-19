<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Tambah Permission Baru</h5>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <form action="" method="post" id="formSubmit">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="">Nama Permission <span class="text-danger">*</span></label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-shield-star"></em>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="Nama Permission" autocomplete="off">
                                        </div>
                                        <i class="text-danger small d-none" id="permissionNameErr"></i>
                                    </div>
                                    <div class="form-group d-inline-block mr-5">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" name="permission[]" value="create" class="custom-control-input " id="create">
                                            <label class="custom-control-label" for="create">Create</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline-block mr-5">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" name="permission[]" value="read" class="custom-control-input " id="read">
                                            <label class="custom-control-label" for="read">Read</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline-block mr-5">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" name="permission[]" value="update" class="custom-control-input " id="update">
                                            <label class="custom-control-label" for="update">Update</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline-block mr-5">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" name="permission[]" value="delete" class="custom-control-input " id="delete">
                                            <label class="custom-control-label" for="delete">Delete</label>
                                        </div>
                                    </div>
                                    <i class="text-danger small d-none" id="permissionErr"></i>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-primary"><em class="icon ni ni-send"></em><span> Save changes </span> </button>
                                        </li>
                                        <li>
                                            <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->