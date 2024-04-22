<!-- Modal para mostrar la respuesta -->
<div class="modal fade" id="modal-query-response" tabindex="-1" aria-labelledby="modal-query-response" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title">Respuesta del query</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="query-response"></p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Botón para activar el modal y mostrar la respuesta -->
  <button type="button" id="show-query-response-modal" class="d-none" data-bs-toggle="modal" data-bs-target="#modal-query-response"></button>
@section('js')

@endsection