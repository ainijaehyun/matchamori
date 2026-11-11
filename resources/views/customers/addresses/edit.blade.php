
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Alamat - Matcha Mori</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-checkout.css') }}">

    <style>
        .edit-address-page {
            padding: 35px 20px;
            background: #f5f4e8;
            min-height: 80vh;
        }

        .edit-address-card {
            max-width: 1000px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .edit-address-card h2 {
            color: #304a2f;
            font-size: 24px;
            margin-bottom: 25px;
        }

        .edit-address-field {
            margin-bottom: 18px;
        }

        .edit-address-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #304a2f;
        }

        .edit-address-field input,
        .edit-address-field select,
        .edit-address-field textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d8dfd1;
            border-radius: 8px;
            background: #fff;
        }

        .edit-address-field input:focus,
        .edit-address-field select:focus,
        .edit-address-field textarea:focus {
            outline: none;
            border-color: #6b8a5d;
            box-shadow: 0 0 0 2px rgba(107,138,93,.12);
        }

        .region-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        #editAddressMap {
            width: 100%;
            height: 350px;
            border-radius: 12px;
            margin-top: 12px;
            background: #eee;
        }

        .map-search {
            display: flex;
            gap: 10px;
        }

        .map-search input {
            flex: 1;
        }

        .map-search button,
        .edit-address-button {
            background: #6b8a5d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            cursor: pointer;
        }

        .edit-address-button:hover,
        .map-search button:hover {
            background: #526f47;
        }

        .address-actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .address-actions a,
        .address-actions button {
            flex: 1;
            text-align: center;
            text-decoration: none;
            padding: 13px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
        }

        .cancel-button {
            background: #999;
            color: white;
        }

        .save-button {
            background: #6b8a5d;
            color: white;
        }

        @media (max-width: 600px) {
            .region-grid {
                grid-template-columns: 1fr;
            }

            .edit-address-card {
                padding: 20px;
            }

            .map-search {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

@include('layouts.inc.navbar')

<div class="edit-address-page">
    <div class="edit-address-card">

        <h2>
            <i class="fas fa-map-marker-alt"></i>
            Edit Alamat Pengiriman
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                Periksa kembali data alamat yang kamu masukkan.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="editAddressForm" action="{{ route('customer.addresses.update', $address->id) }}" method="POST">

            @csrf
            @method('PATCH')

            <div class="edit-address-field">
                <label for="name">Nama Penerima</label>
                <input type="text" id="name" name="name" value="{{ old('name', $address->name) }}" maxlength="100" required>
            </div>

            <div class="edit-address-field">
                <label for="phone">Nomor HP</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $address->phone) }}" maxlength="20" required>
            </div>

            <h5 style="color:#304a2f; margin:25px 0 15px;">
                <i class="fas fa-map"></i>
                Wilayah Pengiriman
            </h5>

            <div class="region-grid">

                <div class="edit-address-field">
                    <label for="province">Provinsi</label>
                    <select id="province" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>

                <div class="edit-address-field">
                    <label for="regency">Kabupaten/Kota</label>
                    <select id="regency" disabled required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                </div>

                <div class="edit-address-field">
                    <label for="district">Kecamatan</label>
                    <select id="district" disabled required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>

                <div class="edit-address-field">
                    <label for="village">Desa/Kelurahan</label>
                    <select id="village" disabled required>
                        <option value="">Pilih Desa/Kelurahan</option>
                    </select>
                </div>

            </div>

            <div class="edit-address-field">
                <label for="street_address">Detail Alamat</label>
                <textarea id="street_address" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, patokan..." required></textarea>
            </div>

            <div class="edit-address-field">
                <label for="postal_code">Kode Pos</label>
                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" maxlength="20">
            </div>

            <input type="hidden" name="address" id="full_address">

            <h5 style="color:#304a2f; margin:25px 0 15px;">
                <i class="fas fa-location-dot"></i>
                Titik Lokasi
            </h5>

            <div class="edit-address-field">
                <label for="mapSearch">Cari Lokasi</label>

                <div class="map-search">
                    <input type="text" id="mapSearch"
                           placeholder="Cari nama jalan atau tempat...">

                    <button type="button" id="searchMap">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>

                <small class="text-muted">
                    Kamu juga bisa menggeser penanda pada peta untuk menentukan lokasi.
                </small>

                <div id="editAddressMap"></div>
            </div>

            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $address->latitude) }}">

            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $address->longitude) }}">

            <div class="edit-address-field" style="margin-top:20px;">
                <label>
                    <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                    Jadikan alamat utama
                </label>
            </div>

            <div class="address-actions">
                <a href="{{ route('customer.checkout.index') }}" class="cancel-button">
                    Batal
                </a>

                <button type="submit" class="save-button">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

