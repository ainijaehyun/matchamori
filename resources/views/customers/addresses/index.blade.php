
@extends('layouts.customers')

@section('title', 'Alamat Saya')

@section('content')
<div class="addresses-page">

    <div class="addresses-header">
        <div>
            <h1>Alamat Saya</h1>
            <p>Kelola alamat pengiriman untuk pesanan Matcha Mori.</p>
        </div>

        <a href="#" class="btn-add-address">
            + Tambah Alamat Baru
        </a>
    </div>

    <div class="addresses-card">

        <h3>Daftar Alamat</h3>

        @forelse ($addresses as $address)

            <div class="address-item">

                <div class="address-info">
                    <div class="address-name">
                        <strong>{{ $address->name }}</strong>

                        @if ($address->is_default)
                            <span class="default-badge">Alamat Utama</span>
                        @endif
                    </div>

                    <p>{{ $address->phone }}</p>
                    <p>{{ $address->address }}</p>

                    @if ($address->postal_code)
                        <p>Kode Pos: {{ $address->postal_code }}</p>
                    @endif
                </div>

                <div class="address-actions">
                    <button type="button">Ubah</button>
                    <button type="button">Hapus</button>
                </div>

            </div>

        @empty

            <div class="empty-address">
                <h3>Belum Ada Alamat</h3>
                <p>Tambahkan alamat agar pesananmu bisa dikirim.</p>
            </div>

        @endforelse

    </div>

</div>
@endsection
