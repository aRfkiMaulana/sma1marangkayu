@extends('layouts.public')
@section('title', 'Buku Tahunan - SMA Negeri 1 Marangkayu')

@section('content')

{{-- HERO --}}
<div class="relative overflow-hidden py-16 px-6 text-white text-center"
     style="background:var(--color-primary); background-image: url('{{ asset('images/wheat.webp') }}'); background-repeat: repeat; background-size: 180px 180px; image-rendering: pixelated;">
    <div class="absolute inset-0 bg-slate-950/50"></div>
    <div class="relative max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs font-semibold mb-4">
            <i class="fa-solid fa-book-open" style="color:var(--color-accent)"></i>
            Kenangan &amp; Alumni
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold mb-4 drop-shadow-lg">Buku Tahunan Siswa</h1>
        <p class="text-white/80 text-sm md:text-base max-w-xl mx-auto">
            Kenangan dan moto alumni SMAN 1 Marangkayu. Gunakan NISN dan Kode Unik dari wali kelas untuk mengisi data kamu.
        </p>

        {{-- Tab toggle --}}
        <div class="mt-8 max-w-xl mx-auto">
            <div class="flex rounded-xl bg-white/10 border border-white/20 p-1 gap-1 mb-4">
                <button onclick="switchTab('isi')"
                        class="flex-1 py-2 rounded-lg text-xs font-bold transition-all tab-btn active-tab" id="tabIsi">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Isi / Edit Data
                </button>
                <button onclick="switchTab('cek')"
                        class="flex-1 py-2 rounded-lg text-xs font-bold transition-all tab-btn" id="tabCek">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Cek Status
                </button>
            </div>

            {{-- Panel Isi --}}
            <div id="panelIsi" class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-left">
                <p class="text-xs text-slate-300 mb-4">Masukkan NISN dan Kode Unik yang kamu terima dari wali kelas.</p>
                <div id="alertIsi" class="hidden text-xs p-3 rounded-xl mb-4 border"></div>
                <div class="grid sm:grid-cols-2 gap-3" id="formVerif">
                    <div>
                        <label class="block text-xs font-semibold text-slate-200 mb-1">NISN Siswa</label>
                        <input type="text" id="nisnIsi" maxlength="10" inputmode="numeric"
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400"
                               placeholder="10 digit NISN">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-200 mb-1">Kode Unik</label>
                        <input type="text" id="kodeIsi"
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 font-mono tracking-widest uppercase"
                               placeholder="KODE UNIK">
                    </div>
                    <div class="sm:col-span-2 pt-2">
                        <button onclick="doVerifikasi()" id="btnVerif"
                                class="w-full font-bold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2"
                                style="background:var(--color-accent);color:#1a1a1a">
                            <i class="fa-solid fa-right-to-bracket"></i> Verifikasi &amp; Lanjut
                        </button>
                    </div>
                </div>
                {{-- Form upload (muncul setelah verifikasi) --}}
                <div id="formUpload" class="hidden mt-4 space-y-4">
                    <div class="bg-white/10 rounded-xl p-3 text-xs text-white border border-white/20">
                        <p class="font-bold text-sm" id="uploadNama"></p>
                        <p class="text-white/70" id="uploadKelas"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-200 mb-1">Foto Diri <span class="text-red-400">*</span></label>
                        <input type="file" id="fotoInput" accept="image/jpeg,image/png,image/webp"
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950">
                        <p class="text-xs text-slate-400 mt-1">Min 400×400px. Max 2MB. JPG/PNG/WEBP.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-200 mb-1">Moto Hidup <span class="text-red-400">*</span></label>
                        <textarea id="motoInput" rows="3" maxlength="255"
                                  class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400"
                                  placeholder="Tuliskan moto atau kesan selama di sekolah..."></textarea>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <button onclick="doSimpanDraft()"
                                class="w-full bg-white/10 border border-white/20 text-white font-bold py-2.5 rounded-xl text-sm hover:bg-white/20 flex items-center justify-center gap-2 transition">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Draft
                        </button>
                        <button onclick="doKirimAdmin()" id="btnKirim"
                                class="w-full font-bold py-2.5 rounded-xl text-sm flex items-center justify-center gap-2 transition"
                                style="background:var(--color-accent);color:#1a1a1a">
                            <i class="fa-solid fa-paper-plane"></i> Kirim ke Admin
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 text-center">Simpan draft dulu, lalu kirim jika sudah yakin. Setelah dikirim tidak bisa diubah.</p>
                </div>
            </div>

            {{-- Panel Cek Status --}}
            <div id="panelCek" class="hidden bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-left">
                <p class="text-xs text-slate-300 mb-4">Masukkan NISN dan Kode Unik untuk melihat status pengirimanmu.</p>
                <div id="alertCek" class="hidden text-xs p-3 rounded-xl mb-4 border"></div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-200 mb-1">NISN Siswa</label>
                        <input type="text" id="nisnCek" maxlength="10" inputmode="numeric"
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400"
                               placeholder="10 digit NISN">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-200 mb-1">Kode Unik</label>
                        <input type="text" id="kodeCek"
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 font-mono tracking-widest uppercase"
                               placeholder="KODE UNIK">
                    </div>
                    <div class="sm:col-span-2 pt-2">
                        <button onclick="doCekStatus()"
                                class="w-full font-bold py-2.5 rounded-xl text-sm flex items-center justify-center gap-2 transition"
                                style="background:var(--color-accent);color:#1a1a1a">
                            <i class="fa-solid fa-magnifying-glass"></i> Cek Status
                        </button>
                    </div>
                </div>
                <div id="hasilCek" class="hidden mt-4 bg-white/10 rounded-xl p-4 text-sm border border-white/20"></div>
            </div>
        </div>{{-- end max-w-xl --}}
    </div>{{-- end relative --}}