@include('layouts.inc.footer')

<script>
    document.addEventListener('DOMContentLoaded', async function () {

        const regionApi = 'https://www.emsifa.com/api-wilayah-indonesia/v2';

        const province = document.getElementById('province');
        const regency = document.getElementById('regency');
        const district = document.getElementById('district');
        const village = document.getElementById('village');

        const streetAddress = document.getElementById('street_address');
        const fullAddress = document.getElementById('full_address');

        // Ambil alamat lama dari database atau input sebelumnya.
        const savedAddress = @json(old('address', $address->address));

        // Pecah alamat berdasarkan koma.
        let parts = savedAddress
            .split(',')
            .map(item => item.trim())
            .filter(item => item !== '');

        // Normalisasi teks agar perbandingan tidak terpengaruh huruf besar/kecil.
        function normalizePart(value) {
            return value
                .trim()
                .replace(/\s+/g, ' ')
                .toLowerCase();
        }

        // Hapus wilayah yang berulang di bagian akhir alamat.
        // Format wilayah: Desa, Kecamatan, Kabupaten, Provinsi.
        while (parts.length >= 8) {

            const previousRegion = parts
                .slice(-8, -4)
                .map(normalizePart);

            const lastRegion = parts
                .slice(-4)
                .map(normalizePart);

            const isDuplicate = previousRegion.every(
                (item, index) => item === lastRegion[index]
            );

            if (isDuplicate) {
                parts.splice(-4, 4);
            } else {
                break;
            }
        }

        // Pisahkan detail alamat dan wilayah.
        let savedStreet = parts.join(', ');
        let savedVillage = '';
        let savedDistrict = '';
        let savedRegency = '';
        let savedProvince = '';

        if (parts.length >= 5) {
            savedStreet = parts.slice(0, -4).join(', ');
            savedVillage = parts[parts.length - 4];
            savedDistrict = parts[parts.length - 3];
            savedRegency = parts[parts.length - 2];
            savedProvince = parts[parts.length - 1];
        }

        // Tampilkan detail alamat pada textarea.
        streetAddress.value = savedStreet;

        function normalizeName(value) {
            return value
                .toLowerCase()
                .replace(/^(kabupaten administrasi|kabupaten|kota administrasi|kota)\s+/i, '')
                .replace(/[^a-z0-9]/g, '');
        }

        function findRegion(regions, name) {
            const target = normalizeName(name);

            return regions.find(item =>
                normalizeName(item.name) === target
            );
        }

        async function getRegions(url) {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Gagal mengambil data wilayah.');
            }

            const result = await response.json();

            return Array.isArray(result) ? result : result.data;
        }

        function fillSelect(select, regions, placeholder) {
            select.innerHTML = `<option value="">${placeholder}</option>`;

            regions.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                select.appendChild(option);
            });

            select.disabled = false;
        }

        try {
            // 1. Muat provinsi.
            const provinces = await getRegions(`${regionApi}/provinces.json`);

            fillSelect(province, provinces, 'Pilih Provinsi');

            const selectedProvince = findRegion(provinces, savedProvince);

            if (selectedProvince) {
                province.value = selectedProvince.id;

                // 2. Muat kabupaten/kota.
                const regencies = await getRegions(
                    `${regionApi}/regencies/${selectedProvince.id}.json`
                );

                fillSelect(regency, regencies, 'Pilih Kabupaten/Kota');

                const selectedRegency = findRegion(regencies, savedRegency);

                if (selectedRegency) {
                    regency.value = selectedRegency.id;

                    // 3. Muat kecamatan.
                    const districts = await getRegions(
                        `${regionApi}/districts/${selectedRegency.id}.json`
                    );

                    fillSelect(district, districts, 'Pilih Kecamatan');

                    const selectedDistrict = findRegion(districts, savedDistrict);

                    if (selectedDistrict) {
                        district.value = selectedDistrict.id;

                        // 4. Muat desa/kelurahan.
                        const villages = await getRegions(
                            `${regionApi}/villages/${selectedDistrict.id}.json`
                        );

                        fillSelect(village, villages, 'Pilih Desa/Kelurahan');

                        const selectedVillage = findRegion(villages, savedVillage);

                        if (selectedVillage) {
                            village.value = selectedVillage.id;
                        }
                    }
                }
            }

        } catch (error) {
            console.error(error);
            alert('Data wilayah gagal dimuat. Periksa koneksi internet lalu muat ulang halaman.');
        }

        // Ketika provinsi diganti.
        province.addEventListener('change', async function () {
            regency.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            district.innerHTML = '<option value="">Pilih Kecamatan</option>';
            village.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';

            regency.disabled = true;
            district.disabled = true;
            village.disabled = true;

            if (!this.value) return;

            try {
                const data = await getRegions(
                    `${regionApi}/regencies/${this.value}.json`
                );
                fillSelect(regency, data, 'Pilih Kabupaten/Kota');
            } catch (error) {
                console.error(error);
                alert('Kabupaten/kota gagal dimuat.');
            }
        });

        // Ketika kabupaten/kota diganti.
        regency.addEventListener('change', async function () {
            district.innerHTML = '<option value="">Pilih Kecamatan</option>';
            village.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';

            district.disabled = true;
            village.disabled = true;

            if (!this.value) return;

            try {
                const data = await getRegions(
                    `${regionApi}/districts/${this.value}.json`
                );
                fillSelect(district, data, 'Pilih Kecamatan');
            } catch (error) {
                console.error(error);
                alert('Kecamatan gagal dimuat.');
            }
        });

        // Ketika kecamatan diganti.
        district.addEventListener('change', async function () {
            village.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
            village.disabled = true;

            if (!this.value) return;

            try {
                const data = await getRegions(
                    `${regionApi}/villages/${this.value}.json`
                );
                fillSelect(village, data, 'Pilih Desa/Kelurahan');
            } catch (error) {
                console.error(error);
                alert('Desa/kelurahan gagal dimuat.');
            }
        });

        // Susun alamat lengkap ketika form disimpan.
        document.getElementById('editAddressForm').addEventListener('submit', function (event) {

            if (
                !province.value ||
                !regency.value ||
                !district.value ||
                !village.value
            ) {
                event.preventDefault();
                alert('Silakan lengkapi provinsi, kabupaten/kota, kecamatan, dan desa/kelurahan.');
                return;
            }

            const street = streetAddress.value.trim();

            const villageName = village.selectedOptions[0].textContent;
            const districtName = district.selectedOptions[0].textContent;
            const regencyName = regency.selectedOptions[0].textContent;
            const provinceName = province.selectedOptions[0].textContent;

            fullAddress.value = [
                street,
                villageName,
                districtName,
                regencyName,
                provinceName
            ].join(', ');
        });

    });
