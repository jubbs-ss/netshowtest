@extends('layouts.app')

@section('content')

<div class="container-fluid">
                
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="example" class="table student-data-table m-t-20" style="min-width: 100%">
                                <thead>
                                    <tr>
                                        <th>NOME</th>
                                        <th>TELEFONE</th>
                                        <th>IP</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($pessoa as $key => $res)
                                    <tr>

                                        <td>{{ $res->nome }}<br /><small>{{ $res->email }}</td>
                                        <td>({{ $res->telefone }}) </td>
                                        <td>({{ $res->ip }}) </td>
                                        
                                        <td style="width:60px">
                                            <a title="Ver registro" href="{{ route('pessoa.show',$res->id) }}"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mt-5">
                                <nav aria-label="Page navigation example">
                                    Paginação:
                                    <ul class="pagination" >
                                        <li class="page-item"><a class="page-link" href="{{ $pessoa->previousPageUrl() }}">Anterior</a></li>

                                        @for($i = 1; $i <= $pessoa->lastPage(); $i++)
                                            <li class="page-item {{ $pessoa->currentPage() == $i ? 'active' : '' }}"><a class="page-link" href="{{ $pessoa->url($i) }}">{{ $i }}</a></li>
                                        @endfor

                                        <li class="page-item"><a class="page-link" href="{{ $pessoa->nextPageUrl() }}">Próxima</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="card-footer d-sm-flex justify-content-between">
                    <div class="card-footer-link mb-4 mb-sm-0">
                        <p class="card-text text-dark d-inline">
                            <a href="{{route('pessoas')}}" style="color:#333"><i class="fas fa-undo-alt"></i> Ver lista completa</a>
                            <a href="{{route('home')}}" style="color:#333"><i class="fas fa-address-card"></i> Cadastrar novo usuário</a>
                        </p>
                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-primary">Voltar para página anterior</a>

                </div>
                    </div>
                </div>

            </div>



@endsection
