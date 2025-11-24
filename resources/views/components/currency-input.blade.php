@props([
    'name' => 'amount',
    'value' => '',
    'label' => 'Amount',
    'placeholder' => '100.000',
])

<div class="grid gap-3" x-data="{
    displayValue: '{{ old($name, $value) }}',
    rawValue: '',
    format() {
        // ambil angka doang
        this.rawValue = this.displayValue.replace(/\D/g, '');

        // jika kosong biarkan kosong (hindari NaN)
        if (this.rawValue === '') {
            this.displayValue = '';
            return;
        }

        // format rupiah dengan Intl
        this.displayValue = new Intl.NumberFormat('id-ID').format(this.rawValue);
    }
}" x-init="format()">
    <label>{{ $label }}</label>

    <!-- User input (masked) -->
    <input type="text" x-model="displayValue" @input="format()" placeholder="{{ $placeholder }}" class="input w-full"
        autocomplete="off" required />

    <!-- Actual value to send -->
    <input type="hidden" name="{{ $name }}" :value="rawValue">
</div>
