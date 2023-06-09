@extends('layouts.app')

@section('title', 'Edit Penduduk')

@section('styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .upload-image:hover {
            cursor: pointer;
            opacity: 0.7;
        }
    </style>
@endsection

@section('content-header')
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
        style="background-image: url({{ asset('/img/cover-bg-profil.jpg') }}); background-size: cover; background-position: center top;">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card shadow h-100">
                        <div class="card-header border-0">
                            <div
                                class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between text-center text-md-left">
                                <div class="mb-3">
                                    <h2 class="mb-0">Edit Penduduk</h2>
                                    <p class="mb-0 text-sm">Kelola Penduduk</p>
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('penduduk.index') }}?page={{ request('page') }}"
                                        class="btn btn-success" title="Kembali"><i class="fas fa-arrow-left"></i>
                                        Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('layouts.components.alert')
    <div class="row">
        <div class="col">
            <div class="card bg-secondary shadow h-100">
                <div class="card-body">
                    <form autocomplete="off" action="{{ route('penduduk.update', $penduduk) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf @method('patch')
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group text-center">
                                    <label class="form-control-label" for="nik">Foto Penduduk</label> <br>
                                    <img onclick="$(this).siblings('.images').click()" class="mw-100 upload-image"
                                        style="max-height: 300px"
                                        src="{{ $penduduk->foto ? asset(Storage::url($penduduk->foto)) : asset('storage/upload.jpg') }}"
                                        alt="foto">
                                    <input accept="image/*" onchange="uploadImage(this)" type="file" name="foto"
                                        class="images" style="display: none">
                                    @error('foto')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-6">
                                <div class="row">
                                    <div class="form-group col-lg-4 col-md-6">
                                        <label class="form-control-label" for="nik">NIK</label>
                                        <input type="text" onkeypress="return hanyaAngka(event)"
                                            class="form-control @error('nik') is-invalid @enderror" name="nik"
                                            placeholder="Masukkan NIK ..." value="{{ old('nik', $penduduk->nik) }}">
                                        @error('nik')
                                            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-5 col-md-6">
                                        <label class="form-control-label" for="nama">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            name="nama" placeholder="Masukkan Nama ..."
                                            value="{{ old('nama', $penduduk->nama) }}">
                                        @error('nama')
                                            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label class="form-control-label" for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                            name="jenis_kelamin" id="jenis_kelamin">
                                            <option selected value="">Pilih Jenis Kelamin</option>
                                            <option value="1"
                                                {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 1 ? 'selected="true"' : '' }}>
                                                Laki-laki</option>
                                            <option value="2"
                                                {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 2 ? 'selected="true"' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <h4>Status Kepemilikan KTP</h4>
                                <div class="pl-4">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label class="form-control-label" for="ktp_elektronik">KTP Elektronik</label>
                                            <select class="form-control @error('ktp_elektronik') is-invalid @enderror"
                                                name="ktp_elektronik" id="ktp_elektronik">
                                                <option selected value="">Pilih KTP Elektronik</option>
                                                <option value="1"
                                                    {{ old('ktp_elektronik', $penduduk->ktp_elektronik) == 1 ? 'selected="true"' : '' }}>
                                                    Belum</option>
                                                <option value="2"
                                                    {{ old('ktp_elektronik', $penduduk->ktp_elektronik) == 2 ? 'selected="true"' : '' }}>
                                                    KTP-EL</option>
                                            </select>
                                            @error('ktp_elektronik')
                                                <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="form-control-label" for="status_rekam_id">Status Rekam</label>
                                            <select class="form-control @error('status_rekam_id') is-invalid @enderror"
                                                name="status_rekam_id" id="status_rekam_id">
                                                <option selected value="">Pilih Status Rekam</option>
                                                @foreach ($status_rekam as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('status_rekam_id', $penduduk->status_rekam_id) == $item->id ? 'selected="true"' : '' }}>
                                                        {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('status_rekam_id')
                                                <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-6">
                                <label class="form-control-label" for="kk">Nomor KK</label>
                                <input type="text" onkeypress="return hanyaAngka(event)"
                                    class="form-control @error('kk') is-invalid @enderror" name="kk"
                                    placeholder="Masukkan Nomor KK ..." value="{{ old('kk', $penduduk->kk) }}">
                                @error('kk')
                                    <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-6">
                                <label class="form-control-label" for="status_hubungan_dalam_keluarga_id">Status Hubungan
                                    Dalam Keluarga</label>
                                <select
                                    class="form-control @error('status_hubungan_dalam_keluarga_id') is-invalid @enderror"
                                    name="status_hubungan_dalam_keluarga_id" id="status_hubungan_dalam_keluarga_id">
                                    <option selected value="">Pilih Status Hubungan Dalam Keluarga</option>
                                    @foreach ($status_hubungan_dalam_keluarga as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('status_hubungan_dalam_keluarga_id', $penduduk->status_hubungan_dalam_keluarga_id) == $item->id ? 'selected="true"' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('status_hubungan_dalam_keluarga_id')
                                    <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-6">
                                <label class="form-control-label" for="agama_id">Agama</label>
                                <select class="form-control @error('agama_id') is-invalid @enderror" name="agama_id"
                                    id="agama_id">
                                    <option selected value="">Pilih Agama</option>
                                    @foreach ($agama as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('agama_id', $penduduk->agama_id) == $item->id ? 'selected="true"' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('agama_id')
                                    <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-6">
                                <label class="form-control-label" for="status_penduduk_id">Status Penduduk</label>
                                <select class="form-control @error('status_penduduk_id') is-invalid @enderror"
                                    name="status_penduduk_id" id="status_penduduk_id">
                                    <option selected value="">Pilih Status Penduduk</option>
                                    @foreach ($status_penduduk as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('status_penduduk_id', $penduduk->status_penduduk_id) == $item->id ? 'selected="true"' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('status_penduduk_id')
                                    <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-6">
                                <label class="form-control-label" for="etnis_atau_suku">Etnis/Suku</label>
                                <input type="text" class="form-control @error('etnis_atau_suku') is-invalid @enderror"
                                    name="etnis_atau_suku" placeholder="Masukkan Etnis/Suku ..."
                                    value="{{ old('etnis_atau_suku', $penduduk->etnis_atau_suku) }}">
                                @error('etnis_atau_suku')
                                    <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <h4>Data Kelahiran</h4>
                        <div class="pl-4">
                            <div class="row">

                                <div class="form-group col-lg-8 col-md-6">
                                    <label class="form-control-label" for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        name="tempat_lahir" placeholder="Masukkan Tempat Lahir ..."
                                        value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}">
                                    @error('tempat_lahir')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir ..."
                                        value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir) }}">
                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="tempat_dilahirkan_id">Tempat Dilahirkan</label>
                                    <select class="form-control @error('tempat_dilahirkan_id') is-invalid @enderror"
                                        name="tempat_dilahirkan_id" id="tempat_dilahirkan_id">
                                        <option selected value="">Pilih Tempat Dilahirkan</option>
                                        @foreach ($tempat_dilahirkan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('tempat_dilahirkan_id', $penduduk->tempat_dilahirkan_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('tempat_dilahirkan_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="anak_ke">Anak Ke</label>
                                    <input type="number" onkeypress="return hanyaAngka(event)"
                                        class="form-control @error('anak_ke') is-invalid @enderror" name="anak_ke"
                                        placeholder="Masukkan Anak Ke ..."
                                        value="{{ old('anak_ke', $penduduk->anak_ke) }}">
                                    @error('anak_ke')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <h4>Pendidikan Dan Pekerjaan</h4>
                        <div class="pl-4">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="pendidikan_id">Pendidikan</label>
                                    <select class="form-control @error('pendidikan_id') is-invalid @enderror"
                                        name="pendidikan_id" id="pendidikan_id">
                                        <option selected value="">Pilih Pendidikan</option>
                                        @foreach ($pendidikan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('pendidikan_id', $penduduk->pendidikan_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('pendidikan_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="pekerjaan_id">Pekerjaan</label>
                                    <select style="width: 100%;"
                                        class="form-control @error('pekerjaan_id') is-invalid @enderror"
                                        name="pekerjaan_id" id="pekerjaan_id">
                                        <option selected value="">Pilih Pekerjaan</option>
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('pekerjaan_id', $penduduk->pekerjaan_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('pekerjaan_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h4>Data Kewarganegaraan</h4>
                        <div class="pl-4">
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="kewarganegaraan">Kewarganegaraan</label>
                                    <select class="form-control @error('kewarganegaraan') is-invalid @enderror"
                                        name="kewarganegaraan" id="kewarganegaraan">
                                        <option selected value="">Pilih Kewarganegaraan</option>
                                        <option value="1"
                                            {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 1 ? 'selected="true"' : '' }}>
                                            WNI</option>
                                        <option value="2"
                                            {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 2 ? 'selected="true"' : '' }}>
                                            WNA</option>
                                        <option value="3"
                                            {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 3 ? 'selected="true"' : '' }}>
                                            Dua Kewarganegaraan</option>
                                    </select>
                                    @error('kewarganegaraan')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-8 col-md-6">
                                    <label class="form-control-label" for="nomor_paspor">Nomor Paspor</label>
                                    <input type="text"
                                        class="form-control @error('nomor_paspor') is-invalid @enderror"
                                        name="nomor_paspor" placeholder="Masukkan Nomor Paspor ..."
                                        value="{{ old('nomor_paspor', $penduduk->nomor_paspor) }}">
                                    @error('nomor_paspor')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="tgl_berakhir_paspor">Tgl Berakhir
                                        Paspor</label>
                                    <input type="date"
                                        class="form-control @error('tgl_berakhir_paspor') is-invalid @enderror"
                                        name="tgl_berakhir_paspor" placeholder="Masukkan Tgl Berakhir Paspor ..."
                                        value="{{ old('tgl_berakhir_paspor', $penduduk->tgl_berakhir_paspor) }}">
                                    @error('tgl_berakhir_paspor')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-8 col-md-6">
                                    <label class="form-control-label" for="nomor_kitas_atau_kitap">Nomor KITAS /
                                        KITAP</label>
                                    <input type="text"
                                        class="form-control @error('nomor_kitas_atau_kitap') is-invalid @enderror"
                                        name="nomor_kitas_atau_kitap" placeholder="Masukkan Nomor KITAS / KITAP ..."
                                        value="{{ old('nomor_kitas_atau_kitap', $penduduk->nomor_kitas_atau_kitap) }}">
                                    @error('nomor_kitas_atau_kitap')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h4>Data Orang Tua</h4>
                        <div class="pl-4">
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="nik_ayah">NIK Ayah</label>
                                    <input type="text" onkeypress="return hanyaAngka(event)"
                                        class="form-control @error('nik_ayah') is-invalid @enderror" name="nik_ayah"
                                        placeholder="Masukkan NIK Ayah ..."
                                        value="{{ old('nik_ayah', $penduduk->nik_ayah) }}">
                                    @error('nik_ayah')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-8 col-md-6">
                                    <label class="form-control-label" for="nama_ayah">Nama Ayah</label>
                                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                        name="nama_ayah" placeholder="Masukkan Nama Ayah ..."
                                        value="{{ old('nama_ayah', $penduduk->nama_ayah) }}">
                                    @error('nama_ayah')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="nik_ibu">NIK Ibu</label>
                                    <input type="text" onkeypress="return hanyaAngka(event)"
                                        class="form-control @error('nik_ibu') is-invalid @enderror" name="nik_ibu"
                                        placeholder="Masukkan NIK Ibu ..."
                                        value="{{ old('nik_ibu', $penduduk->nik_ibu) }}">
                                    @error('nik_ibu')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-8 col-md-6">
                                    <label class="form-control-label" for="nama_ibu">Nama Ibu</label>
                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                        name="nama_ibu" placeholder="Masukkan Nama Ibu ..."
                                        value="{{ old('nama_ibu', $penduduk->nama_ibu) }}">
                                    @error('nama_ibu')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h4>Alamat</h4>
                        <div class="pl-4">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="nomor_telepon">Nomor Telepon</label>
                                    <input type="text"
                                        class="form-control @error('nomor_telepon') is-invalid @enderror"
                                        name="nomor_telepon" placeholder="Masukkan Nomor Telepon ..."
                                        value="{{ old('nomor_telepon', $penduduk->nomor_telepon) }}">
                                    @error('nomor_telepon')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="alamat_email">Alamat Email</label>
                                    <input type="email"
                                        class="form-control @error('alamat_email') is-invalid @enderror"
                                        name="alamat_email" placeholder="Masukkan Alamat Email ..."
                                        value="{{ old('alamat_email', $penduduk->alamat_email) }}">
                                    @error('alamat_email')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-control-label" for="alamat_sebelumnya">Alamat Sebelumnya</label>
                                    <textarea class="form-control @error('alamat_sebelumnya') is-invalid @enderror" name="alamat_sebelumnya"
                                        id="alamat_sebelumnya" placeholder="Masukkan Alamat Sebelumnya ...">{{ old('alamat_sebelumnya', $penduduk->alamat_sebelumnya) }}</textarea>
                                    @error('alamat_sebelumnya')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-control-label" for="alamat_sekarang">Alamat Sekarang</label>
                                    <textarea class="form-control @error('alamat_sekarang') is-invalid @enderror" name="alamat_sekarang"
                                        id="alamat_sekarang" placeholder="Masukkan Alamat Sekarang ...">{{ old('alamat_sekarang', $penduduk->alamat_sekarang) }}</textarea>
                                    @error('alamat_sekarang')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h4>Status Perkawinan</h4>
                        <div class="pl-4">
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="status_perkawinan_id">Status Perkawinan</label>
                                    <select class="form-control @error('status_perkawinan_id') is-invalid @enderror"
                                        name="status_perkawinan_id" id="status_perkawinan_id">
                                        <option selected value="">Pilih Status Perkawinan</option>
                                        @foreach ($status_perkawinan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('status_perkawinan_id', $penduduk->status_perkawinan_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_perkawinan_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="nomor_akta_perkawinan">Nomor Akta
                                        Perkawinan</label>
                                    <input type="text"
                                        class="form-control @error('nomor_akta_perkawinan') is-invalid @enderror"
                                        name="nomor_akta_perkawinan" id="nomor_akta_perkawinan"
                                        placeholder="Masukkan Nomor Akta Perkawinan ..."
                                        value="{{ old('nomor_akta_perkawinan', $penduduk->nomor_akta_perkawinan) }}">
                                    @error('nomor_akta_perkawinan')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="tanggal_perkawinan">Tanggal Perkawinan</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_perkawinan') is-invalid @enderror"
                                        name="tanggal_perkawinan" id="tanggal_perkawinan"
                                        placeholder="Masukkan tanggal_perkawinan ..."
                                        value="{{ old('tanggal_perkawinan', $penduduk->tanggal_perkawinan) }}">
                                    @error('tanggal_perkawinan')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="nomor_akta_perceraian">Nomor Akta
                                        Perceraian</label>
                                    <input type="text"
                                        class="form-control @error('nomor_akta_perceraian') is-invalid @enderror"
                                        name="nomor_akta_perceraian" id="nomor_akta_perceraian"
                                        placeholder="Masukkan Akta Perceraian ..."
                                        value="{{ old('nomor_akta_perceraian', $penduduk->nomor_akta_perceraian) }}">
                                    @error('nomor_akta_perceraian')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="form-control-label" for="tanggal_perceraian">Tanggal Perceraian</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_perceraian') is-invalid @enderror"
                                        name="tanggal_perceraian" id="tanggal_perceraian"
                                        placeholder="Masukkan tanggal_perceraian ..."
                                        value="{{ old('tanggal_perceraian', $penduduk->tanggal_perceraian) }}">
                                    @error('tanggal_perceraian')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h4>Data Kesehatan</h4>
                        <div class="pl-4">
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="darah_id">Golongan Darah</label>
                                    <select class="form-control @error('darah_id') is-invalid @enderror" name="darah_id"
                                        id="darah_id">
                                        <option selected value="">Pilih Golongan Darah</option>
                                        @foreach ($darah as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('darah_id', $penduduk->darah_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->golongan }}</option>
                                        @endforeach
                                    </select>
                                    @error('darah_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="jenis_cacat_id">Jenis Cacat</label>
                                    <select class="form-control @error('jenis_cacat_id') is-invalid @enderror"
                                        name="jenis_cacat_id" id="jenis_cacat_id">
                                        <option selected value="">Pilih Jenis Cacat</option>
                                        @foreach ($jenis_cacat as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('jenis_cacat_id', $penduduk->jenis_cacat_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_cacat_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="sakit_menahun_id">Sakit Menahun</label>
                                    <select class="form-control @error('sakit_menahun_id') is-invalid @enderror"
                                        name="sakit_menahun_id" id="sakit_menahun_id">
                                        <option selected value="">Pilih Sakit Menahun</option>
                                        @foreach ($sakit_menahun as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('sakit_menahun_id', $penduduk->sakit_menahun_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('sakit_menahun_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4 col-md-6" id="status-kehamilan" style="display: none">
                                    <label class="form-control-label" for="status_kehamilan">Status Kehamilan</label>
                                    <select class="form-control @error('status_kehamilan') is-invalid @enderror"
                                        name="status_kehamilan" id="status_kehamilan">
                                        <option selected value="">Pilih Status Kehamilan</option>
                                        <option value="0"
                                            {{ old('status_kehamilan') == 0 ? 'selected="true"' : '' }}>Tidak Hamil
                                        </option>
                                        <option value="1"
                                            {{ old('status_kehamilan') == 1 ? 'selected="true"' : '' }}>Hamil</option>
                                    </select>
                                    @error('status_kehamilan')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-6">
                                    <label class="form-control-label" for="asuransi_id">Asuransi</label>
                                    <select class="form-control @error('asuransi_id') is-invalid @enderror"
                                        name="asuransi_id" id="asuransi_id">
                                        <option selected value="">Pilih Asuransi</option>
                                        @foreach ($asuransi as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('asuransi_id', $penduduk->asuransi_id) == $item->id ? 'selected="true"' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('asuransi_id')
                                        <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" id="simpan">SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pekerjaan_id').select2({
                placeholder: "Pilih Pekerjaan",
                allowClear: true
            });

            jenis_kelamin();
            $("#jenis_kelamin").change(function() {
                jenis_kelamin();
            });

            if ($("#dusun").val() != "") {
                $.ajax({
                    url: baseURL + '/detailDusun?id=' + $("#dusun").val(),
                    method: 'get',
                    beforeSend: function() {
                        $('#detail_dusun_id').html(`<option value="">Loading ...</option>`);
                    },
                    success: function(response) {
                        $('#detail_dusun_id').html(`<option value="">Pilih RT/RW</option>`);
                        $.each(response, function(i, e) {
                            $('#detail_dusun_id').append(
                                `<option value="${e.id}">${e.rt}/${e.rw}</option>`);
                        });

                        $("#detail_dusun_id").val("{{ $penduduk->detail_dusun_id }}");
                    }
                });
            } else {
                $('#detail_dusun_id').html(`<option value="">Pilih RT/RW</option>`);
            }

            $("#dusun").change(function() {
                $.ajax({
                    url: baseURL + '/detailDusun?id=' + $(this).val(),
                    method: 'get',
                    beforeSend: function() {
                        $('#detail_dusun_id').html(`<option value="">Loading ...</option>`);
                    },
                    success: function(response) {
                        $('#detail_dusun_id').html(`<option value="">Pilih RT/RW</option>`);
                        $.each(response, function(i, e) {
                            $('#detail_dusun_id').append(
                                `<option value="${e.id}">${e.rt}/${e.rw}</option>`);
                        });
                    }
                });
            });

            perkawinan();

            $('#status_perkawinan_id').change(function() {
                perkawinan();
            });
        });

        function jenis_kelamin() {
            if ($("#jenis_kelamin").val() == 1) {
                $('#status-kehamilan').hide();
                option(1)
            } else if ($("#jenis_kelamin").val() == 2) {
                $('#status-kehamilan').show();
                option(2);
            }
        }

        function option(value) {
            $("#akseptor_kb_id").html(`<option selected value="">Loading ...</option>`);
            $.get(baseURL + "/akseptor-kb/" + value, function(response) {
                let option = `<option value="">Pilih Akseptor KB</option>`;
                $.each(response, function(key, item) {
                    option +=
                        `<option value="${item.id}" ${"{{ old('akseptor_kb_id', $penduduk->akseptor_kb_id) }}" == item.id ? 'selected' : ''}>${item.nama}</option>`;
                });
                option += `<option value="99">Lainnya</option>`;
                $("#akseptor_kb_id").html(option);
            });
        }
    </script>
@endpush
