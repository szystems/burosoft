
                <form action="{{ url('users') }}" method="GET">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 mb-0">
                            <label for=""><strong>{{ __('Buscar') }} {{ __('Usuario') }}:</strong></label>

                        </div>
                        <div class="col-md-6 mb-3">

                            <input class="form-select px-2" list="userListOptions" placeholder="{{ __('Buscar por Nombre/Teléfono/Email...') }}" name="fuser" value="{{ $queryUser }}">
                            <datalist id="userListOptions">
                                <option value="">{{ __('Todos') }}</option>
                                @if ($queryUser != null)
                                    <option selected value="{{ $queryUser }}" >{{ $queryUser }}</option>
                                @endif
                                @foreach ($filterUsers as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </datalist>
                            {{-- </select> --}}
                        </div>
                        <div class="col-md-2 mb-3" >
                            <button type="submit" class="btn btn-info"><i class="material-icons">search</i> {{ __('Buscar') }}</button>
                        </div>
                    </div>
                </form>
