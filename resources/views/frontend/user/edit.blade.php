@extends('layouts.frontend')
{{-- Edit Account details --}}
@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row">

                @php
                    $usuario = Auth::user()->name;
                    $nombre = explode(' ', trim($usuario));
                    $names = str_word_count($usuario);
                @endphp

                <div class="col-md-4 sidebar ftco-animate">
                    <div class="sidebar-box ftco-animate">
                        <div class="categories">
                            <h3>
                                <font color="fa9932">Hola</font>  {{ ucwords($nombre[0]) }}! <br>
                            </h3>

                            <ul class="list-group">
                                <li class="list-group-item"><a class="h4" href="{{ url('my-account') }}"><font color="fa9932">{{ __('Mi Cuenta') }}</font></a></li>
                                <li class="list-group-item active"><a class="h6" href="{{ url('user-details/'.Auth::id()) }}"><font color="white">- {{ __('Detalles de Cuenta') }}</font></a></li>
                                {{-- <li class="list-group-item"><a href="{{ url('user-subscription/'.Auth::id()) }}">- {{ __('Suscripción') }}</a></li> --}}
                                <li class="list-group-item">
                                    <a href="javascript:; {{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-primary py-2 px-4 ml-auto d-none d-lg-block"><span>{{ __('Cerrar Sesión') }}</span></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 ftco-animate">
                    @if (count($errors)>0)
                        <div class="alert alert-danger text-white" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>

                    @endif
                    <form action="{{ url('user-update/'.Auth::id()) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-12">
                                <h3>{{ __('Editar datos') }}</h3>
                            </div>
                            <div class="col-sm-4">
                                <label>{{ __('Nombre') }}</label>
                                <input  name="name" type="text" class="form-control" value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('name') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            {{-- <div class="col-sm-4">
                                <label>{{ __('Teléfono') }}</label>
                                <input name="phone" type="text" class="form-control" value="{{ $user->phone }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('phone') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div> --}}
                            <div class="col-sm-4">
                                <label>Email</label>
                                <input readonly name="email" type="text" class="form-control" value="{{ $user->email }}">
                                <small class="form-text">{{ __("You can't change email") }}</small>
                                @if ($errors->has('email'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('email') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>


                            {{-- <div class="col-sm-3">
                                <label>{{ __('Pais') }}</label>
                                <input readonly name="country" type="text" class="form-control" value="Guatemala">
                                @if ($errors->has('country'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('country') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <label>{{ __('Departamento/Estado') }}</label>
                                <select class="form-control" name="state" id="departamentos" onchange="cargarMunicipios()" required>
                                    <option selected value="{{ $user->state }}">{{ $user->state }}</option>

                                    <option value="">Selecciona un departamento</option>
                                    <option value="Alta Verapaz">Alta Verapaz</option>
                                    <option value="Baja Verapaz">Baja Verapaz</option>
                                    <option value="Chimaltenango">Chimaltenango</option>
                                    <option value="Chiquimula">Chiquimula</option>
                                    <option value="El Progreso">El Progreso</option>
                                    <option value="Escuintla">Escuintla</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Huehuetenango">Huehuetenango</option>
                                    <option value="Izabal">Izabal</option>
                                    <option value="Jalapa">Jalapa</option>
                                    <option value="Jutiapa">Jutiapa</option>
                                    <option value="Petén">Petén</option>
                                    <option value="Quetzaltenango">Quetzaltenango</option>
                                    <option value="Quiché">Quiché</option>
                                    <option value="Retalhuleu">Retalhuleu</option>
                                    <option value="Sacatepéquez">Sacatepéquez</option>
                                    <option value="San Marcos">San Marcos</option>
                                    <option value="Santa Rosa">Santa Rosa</option>
                                    <option value="Sololá">Sololá</option>
                                    <option value="Suchitepéquez">Suchitepéquez</option>
                                    <option value="Totonicapán">Totonicapán</option>
                                    <option value="Zacapa">Zacapa</option>
                                </select>
                                @if ($errors->has('state'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('state') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <label>{{ __('Ciudad') }}</label>
                                <select name="city" type="text" class="form-control" id="municipios" required>
                                    <option selected value="{{ $user->city }}">{{ $user->city }}</option>

                                    <option value="">Selecciona un municipio</option>
                                </select>
                                @if ($errors->has('city'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('city') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <label>{{ __('Código Postal') }}</label>
                                <input name="zipcode" type="text" class="form-control" value="{{ $user->zipcode }}">
                                @if ($errors->has('zipcode'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('zipcode') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <label>{{ __('Dirección') }} 1</label>
                                <input name="address1" type="text" class="form-control" value="{{ $user->address1 }}">
                                @if ($errors->has('address1'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('address1') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <label>{{ __('Dirección') }} 2</label>
                                <input name="address2" type="text" class="form-control" value="{{ $user->address2 }}">
                                @if ($errors->has('address2'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('address2') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                <label>{{ __('Zona Horaria') }}</label>
                                <select class="form-control" name="timezone" id="timezone">
                                    @foreach(Helpers::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                        <option value="{{ $timezone }}" {{ ( $timezone === old('timezone', $user->timezone)) ? 'selected' : '' }}>
                                            {{ $timezone_gmt_diff }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>
                        <p>
                            <button type="submit" class="btn btn-primary py-2 px-4 "><span>{{ __('Grabar') }}</span></button>
                        </p>
                    </form>
                </div> <!-- .col-md-8 -->

            </div>
        </div>
    </section> <!-- .section -->

    <script>
        const municipiosPorDepartamento = {
          "Alta Verapaz": ["Cobán", "Chisec", "San Cristóbal Verapaz", "Santa Cruz Verapaz", "Tactic", "Tamahú", "San Juan Chamelco", "Panzós", "Senahú", "Cahabón", "Chahal", "Fray Bartolomé de las Casas", "Santa María Cahabón", "La Tinta", "Raxruhá"],
          "Baja Verapaz": ["Salamá", "San Miguel Chicaj", "Rabinal", "Cubulco", "Granados", "San Jerónimo", "Purulhá"],
          "Chimaltenango": ["Chimaltenango", "San José Poaquil", "San Martín Jilotepeque", "Comalapa", "Santa Apolonia", "Tecpán Guatemala", "Patzún", "Pochuta", "Patzicía", "Santa Cruz Balanyá", "Acatenango", "Yepocapa", "San Andrés Itzapa", "Parramos", "Zaragoza", "El Tejar"],
          "Chiquimula": ["Chiquimula", "San José La Arada", "San Juan Ermita", "Jocotán", "Camotán", "Olopa", "Esquipulas", "Concepción Las Minas", "Quetzaltepeque"],
          "El Progreso": ["Guastatoya", "Morazán", "San Agustín Acasaguastlán", "San Antonio La Paz", "San Cristóbal Acasaguastlán", "Sanarate", "Sansare", "Santa María Ixhuatán"],
          "Escuintla": ["Escuintla", "Santa Lucía Cotzumalguapa", "La Democracia", "Siquinalá", "Masagua", "Tiquisate", "La Gomera", "Guazacapán", "San José", "Iztapa", "Palín", "San Vicente Pacaya", "Nueva Concepción"],
          "Guatemala": ["Guatemala", "Santa Catarina Pinula", "San José Pinula", "San José del Golfo", "Palencia", "Chinautla", "San Pedro Ayampuc", "Mixco", "San Pedro Sacatepéquez", "San Juan Sacatepéquez", "San Raymundo", "Chuarrancho", "Fraijanes", "Amatitlán", "Villa Nueva", "Villa Canales", "San Miguel Petapa"],
          "Huehuetenango": ["Huehuetenango", "Chiantla", "Malacatancito", "Cuilco", "Nentón", "San Pedro Necta", "Jacaltenango", "San Pedro Soloma", "San Ildelfonso Ixtahuacán", "Santa Bárbara", "La Libertad", "La Democracia", "San Miguel Acatán", "San Rafael La Independencia", "Todos Santos Cuchumatán", "San Juan Atitán", "Santa Eulalia", "San Mateo Ixtatán", "Colotenango", "San Sebastián Huehuetenango", "Tectitán", "Concepción Huista", "San Juan Ixcoy", "San Antonio Huista", "San Sebastián Coatán", "Santa Cruz Barillas", "Aguacatán", "San Rafael Petzal", "San Gaspar Ixchil", "Santiago Chimaltenango", "Santa Ana Huista"],
          "Izabal": ["Puerto Barrios", "Livingston", "El Estor", "Morales", "Los Amates"],
          "Jalapa": ["Jalapa", "San Pedro Pinula", "San Luis Jilotepeque", "San Manuel Chaparrón", "San Carlos Alzatate", "Monjas", "Mataquescuintla"],
          "Jutiapa": ["Jutiapa", "El Progreso", "Santa Catarina Mita", "Agua Blanca", "Asunción Mita", "Yupiltepeque", "Atescatempa", "Jerez", "El Adelanto", "Zapotitlán", "Comapa", "Jalpatagua", "Conguaco", "Moyuta", "Pasaco", "San José Acatempa", "Quesada"],
          "Petén": ["Flores", "San José", "San Benito", "San Andrés", "La Libertad", "San Francisco", "Santa Ana", "Dolores", "San Luis", "Sayaxché", "Melchor de Mencos", "Poptún", "Las Cruces", "La Blanca", "El Chal"],
          "Quetzaltenango": ["Quetzaltenango", "Salcajá", "Olintepeque", "San Carlos Sija", "Sibilia", "Cabricán", "Cajolá", "San Miguel Siguilá", "Ostuncalco", "San Mateo", "Concepción Chiquirichapa", "San Martín Sacatepéquez", "Almolonga", "Cantel", "Huitán", "Zunil", "Colomba", "San Francisco La Unión", "El Palmar", "Coatepeque", "Génova", "Flores Costa Cuca", "La Esperanza"],
          "Quiché": ["Santa Cruz del Quiché", "Chiché", "Chinique", "Zacualpa", "Chajul", "Chichicastenango", "Patzité", "San Antonio Ilotenango", "San Pedro Jocopilas", "Cunén", "San Juan Cotzal", "Joyabaj", "Nebaj", "San Andrés Sajcabajá", "Uspantán", "Sacapulas", "San Bartolomé Jocotenango", "Canillá"],
          "Retalhuleu": ["Retalhuleu", "San Sebastián", "Santa Cruz Mulúa", "San Martín Zapotitlán", "San Felipe", "San Andrés Villa Seca", "Champerico", "Nuevo San Carlos", "El Asintal"],
          "Sacatepéquez": ["Antigua Guatemala", "Jocotenango", "Pastores", "Sumpango", "Santo Domingo Xenacoj", "Santiago Sacatepéquez", "San Bartolomé Milpas Altas", "San Lucas Sacatepéquez", "Santa Lucía Milpas Altas", "Magdalena Milpas Altas", "Santa María de Jesús", "Ciudad Vieja", "San Miguel Dueñas", "San Juan Alotenango", "San Antonio Aguas Calientes"],
          "San Marcos": ["San Marcos", "San Pedro Sacatepéquez", "San Antonio Sacatepéquez", "Comitancillo", "San Miguel Ixtahuacán", "Concepción Tutuapa", "Tacaná", "Sibinal", "Tajumulco", "Tejutla", "San Rafael Pie de la Cuesta", "Nuevo Progreso", "El Tumbador", "San José El Rodeo", "Malacatán", "Catarina", "Ayutla", "Ocós", "San Pablo", "El Quetzal", "La Reforma", "Pajapita", "Ixchiguan", "San José Ojetenam"],
          "Santa Rosa": ["Cuilapa", "Barberena", "Santa Rosa de Lima", "Casillas", "San Rafael Las Flores", "Oratorio", "San Juan Tecuaco", "Chiquimulilla", "Taxisco", "Santa María Ixhuatán", "Guazacapán", "Santa Cruz Naranjo", "Pueblo Nuevo Viñas", "Nueva Santa Rosa"],
          "Sololá": ["Sololá", "San José Chacayá", "Santa María Visitación", "Santa Lucía Utatlán", "Nahualá", "Santa Catarina Ixtahuacán", "Santa Clara La Laguna", "Concepción", "San Andrés Semetabaj", "Panajachel", "Santa Catarina Palopó", "San Antonio Palopó", "San Lucas Tolimán", "Santa Cruz La Laguna", "San Pablo La Laguna", "San Marcos La Laguna", "San Juan La Laguna", "San Pedro La Laguna"],
          "Suchitepéquez": ["Mazatenango", "Cuyotenango", "San Francisco Zapotitlán", "San Bernardino", "San José El Idolo", "Santo Domingo Suchitepéquez", "San Lorenzo", "Samayac", "San Pablo Jocopilas", "San Antonio Suchitepéquez", "San Miguel Panán", "San Gabriel", "Chicacao", "Patulul", "Santa Bárbara", "San Juan Bautista", "Santo Tomás La Unión", "Zunilito", "Pueblo Nuevo"],
          "Totonicapán": ["Totonicapán", "San Cristóbal Totonicapán", "San Francisco El Alto", "Santa María Chiquimula", "San Bartolo", "Santa Lucía La Reforma", "San Andrés Xecul", "Momostenango"],
          "Zacapa": ["Zacapa", "Estanzuela", "Río Hondo", "Gualán", "Teculután", "Usumatlán", "Cabañas", "San Diego", "La Unión", "Huite"],
        };

        function cargarMunicipios() {
          const departamentoSelect = document.getElementById("departamentos");
          const municipioSelect = document.getElementById("municipios");
          const departamento = departamentoSelect.value;

          municipioSelect.innerHTML = "<option value=''>Selecciona un municipio</option>";

          if (departamento && municipiosPorDepartamento.hasOwnProperty(departamento)) {
            const municipios = municipiosPorDepartamento[departamento];
            municipios.forEach(function(municipio) {
              const option = document.createElement("option");
              option.value = municipio;
              option.text = municipio;
              municipioSelect.appendChild(option);
            });
          }
        }
      </script>

@endsection