</script>

<script>
    let editMap;
    let editMarker;
    let editGeocoder;

    async function initEditAddressMap() {

        const { Map } = await google.maps.importLibrary('maps');
        const { Geocoder } = await google.maps.importLibrary('geocoding');

        editGeocoder = new Geocoder();

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const savedLat = parseFloat(latInput.value);
        const savedLng = parseFloat(lngInput.value);

        const hasSavedCoordinates =
            Number.isFinite(savedLat) && Number.isFinite(savedLng);

        const defaultPosition = hasSavedCoordinates
            ? { lat: savedLat, lng: savedLng }
            : { lat: -7.3881, lng: 109.3636 };

        editMap = new Map(document.getElementById('editAddressMap'), {
            center: defaultPosition,
            zoom: 16
        });

        editMarker = new google.maps.Marker({
            map: editMap,
            position: defaultPosition,
            draggable: true
        });

        function saveCoordinates(position) {
            latInput.value = position.lat;
            lngInput.value = position.lng;
        }

        saveCoordinates(defaultPosition);

        editMarker.addListener('dragend', function () {
            const position = editMarker.getPosition();

            saveCoordinates({
                lat: position.lat(),
                lng: position.lng()
            });
        });

        editMap.addListener('click', function (event) {
            const position = {
                lat: event.latLng.lat(),
                lng: event.latLng.lng()
            };

            editMarker.setPosition(position);
            saveCoordinates(position);
        });

        // Pencarian lokasi menggunakan Geocoder.
        document.getElementById('searchMap').addEventListener('click', function () {
            searchEditLocation();
        });

        document.getElementById('mapSearch').addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchEditLocation();
            }
        });

        async function searchEditLocation() {
            const keyword = document.getElementById('mapSearch').value.trim();

            if (!keyword) {
                alert('Masukkan nama lokasi terlebih dahulu.');
                return;
            }

            try {
                const result = await editGeocoder.geocode({
                    address: keyword,
                    region: 'id'
                });

                if (!result.results.length) {
                    alert('Lokasi tidak ditemukan.');
                    return;
                }

                const location = result.results[0].geometry.location;

                const position = {
                    lat: location.lat(),
                    lng: location.lng()
                };

                editMap.setCenter(position);
                editMap.setZoom(17);
                editMarker.setPosition(position);
                saveCoordinates(position);

            } catch (error) {
                console.error(error);
                alert('Pencarian lokasi gagal. Periksa pengaturan Google Maps API.');
            }
        }
    }
</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&loading=async&callback=initEditAddressMap">
</script>

</body>
</html>
