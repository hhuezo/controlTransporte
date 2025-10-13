@extends ('menu')
@section('content')
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="{{ asset('assets/libs/toast/toastr.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ asset('assets/libs/toast/toastr.min.js') }}"></script>

    <style>
        .leaflet-control-attribution {
            display: none !important;
        }
    </style>




    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Regitro de {{ $motorista->name }}
                    </div>
                    <div class="prism-toggle">
                        <div class="prism-toggle">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-filtro"><i
                                    class="bi bi-funnel-fill"></i> Filtrar</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <script>
                            toastr.success("{{ session('success') }}");
                        </script>
                    @endif

                    @if (session('error'))
                        <script>
                            toastr.error("{{ session('error') }}");
                        </script>
                    @endif

                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-striped table-hover text-nowrap w-100 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Motorista</th>
                                    <th>Tipo</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                    <th>Hora Reporte</th>
                                    <th>Observación</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($puntos as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->motorista->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $color = match ($item->tipo) {
                                                    'entrada' => 'success',
                                                    'salida' => 'primary',
                                                    'parada' => 'warning',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ ucfirst($item->tipo) }}</span>
                                        </td>
                                        <td>{{ $item->latitud }}</td>
                                        <td>{{ $item->longitud }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->hora_reporte)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $item->observacion ?? '-' }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info btn-wave" data-bs-toggle="modal"
                                                data-bs-target="#modalMapa-{{ $item->id }}">
                                                <i class="bi bi-geo-alt-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @include('administracion.modal_mapa')
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="modal fade" id="modal-filtro" tabindex="-1" aria-labelledby="modalFiltroLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalFiltroLabel">
                        <i class="bi bi-funnel-fill me-2"></i> Filtrar
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <form method="GET" action="{{ route('control.show', $motorista->id) }}">
                    <div class="modal-body">
                        <div class="row gy-3">
                            <!-- Fecha inicial -->
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio"
                                    class="form-control @error('fecha_inicio') is-invalid @enderror"
                                    value="{{ $fechaInicio->format('Y-m-d') }}" required>
                            </div>

                            <!-- Fecha final -->
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label">Fecha fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin"
                                    class="form-control @error('fecha_fin') is-invalid @enderror"
                                    value="{{ $fechaFin->format('Y-m-d') }}" required>
                            </div>

                            <!-- Hora inicio -->
                            <div class="col-md-6">
                                <label for="hora_inicio" class="form-label">Hora inicio</label>
                                <input type="time" name="hora_inicio" id="hora_inicio"
                                    class="form-control @error('hora_inicio') is-invalid @enderror"
                                    value="{{ $horaInicio }}">
                            </div>

                            <!-- Hora final -->
                            <div class="col-md-6">
                                <label for="hora_fin" class="form-label">Hora fin</label>
                                <input type="time" name="hora_fin" id="hora_fin"
                                    class="form-control @error('hora_fin') is-invalid @enderror"
                                    value="{{ $horaFin }}">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Aplicar filtro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>








    <script src="{{ asset('assets/libs/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dataTables/dataTables.bootstrap5.min.js') }}"></script>


    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


    <!-- Activar DataTable -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            expandMenuAndHighlightOption('li-abogado');

            $('#datatable-basic').DataTable({
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                    aria: {
                        sortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    },
                    buttons: {
                        copy: 'Copiar',
                        colvis: 'Visibilidad',
                        print: 'Imprimir',
                        excel: 'Exportar Excel',
                        pdf: 'Exportar PDF'
                    }
                }
            });



            @foreach ($motorista->puntos_control as $item)
                // Inicializar el mapa cuando se abre la modal
                const modal{{ $item->id }} = document.getElementById('modalMapa-{{ $item->id }}');
                modal{{ $item->id }}.addEventListener('shown.bs.modal', function() {
                    const map{{ $item->id }} = L.map('mapa-{{ $item->id }}').setView(
                        [{{ $item->latitud }}, {{ $item->longitud }}],
                        16
                    );

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(map{{ $item->id }});

                    L.marker([{{ $item->latitud }}, {{ $item->longitud }}]).addTo(map{{ $item->id }})
                        .bindPopup("{{ ucfirst($item->tipo) }} - {{ $item->hora_reporte }}")
                        .openPopup();
                });

                // Destruir mapa al cerrar para evitar bugs
                modal{{ $item->id }}.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('mapa-{{ $item->id }}').innerHTML = "";
                });
            @endforeach


        });
    </script>
    <!-- End:: row-1 -->
@endsection
