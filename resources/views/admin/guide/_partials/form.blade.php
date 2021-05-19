@component('admin._components.general-input')
    @slot('field', 'title')
    @slot('label', 'Title / Judul')
    @slot('placeholder', 'Masukkan nama judul')
    @slot('required', true)
@endcomponent
@component('admin._components.general-input')
    @slot('field', 'file')
    @slot('type', 'file')
    @slot('label', 'File')
    @slot('placeholder', 'Choose File')
    @slot('required', true)
@endcomponent
@component('admin._components.general-textarea')
    @slot('field', 'description')
    @slot('label', 'Deskripsi')
@endcomponent
