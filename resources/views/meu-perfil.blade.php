@extends('layouts.app')

@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-3" id="imprimeCotacao">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Meus Dados <small>(Usuário cadastrado dia: {{$dados[0]->created_at}})</small></h5>
                    </div>
                    <div class="card-body">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>NOME</th>
                                    <th>EMAIL</th>
                                    <th>TELEFONE</th>
                                    <th>MEU IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>({{$dados[0]->nome}}) </td>
                                    <td>({{$dados[0]->email}}) </td>
                                    <td>({{$dados[0]->telefone}}) </td>
                                    <td>({{$dados[0]->ip}}) </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">MINHA MENSAGEM</h5>
                    </div>
                    <div class="card-body">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $dados[0]->mensagem }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">MEU ARQUIVO</h5>
                    </div>
                    <div class="card-body">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="{{ $dados[0]->arquivo }}" target="_blank" style="color:#333"><i class="far fa-file-alt"></i> {{ $dados[0]->arquivo }}</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-sm-flex justify-content-between">
                    <div class="card-footer-link mb-4 mb-sm-0">
                        <p class="card-text text-dark d-inline">
                            <a href="{{route('pessoas')}}" style="color:#333"><i class="fas fa-undo-alt"></i> Ver lista completa</a>
                            <a href="{{route('home')}}" style="color:#333"><i class="fas fa-address-card"></i> Cadastrar novo usuário</a>

                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-primary">Voltar para página anterior</a>

                </div>
            </div>
        </div>
    </div>



@endsection
