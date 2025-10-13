<div class="modal fade" id="modalMapa-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $item->id }}">
                    Ubicación del punto #{{ $item->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="mapa-{{ $item->id }}" style="height: 450px; width: 100%;"></div>
            </div>
            <div class="modal-footer bg-light">
                <small class="text-muted">
                    Lat: {{ $item->latitud }} | Lng: {{ $item->longitud }} | Tipo: {{ ucfirst($item->tipo) }}
                </small>
                <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
