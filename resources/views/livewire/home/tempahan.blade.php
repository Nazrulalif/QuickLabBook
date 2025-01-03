<div>
    <div class="card p-3 shadow" style="background-color: rgba(50, 82, 133, 0.9);">
        <div class="card-body text-white">
            <h5 class="bg-black bg-opacity-75 p-3 text-center mb-5">
                TEMPAHAN PINJAMAN BAGI PERALATAN MULTIMEDIA
            </h5>

            @if($showDate)
            <!-- Date Selection Form -->
            <div class="mb-4 d-flex flex-column">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date">Tarikh Pinjam</label>
                        <input type="date" wire:model="start_date" id="start_date"
                            class="form-control @error('start_date') is-invalid @enderror">
                        @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="end_date">Tarikh Pulang</label>
                        <input type="date" wire:model="end_date" id="end_date"
                            class="form-control @error('end_date') is-invalid @enderror">
                        @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-row justify-content-center pt-3">
                    {{-- <button class="btn btn-secondary px-5 me-3" disabled>
                        Back
                    </button> --}}
                    <button wire:click="sendDate" class="btn btn-primary px-5"
                        style="background-color: #14315F; border-color: #14315F;">
                        Seterusnya
                    </button>
                </div>

            </div>
            @endif

            @if($showLabs)
            <!-- Lab Selection Form -->
            <div class="row gap-5 justify-content-center text-black">
                @foreach ($lab as $item)
                <div wire:key="{{ $item->id }}" class="d-flex flex-column align-items-center" style="width: 20rem;">
                    <img src="{{ asset('storage/'. $item->picture) }}" class="card-img rounded-3 pb-3" alt="Lab Image">

                    <label class="lab-selection-container w-100">
                        <input type="radio" name="selected_lab" value="{{ $item->id }}" wire:model="selectedLab"
                            class="lab-radio-input">
                        <div class="lab-selection-item rounded-3 text-center p-2 fw-bold m-0">
                            {{ $item->name }}
                        </div>
                    </label>
                </div>
                @endforeach
            </div>

            <!-- Submit and Back Buttons -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary px-5 me-3" wire:click="goBack('showDate')">
                    Kembali
                </button>
                <button wire:click="submitLabChoice" class="btn btn-primary px-5"
                    style="background-color: #14315F; border-color: #14315F;">
                    Seterusnya
                </button>
            </div>
            @endif

            @if($showItem)
            <div class="row gap-5 justify-content-center text-black">
                @foreach ($stock as $item)
                <div wire:key="{{ $item->id }}" class="card text-center" style="width: 15rem;">
                    <div class="card-body">
                        <img src="{{ asset('storage/'. $item->picture) }}" class="card-img rounded" alt="Equipment">
                        <p class="card-title fs-5">{{ $item->name }}</p>

                        <div class="d-flex flex-row gap-3 align-items-center justify-content-center py-3">
                            <!-- Decrement Button -->
                            <button class="btn text-white" style="background-color:#14315F"
                                wire:click="decrementQty({{ $item->id }})">-</button>

                            <!-- Dynamic Quantity Display -->
                            <span>{{ $quantities[$item->id] }}</span>

                            <!-- Increment Button -->
                            <button class="btn text-white" style="background-color:#14315F"
                                wire:click="incrementQty({{ $item->id }})">+</button>
                        </div>
                        <small class="text-muted">Stock left: {{  $item->available_quantity }}</small>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Back Button -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary px-5 me-3" wire:click="goBack('showLabs')">
                    Kembali
                </button>
                <button wire:click="hantar" type="submit" class="btn btn-primary px-5"
                    style="background-color: #14315F; border-color: #14315F;">
                    Hantar
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
