@extends('layouts.app')

@section('content')


    <div class="row g-5">
    <div class="col-md-12">
        <h4 class="mb-3">Insira os dados corretamente.</h4>
        <form method="POST" enctype="multipart/form-data" action="{{route('pessoa.store')}}" onsubmit="return validaArquivo()" class="needs-validation">
            @csrf
          <div class="row g-3">
            <div class="col-sm-12  mt-4">
              <label  class="form-label">Seu nome</label>
              <input type="text" class="form-control nome" name="nome" placeholder="" value="" required>
            </div>

            <div class="col-sm-6  mt-4">
              <div class="input-group">
                <span class="input-group-text">@</span>
                <input type="email" onchange="validateEmail()" id="email" class="form-control email" name="email" placeholder="Insira seu E-mail" required>
              </div>
            </div>

            <div class="col-sm-6  mt-4">
              <div class="input-group">
                <span class="input-group-text">#</span>
                <input type="text" onkeypress="return allowOnlyNumbers(event)" onchange="validaTelefone()" id="telefone" class="form-control telefone" name="telefone" placeholder="DDD + Telefone" required>
              </div>
            </div>

            <div class="col-sm-12  mt-4">
              <label  class="form-label">Escreva sua mensagem</label>
              <textarea  class="form-control mensagem"  name="mensagem" required></textarea>
            </div>

            <div class="col-sm-12 mt-4">
              <label  class="form-label">Anexe seu arquivo:  <small style="color:red">Extenções aceitas: 'pdf','doc','odt','txt' - <b>TAMANHO MAXIMO DO ARQUIVO 500kb</b></small></label><br />
              <input type="file" id="arquivo" name="arquivo" class="arquivo" >
            </div>
          </div>
            <input type="hidden" name="ip"  value="{{Request::ip()}}">
          <button class="w-100 btn btn-primary btn-lg mt-4" type="submit">Salvar dados</button>
        </form>
      </div>



    </div>


@endsection