</div>{{-- end hero --}}

{{-- GALERI ALUMNI --}}
<section class="py-12 bg-gray-50">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="section-title">Galeri Alumni</h2>
                <p class="text-sm text-gray-500 mt-1">Siswa yang telah disetujui oleh admin</p>
            </div>
            <form action="{{ route('buku-tahunan.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <select name="angkatan_id" class="form-input text-xs py-1.5 w-44" onchange="this.form.submit()">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatans as $a)
                    <option value="{{ $a->id }}" {{ request('angkatan_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->nama_angkatan }} ({{ $a->tahun_lulus }})
                    </option>
                    @endforeach
                </select>
                <select name="kelas_id" class="form-input text-xs py-1.5 w-36" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($siswas as $s)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="relative overflow-hidden">
                    <img src="{{ Storage::url($s->foto) }}"
                         class="w-full h-56 object-cover object-top" alt="{{ $s->nama }}"
                         onerror="this.src='https://placehold.co/300x400/1a3d6e/fff?text={{ urlencode($s->nama) }}'">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                        <span class="text-white text-[10px] font-semibold">
                            {{ $s->kelas->angkatan->nama_angkatan ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="p-3 flex-1 flex flex-col">
                    <p class="font-bold text-gray-900 text-xs leading-snug mb-1">{{ $s->nama }}</p>
                    @if($s->kelas)
                    <p class="text-[10px] text-gray-400 mb-1">{{ $s->kelas->nama_kelas }}</p>
                    @endif
                    @if($s->moto)
                    <p class="text-[10px] text-gray-500 italic line-clamp-2 mt-auto">"{{ $s->moto }}"</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-8 md:p-12 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-50 text-2xl"
                         style="color:var(--color-primary)">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700">Belum ada data alumni</h3>
                    <p class="mt-2 text-sm text-gray-500">Data alumni yang telah disetujui admin akan tampil di sini.</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($siswas->hasPages())
        <div class="mt-8">{{ $siswas->links() }}</div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    .tab-btn { color: rgba(255,255,255,0.6); }
    .active-tab { background: rgba(255,255,255,0.2); color: #fff; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    let _nisn = '', _kode = '';
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    window.switchTab = function (tab) {
        document.getElementById('panelIsi').classList.toggle('hidden', tab !== 'isi');
        document.getElementById('panelCek').classList.toggle('hidden', tab !== 'cek');
        document.getElementById('tabIsi').classList.toggle('active-tab', tab === 'isi');
        document.getElementById('tabCek').classList.toggle('active-tab', tab === 'cek');
    };

    function showAlert(id, msg, isError) {
        const el = document.getElementById(id);
        el.className = 'text-xs p-3 rounded-xl mb-4 border ' +
            (isError ? 'bg-red-500/20 border-red-500/40 text-red-200'
                     : 'bg-green-500/20 border-green-500/40 text-green-200');
        el.textContent = msg;
        el.classList.remove('hidden');
    }
    function hideAlert(id) { document.getElementById(id).classList.add('hidden'); }
    function setLoading(id, v) { const b = document.getElementById(id); if(b){ b.disabled=v; b.style.opacity=v?'0.6':'1'; } }

    window.doVerifikasi = async function () {
        hideAlert('alertIsi');
        _nisn = document.getElementById('nisnIsi').value.trim();
        _kode = document.getElementById('kodeIsi').value.trim();
        if (!_nisn || !_kode) return showAlert('alertIsi', 'NISN dan Kode Unik wajib diisi.', true);
        setLoading('btnVerif', true);
        try {
            const res = await fetch('{{ route('buku-tahunan.verifikasi') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({ nisn: _nisn, kode_unik: _kode }),
            });
            const data = await res.json();
            if (!res.ok) return showAlert('alertIsi', data.message ?? 'Verifikasi gagal.', true);
            document.getElementById('formVerif').classList.add('hidden');
            document.getElementById('formUpload').classList.remove('hidden');
            document.getElementById('uploadNama').textContent = data.nama;
            document.getElementById('uploadKelas').textContent = data.kelas + ' — ' + data.angkatan;
            if (data.moto) document.getElementById('motoInput').value = data.moto;
            showAlert('alertIsi', 'Verifikasi berhasil! Lengkapi foto dan moto kamu.', false);
        } catch { showAlert('alertIsi', 'Terjadi kesalahan jaringan.', true); }
        finally { setLoading('btnVerif', false); }
    };

    window.doSimpanDraft = async function () {
        hideAlert('alertIsi');
        const moto = document.getElementById('motoInput').value.trim();
        const foto = document.getElementById('fotoInput').files[0];
        if (!moto) return showAlert('alertIsi', 'Moto wajib diisi.', true);
        const fd = new FormData();
        fd.append('nisn', _nisn); fd.append('kode_unik', _kode);
        fd.append('moto', moto); fd.append('_token', csrf);
        if (foto) fd.append('foto', foto);
        try {
            const res = await fetch('{{ route('buku-tahunan.simpan-draft') }}', { method: 'POST', headers: { 'Accept': 'application/json' }, body: fd });
            const data = await res.json();
            if (!res.ok) return showAlert('alertIsi', data.message ?? 'Gagal simpan draft.', true);
            showAlert('alertIsi', 'Draft berhasil disimpan!', false);
        } catch { showAlert('alertIsi', 'Terjadi kesalahan jaringan.', true); }
    };

    window.doKirimAdmin = async function () {
        if (!confirm('Setelah dikirim ke admin, data tidak bisa diubah. Lanjutkan?')) return;
        hideAlert('alertIsi'); setLoading('btnKirim', true);
        try {
            const res = await fetch('{{ route('buku-tahunan.kirim-ke-admin') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({ nisn: _nisn, kode_unik: _kode }),
            });
            const data = await res.json();
            if (!res.ok) return showAlert('alertIsi', data.message ?? 'Gagal mengirim.', true);
            showAlert('alertIsi', '✅ Berhasil dikirim ke admin! Tunggu persetujuan.', false);
            document.getElementById('btnKirim').disabled = true;
        } catch { showAlert('alertIsi', 'Terjadi kesalahan jaringan.', true); }
        finally { setLoading('btnKirim', false); }
    };

    window.doCekStatus = async function () {
        hideAlert('alertCek');
        document.getElementById('hasilCek').classList.add('hidden');
        const nisn = document.getElementById('nisnCek').value.trim();
        const kode = document.getElementById('kodeCek').value.trim();
        if (!nisn || !kode) return showAlert('alertCek', 'NISN dan Kode Unik wajib diisi.', true);
        try {
            const url = new URL('{{ route('buku-tahunan.cek-status') }}', window.location.origin);
            url.searchParams.set('nisn', nisn); url.searchParams.set('kode_unik', kode);
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            if (!res.ok) return showAlert('alertCek', data.message ?? 'Data tidak ditemukan.', true);
            const badges = { kosong:'bg-slate-500/30 text-slate-200', draft:'bg-blue-500/30 text-blue-200', pending:'bg-yellow-500/30 text-yellow-200', approved:'bg-green-500/30 text-green-200', rejected:'bg-red-500/30 text-red-200' };
            const badge = badges[data.status] ?? 'bg-slate-500/30 text-slate-200';
            const hasil = document.getElementById('hasilCek');
            hasil.innerHTML = `<p class="font-bold text-white text-sm mb-1">${data.siswa?.nama ?? '-'}</p><span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full ${badge} mb-2">${data.status.toUpperCase()}</span><p class="text-white/70 text-xs">${data.pesan}</p>`;
            hasil.classList.remove('hidden');
        } catch { showAlert('alertCek', 'Terjadi kesalahan jaringan.', true); }
    };
})();
</script>
@endpush
