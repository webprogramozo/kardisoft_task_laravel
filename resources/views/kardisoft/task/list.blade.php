@extends('kardisoft.frame')
@section('content')
    @csrf
    <div class="container">
        <h1 class="mt-3">Gyógyszerlista</h1>
        <div class="col-lg-7 px-0">
            <p>Használja a keresőmezőt a lista szűréséhez!</p>
            <hr>
            <div class="input-group input-group-lg">
                <span class="input-group-text">Keresés:</span>
                <input type="text" class="form-control" id="searchbar" placeholder="Kezdjen el gépelni..">
            </div>
            <table class="table mt-3">
                <thead><tr><th>Találati lista</th></tr></thead>
                <tbody id="resultset">
                <tr><td>Itt fog megjelenni a keresés eredménye</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal" id="med_loader_modal" data-state="waiting">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Gyógyszeradatbázis betöltése</h5>
                    <button type="button" class="btn-close med-loader-hide-on-waiting" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 med-loader-message med-loader-message-waiting">A betöltési folyamat elkezdődött. <span title="Még ha fúj is a szél">Ne zárja be az ablakot</span>!</p>
                    <p class="mb-0 med-loader-message med-loader-message-success">A gyógyszeradatbázis betöltése megtörtént! (összesen <span id="med_all_count"></span> elem, hibák száma: <span id="med_error_count"></span>)</p>
                    <p class="mb-0 med-loader-message med-loader-message-failure">Hiba történt a feldolgozás közben!</p>
                </div>
                <div class="modal-footer med-loader-hide-on-waiting">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal" tabindex="-1" id="med_info_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gyógyszer információ: <span id="med_name_label"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-info">
                        <tr>
                            <td>Nyilvántartási szám:</td>
                            <td><span id="med_reg_number_label"></span></td>
                        </tr>
                        <tr>
                            <td>Hatóanyag:</td>
                            <td><span id="med_active_ingredient_label"></span></td>
                        </tr>
                        <tr>
                            <td>ATC kód:</td>
                            <td><span id="med_atc_code_label"></span></td>
                        </tr>
                        <tr>
                            <td>Készítmény engedélyezésének dátuma:</td>
                            <td><span id="med_auth_date_label"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                </div>
            </div>
        </div>
    </div>
@endsection
