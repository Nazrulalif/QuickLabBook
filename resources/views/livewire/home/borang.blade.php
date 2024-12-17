<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card p-3 shadow ms-4" style="background-color: rgba(50, 82, 133, 0.9);">
                <div class="card-body">
                    <h5 class="bg-black text-white bg-opacity-75 p-3 text-center mb-4">
                        MAKLUMAT PEMINJAM
                    </h5>

                    <div class="card p-4 border border-3" style="background-color: rgba(255, 255, 255, 0.9); ">
                        <div class="card-body">
                            <form wire:submit.prevent='submitBorang' method="POST" style="color:#14315F">
                                @csrf
                                <div class="row">
                                    <div class="form-group">
                                        <label for="" class="fw-bold ">Maklumat Pelajar</label>
                                        <input type="text" wire:model="name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="fw-bold ">No Matrik</label>
                                            <input type="text" wire:model="matric"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="fw-bold ">Email Siswa</label>
                                            <input type="email" wire:model="emel" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="fw-bold ">Tahap Pengajian</label>
                                            <select  wire:model="tahap_pengajian" class="form-control">
                                                <option value="Sarjana Muda">Sarjana Muda</option>
                                                <option value="Sarjana">Sarjana</option>
                                                <option value="Doktor Falsafah">Doktor Falsafah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="fw-bold ">Tahun Pengajian</label>
                                            <input type="number" wire:model="tahun_pengajian" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group">
                                        <label for="" class="fw-bold ">Tujuan Pinjaman</label>
                                        <textarea  wire:model="tujuan" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="/tempahan" class="btn btn-secondary me-3 px-5 ">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5 "
                                        style="background-color: #14315F; border-color: #14315F;">
                                        Hantar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow" style="background-color: rgba(50, 82, 133, 0.9);">
                <div class="card-body">
                    <h5 class="bg-black text-white bg-opacity-75 p-3 text-center mb-4">
                        MAKLUMAT TEMPAHAN
                    </h5>
        
                    test
                </div>
            </div>
        </div>
    </div>
  
</div>
