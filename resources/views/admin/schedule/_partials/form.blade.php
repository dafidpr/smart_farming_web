
@component('admin._components.general-input')
    @slot('field', 'hashid')
    @slot('label', '')
    @slot('type', 'hidden')
    @slot('required', false)
    @slot('placeholder', 'Masukkan hashid')
@endcomponent
@component('admin._components.general-input')
    @slot('field', 'start')
    @slot('label', 'Jam Mulai')
    @slot('type', 'time')
    @slot('required', true)
    @slot('placeholder', 'Masukkan jam mulai')
@endcomponent
@component('admin._components.general-input')
    @slot('field', 'end')
    @slot('label', 'Jam Selesai')
    @slot('type', 'time')
    @slot('required', true)
    @slot('placeholder', 'Masukkan jam selesai')
@endcomponent
