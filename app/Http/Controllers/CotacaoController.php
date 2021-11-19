<?php

namespace App\Http\Controllers;

use App\Models\Cotacao;
use App\Models\Carro;
use App\Models\Cliente;
use Illuminate\Http\Request;
use DateTime;
use DB;
use Redirect;
use Illuminate\Support\Facades\Mail;
use Exception;

class CotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(count($request->request->all())  > 0 && isset($request->request->all()['campo'])){
            $cotacao = DB::table('cotacaos')
            ->where($request->request->all()['campo'], 'LIKE', $request->request->all()['valor'])
            ->paginate(30);

        }
        else{
            $cotacao = DB::table('cotacaos')
            ->paginate(30);
        }






        return  view('all-cotacoes',['cotacao' => $cotacao]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    public function historico(Request $request)
    {
        $dadosEnviados = $request->all();

        $msgsalva = date('d-m-Y').' - '.$dadosEnviados['msg_alteracao'].'<br />';

        $msg = DB::table('cotacaos')
        ->where('id', $dadosEnviados['historico_anotacao'])
        ->update(['msg_alteracao'=>DB::raw("CONCAT(IFNULL(msg_alteracao,''),'$msgsalva')")],$msgsalva);


        return redirect()->route('cotacao.show',['cotacao' => $dadosEnviados['historico_anotacao']]);


    }

    public function cadastrar()
    {
        $carros = Carro::get();
        $clientes = Cliente::get();
        //dd($carros);
        return  view('create-cotacao',['carros' => $carros,'clientes' => $clientes]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function uploadFilePlanilha(Request $request)
    {

        $file = new \SplFileObject($request->file('arquivo')->getPathname(), 'r');
        $linha = new \SplFileObject($request->file('arquivo')->getPathname(), 'r');

        // Coloca o ponteiro na segunda linha do arquivo
        $file->seek(0);
        // continue o laço até que seja o fim da linha
        $contador = 0;
        $falhas = 0;
        //die($linesTotal.'-------');
        while ($file->eof() === false) {

            $reg = $file->fgetcsv();
            $reg = str_replace('"','',$reg);
            $reg = str_replace('\n','',$reg);
            $registro = explode(';', $reg[0]);

            $registro[1] = isset($registro[1]) ? addslashes($registro[1]) : '';
            $registro[2] = isset($registro[2]) ? addslashes($registro[2]) : '';
            $registro[3] = isset($registro[3]) ? addslashes($registro[3]) : '';
            $registro[4] = isset($registro[4]) ? addslashes($registro[4]) : '';
            $registro[5] = isset($registro[5]) ? addslashes($registro[5]) : '';
            $registro[6] = isset($registro[6]) ? addslashes($registro[6]) : '';
            $registro[7] = isset($registro[7]) ? addslashes($registro[7]) : '';
            $registro[8] = isset($registro[8]) ? addslashes($registro[8]) : '';
            $registro[9] = isset($registro[9]) ? addslashes($registro[9]) : '';
            $registro[10] = isset($registro[10]) ? addslashes($registro[10]) : '';
            $registro[11] = isset($registro[11]) ? addslashes($registro[11]) : '';
            $registro[12] = isset($registro[12]) ? addslashes($registro[12]) : '';

            $registro[5] = str_replace('/','-',$registro[5]);
            $data_locacao = date("Y-m-d", strtotime($registro[5]));

            $registro[6] = str_replace('/','-',$registro[6]);
            $data_locacao = date("Y-m-d", strtotime($registro[5]));


            //print_r($data_locacao).'<hr />';

            $data_devolucao = explode('/',$registro[6]);
            $data_devolucao =  date("Y-m-d", strtotime($registro[6]));




            //TRATAMENTO DE CAMPOS
            if(isset($registro[0][1]) && isset($registro[1][1]) && isset($registro[2][1]) && isset($registro[3][1]) && isset($registro[4][1]) && isset($registro[5][1]) && isset($registro[6][1]) && isset($registro[7][1]) && isset($registro[8][1]) && isset($registro[9][1]) && isset($registro[10][1]) && isset($registro[11][1]) && isset($registro[12][1]))
            {
                $insert = DB::table('cotacaos')->insert(
                    ['cliente_id' => $registro[0],
                    'nome' => $registro[1],
                    'placa' => $registro[2],
                    'chassi' => $registro[3],
                    'renavam' => $registro[4],
                    'data_locacao' => $data_locacao,
                    'data_devolucao' => $data_devolucao,
                    'condutor' => $registro[7],
                    'email_condutor' => $registro[8],
                    'montadora' => $registro[9],
                    'modelo' => $registro[10],
                    'cor' => $registro[11],
                    'canal_de_vendas' => $registro[12],
                    'status' => 1]
                );
                $contador ++;
            }
            else
            {
                $falhas++;
            }






            /*
            //TRATAMENTO DE CAMPOS
            $reg[1] = isset($reg[1]) ? addslashes($reg[1]) : '';
            $reg[2] = isset($reg[2]) ? addslashes($reg[2]) : '';
            $reg[3] = isset($reg[3]) ? addslashes($reg[3]) : '';


            $registro[3] = isset($registro[4]) ? $registro[3].' - '.$registro[4].', '.$reg[1].' '.$reg[2].' - '.$reg[3] : $registro[3];
            $registro[0] = addslashes($registro[0]);
            $registro[3] = addslashes($registro[3]);
            */

        }
        return redirect()->route('cotacao.index',['registros' => $contador, 'falhas' => $falhas]);

    }

    public function store(Request $request)
    {
        $cotacao = Cotacao::create($request->all());
        return redirect()->route('cotacao.show',['cotacao' => $cotacao->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */

    public function updateStatus($status, $registro)
    {

        $msg = DB::table('cotacaos')
        ->where('id', $registro)
        ->update(['status'=>$status]);


        return view('send-email');
    }

    public function sendcontrato(Request $request)
    {

        $dados = $request->all();

        $msg = '
                <h1>Informações que o cliente enviou:</h1>
                <p>Contrato: '.$dados['contrato'].'</p>
                <p>Placa: '.$dados['placa'].'</p>
                <p>CPF/CNPJ: '.$dados['cpf_cnpj'].'</p>
                <p>Nome: '.$dados['nome'].'</p>
                <p>Telefone: '.$dados['telefone'].'</p>
                <p>WhatsApp: '.$dados['whatsapp'].'</p>
                <p>Email:' .$dados['email'].'</p>
        ';

        \Illuminate\Support\Facades\Mail::send(new \App\Mail\SendMailUser(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'),$msg));
        return Redirect::to('https://fleetbrasil.com.br');

    }


    public function show(Cotacao $cotacao)
    {
        $dados = DB::table('cotacaos')
        ->where('cotacaos.id', '=', $cotacao->id)
        ->get();
        // dd($dados);

        $status = array(
            1 => 'Vigente',
            2 => 'Aguardando extensão',
            3 => 'Aguardando renovação',
            4 => 'Aguardando ligação',
            5 => 'Aguardando venda',
            6 => 'Aguardando desmobilização',
            7 => 'Finalizado'
        );

        return view('cotacao-detalhes',['cotacao'=>$cotacao, 'dados' => $dados,'status' => $status[$cotacao->status]]);

     /* @param  \App\Models\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */
    }
    public function sendstatus()
    {
        $dados = DB::table('cotacaos')
            ->where('status','1')->get();
        //dd($dados);


        foreach($dados as $res)
        {
            $hoje = new DateTime(date('Y-m-d'));
            $data = new DateTime($res->data_devolucao);
            $interval = $hoje->diff($data);
            $dias = 0;
            $email = false;
            $links = '';
            $diascontados= $interval->d;
            if($interval->d == 120)
            {
                //msg 1
                $dias = 120;
                $email = true;
                $link1 = env('APP_URL').'/cotacao/status/update/3/'.$res->id;
                $link2 = env('APP_URL').'/cotacao/status/update/2/'.$res->id;
                $link3 = env('APP_URL').'/cotacao/status/update/5/'.$res->id;
                $links = '
                <a  class="btn btn-primary" href="'.$link1.'">Desejo renovar</a>
                <a  class="btn btn-primary" href="'.$link2.'">Desejo estender</a>';
            }
            else if($interval->d == 90)
            {
                //msg 2
                $dias = 90;
                $email = true;
                $link1 = env('APP_URL').'/cotacao/status/update/3/'.$res->id;
                $link2 = env('APP_URL').'/cotacao/status/update/2/'.$res->id;
                $link3 = env('APP_URL').'/cotacao/status/update/5/'.$res->id;
                $links = '
                <a  class="btn btn-primary" href="'.$link1.'">Desejo renovar</a>
                <a  class="btn btn-primary" href="'.$link2.'">Desejo estender</a>';
            }
            else if($interval->d == 60)
            {
                //msg 3
                $dias = 60;
                $email = true;
                $link1 = env('APP_URL').'/cotacao/status/update/3/'.$res->id;
                $link2 = env('APP_URL').'/cotacao/status/update/2/'.$res->id;
                $link3 = env('APP_URL').'/cotacao/status/update/5/'.$res->id;
                $links = '
                <a  class="btn btn-primary" href="'.$link1.'">Desejo renovar</a>
                <a  class="btn btn-primary" href="'.$link2.'">Desejo estender</a>';
            }
            else if($interval->d == 58 || $interval->d == 55 || $interval->d == 50)
            {
                //msg 3
                $dias = $interval->d;
                $email = true;
                $link1 = env('APP_URL').'/cotacao/status/update/3/'.$res->id;
                $link2 = env('APP_URL').'/cotacao/status/update/2/'.$res->id;
                $link3 = env('APP_URL').'/cotacao/status/update/5/'.$res->id;
                $links = '
                <a  class="btn btn-primary" href="'.$link1.'">Desejo renovar</a>
                <a  class="btn btn-primary" href="'.$link2.'">Desejo estender</a>';
            }
            else if($interval->d == 30)
            {
                $dias = 30;
                $email = true;
                $link1 = env('APP_URL').'/cotacao/status/update/3/'.$res->id;
                $link2 = env('APP_URL').'/cotacao/status/update/2/'.$res->id;
                $link3 = env('APP_URL').'/cotacao/status/update/5/'.$res->id;
                $link4 = env('APP_URL').'/cotacao/status/update/6/'.$res->id;
                $links = '
                <a  class="btn btn-primary" href="'.$link1.'">Desejo renovar</a>
                <a  class="btn btn-primary" href="'.$link2.'">Desejo estender</a>
                <a  class="btn btn-primary" href="'.$link3.'">Desejo comprar</a>
                <a  class="btn btn-primary" href="'.$link4.'">Aguardando desmobilização</a>';
            }
            else if($interval->d == 15)
            {
                $dias = 15;
                $email = true;
                $link1 = env('APP_URL').'/cotacao/status/update/3/'.$res->id;
                $link2 = env('APP_URL').'/cotacao/status/update/2/'.$res->id;
                $link3 = env('APP_URL').'/cotacao/status/update/5/'.$res->id;
                $link4 = env('APP_URL').'/cotacao/status/update/6/'.$res->id;
                $links = '
                <a  class="btn btn-primary" href="'.$link1.'">Desejo renovar</a>
                <a  class="btn btn-primary" href="'.$link2.'">Desejo estender</a>
                <a  class="btn btn-primary" href="'.$link3.'">Desejo comprar</a>
                <a  class="btn btn-primary" href="'.$link4.'">Aguardando desmobilização</a>';
            }
            else if($interval->d == 5)
            {
                $dias = 5;
                $email = true;
                $link1 = env('APP_URL').'/cotacao/status/update/3/'.$res->id;
                $link2 = env('APP_URL').'/cotacao/status/update/2/'.$res->id;
                $link3 = env('APP_URL').'/cotacao/status/update/5/'.$res->id;
                $link4 = env('APP_URL').'/cotacao/status/update/6/'.$res->id;
                $links = '
                <a  class="btn btn-primary" href="'.$link1.'">Desejo renovar</a>
                <a  class="btn btn-primary" href="'.$link2.'">Desejo estender</a>
                <a  class="btn btn-primary" href="'.$link3.'">Desejo comprar</a>
                <a  class="btn btn-primary" href="'.$link4.'">Aguardando desmobilização</a>';
            }
            /*1 => 'Vigente',
            2 => 'Aguardando extensão',
            3 => 'Aguardando renovação',
            4 => 'Aguardando ligação',
            5 => 'Aguardando venda',
            6 => 'Aguardando desmobilização',
            7 => 'Finalizado'*/

            $emailenvio = $res->email_condutor;
            $nome = $res->nome;

            $msg = '<h2>Olá '.$nome.', faltam '.$dias.' dias para o término da sua locação.</h2>
            <h3>Deseja renovar ou prorrogar seu contrato?</h3>
            '.$links;

            //return new \App\Mail\SendMailUser($res->email,$res->nome,$msg);
            if($email)
            {
                //$res->email,$res->nome

                \Illuminate\Support\Facades\Mail::send(new \App\Mail\SendMailUser($emailenvio,$nome,$msg));
            }


        }



     /* @param  \App\Models\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */
    }
    public function edit(Cotacao $cotacao)
    {
        $carros = Carro::get();
        $clientes = Cliente::get();
        return view('edit-cotacao', ['cotacao' => $cotacao,'carros' => $carros,'clientes' => $clientes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotacao $cotacao)
    {
        $cotacao->update($request->all());
        return redirect()->route('cotacao.show',['cotacao' => $cotacao->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cotacao  $cotacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotacao $cotacao)
    {
        $cotacao->delete();
        return redirect()->route('cotacoes',['cotacao' => $cotacao]);
    }
}
