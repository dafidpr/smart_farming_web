@component('admin._components.general-input')
    @slot('field', 'name')
    @slot('label', 'Nama Perangkat')
    @slot('required', true)
    @slot('placeholder', 'Masukkan nama perangkat')
@endcomponent
@component('admin._components.general-input')
    @slot('field', 'serial_number')
    @slot('label', 'Serial Number')
    @slot('required', true)
    @slot('placeholder', 'Masukkan serial number')
@endcomponent
