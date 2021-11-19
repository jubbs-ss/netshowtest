<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory;

class testForm extends DuskTestCase
{
    public function testAddRegisterSuccess()
    {
        // Gerador de dados falsos
        $faker = Factory::create('pt_BR');

        $this->browse(function (Browser $browser) use ($faker) {
            $name = $faker->name;
            $email = $faker->email;
            $phone = $faker->phone;
            $msg = '$faker->phone';
            $filePath = env('APP_URL').'/files/arquivopessoal-'.$email.'.pdf';

            $browser->visit('/') // Acessa a rota que de cadastro
                ->attach('input.arquivo', 'public\files\teste.pdf')
                ->type('input.nome', $name) // Preenche nome
                ->type('input.email', $email) // Preenche email
                ->type('input.telefone', '1146530330') // Preenche email
                ->type('textarea.mensagem', $msg) // Preenche email
                ->press('Salvar dados') // Clica em "Salvar"
                ->assertSee($filePath) // Testa se o email preenchido está na lista
                ->assertSee($name) // Testa se o nome preenchido está na lista
                ->assertSee($email) // Testa se o email preenchido está na lista
                ->assertSee('1146530330') // Testa se o email preenchido está na lista
                ->assertSee($msg); // Testa se o email preenchido está na lista
        });
    }
}
